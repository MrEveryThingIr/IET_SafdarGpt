<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleBlock;

class ArticleService
{
    protected Article $articleModel;
    protected ArticleBlock $blockModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->blockModel = new ArticleBlock();
    }

    /**
     * Create a new article and return its ID
     */
    public function createArticle(array $data): int
    {
        return $this->articleModel->create($data);
    }

    /**
     * Add a block to an article
     */
    public function addBlock(int $articleId, array $blockData): int
    {
        $blockData['article_id'] = $articleId;

        // Assign next order automatically
        $blockData['block_order'] = $this->blockModel->getMaxOrder($articleId) + 1;

        return $this->blockModel->create($blockData);
    }

    /**
     * Add a compacted block group (e.g., heading + paragraph)
     */
    public function addContentSection(int $articleId, string $heading, string $paragraph, ?int $headingLevel = 2): array
    {
        $order = $this->blockModel->getMaxOrder($articleId);

        $blocks = [];

        // Heading block
        $blocks[] = $this->blockModel->create([
            'article_id' => $articleId,
            'block_order' => ++$order,
            'block_type' => 'heading',
            'content' => $heading,
            'heading_level' => $headingLevel
        ]);

        // Paragraph block
        $blocks[] = $this->blockModel->create([
            'article_id' => $articleId,
            'block_order' => ++$order,
            'block_type' => 'paragraph',
            'content' => $paragraph
        ]);

        return $blocks;
    }

    /**
     * Get full article with blocks, grouped in logical sections
     */
    public function getFullArticleWithSections(int $id): ?array
    {
        $article = $this->articleModel->findById($id);
        if (!$article || $article['deleted_at']) {
            return null;
        }

        $blocks = $this->blockModel->getByArticleId($id);

        // Group blocks by compact sections (e.g., heading + paragraph)
        $sections = [];
        $currentSection = [];

        foreach ($blocks as $block) {
            if ($block['block_type'] === 'heading') {
                if (!empty($currentSection)) {
                    $sections[] = $currentSection;
                }
                $currentSection = ['heading' => $block, 'content' => []];
            } elseif (in_array($block['block_type'], ['paragraph', 'image', 'list', 'quote'])) {
                $currentSection['content'][] = $block;
            } else {
                $sections[] = ['single_block' => $block];
            }
        }

        if (!empty($currentSection)) {
            $sections[] = $currentSection;
        }

        $article['structured_blocks'] = $sections;
        return $article;
    }

    /**
     * Delete an article and all its blocks
     */
    public function deleteArticle(int $id): bool
    {
        $this->blockModel->deleteByArticleId($id);
        return $this->articleModel->delete($id);
    }

    /**
     * Update article and optionally its blocks
     */
    public function updateArticle(int $id, array $articleData, array $blockUpdates = []): bool
    {
        $updated = $this->articleModel->updateById($articleData, $id);

        foreach ($blockUpdates as $blockId => $blockData) {
            $this->blockModel->updateById($blockData, $blockId);
        }

        return $updated;
    }

    /**
     * Search articles by criteria
     */
    public function searchArticles(array $criteria = [], array $likeFields = [], string $likeValue = '', array $options = []): array|int
    {
        return $this->articleModel->searchBy($criteria, $likeFields, $likeValue, $options);
    }

    /**
     * List latest articles with a limit
     */
    public function listLatest(int $limit = 10): array
    {
        return $this->articleModel->all($limit);
    }


    /**
     * Retrieve single article by slug
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->articleModel->findBySlug($slug);
    }
}
