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

    // ──────────────────────────────
    // 📄 ARTICLE OPERATIONS
    // ──────────────────────────────

    public function createArticle(array $data): int
    {
        return $this->articleModel->create($data);
    }

    public function getArticleById(int $id): ?array
    {
        return $this->articleModel->findById($id);
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->articleModel->findBySlug($slug);
    }

    public function updateArticle(int $id, array $data): bool
    {
        return $this->articleModel->updateById($data, $id);
    }

    public function deleteArticle(int $id): bool
    {
        $this->blockModel->deleteByArticleId($id); // cascade, but explicit
        return $this->articleModel->delete($id);
    }

    public function listLatest(int $limit = 10): array
    {
        return $this->articleModel->all($limit);
    }

    public function searchArticles(array $criteria = [], array $likeFields = [], string $likeValue = '', array $options = []): array|int
    {
        return $this->articleModel->searchBy($criteria, $likeFields, $likeValue, $options);
    }

    public function getArticlesByCategories(array $categoryIds): array
    {
        return $this->articleModel->fetchByCategories($categoryIds);
    }

    public function getArticlesOfAUserId($user_id){
        $user_articles=$this->articleModel->getByAuthorId($user_id);
        return $user_articles;
    }

    public function getFullArticleWithSections(int $id): ?array
    {
        $article = $this->articleModel->getFullArticle($id);
        if (!$article) return null;

        $blocks = $article['blocks'] ?? [];

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

    // ──────────────────────────────
    // 🔲 BLOCK OPERATIONS
    // ──────────────────────────────

    public function addBlock(int $articleId, array $blockData): int
    {
        $blockData['article_id'] = $articleId;
        $blockData['block_order'] = $this->blockModel->getMaxOrder($articleId) + 1;
        return $this->blockModel->create($blockData);
    }

    public function updateBlock(int $blockId, array $data): bool
    {
        return $this->blockModel->updateById($data, $blockId);
    }

    public function deleteBlock(int $blockId): bool
    {
        return $this->blockModel->delete($blockId);
    }

    public function getBlockById(int $blockId): ?array
    {
        return $this->blockModel->findById($blockId);
    }

    public function getBlocksByArticleId(int $articleId): array
    {
        return $this->blockModel->getByArticleId($articleId);
    }

    public function deleteAllBlocksForArticle(int $articleId): bool
    {
        return $this->blockModel->deleteByArticleId($articleId);
    }

    public function reorderBlocks(int $articleId, array $blockIdsInOrder): bool
    {
        $order = 0;
        foreach ($blockIdsInOrder as $blockId) {
            $this->blockModel->updateById(['block_order' => ++$order], $blockId);
        }
        return true;
    }

    public function addContentSection(int $articleId, string $heading, string $paragraph, ?int $headingLevel = 2): array
    {
        $order = $this->blockModel->getMaxOrder($articleId);
        $blocks = [];

        $blocks[] = $this->blockModel->create([
            'article_id' => $articleId,
            'block_order' => ++$order,
            'block_type' => 'heading',
            'content' => $heading,
            'heading_level' => $headingLevel
        ]);

        $blocks[] = $this->blockModel->create([
            'article_id' => $articleId,
            'block_order' => ++$order,
            'block_type' => 'paragraph',
            'content' => $paragraph
        ]);

        return $blocks;
    }

    public function getMaxBlockOrder(int $articleId): int
    {
        return $this->blockModel->getMaxOrder($articleId);
    }

    // ──────────────────────────────
    // 🔍 Composite Methods
    // ──────────────────────────────

    public function updateArticleWithBlocks(int $articleId, array $articleData, array $blockDataMap): bool
    {
        $ok = $this->articleModel->updateById($articleData, $articleId);
        foreach ($blockDataMap as $blockId => $data) {
            $this->blockModel->updateById($data, $blockId);
        }
        return $ok;
    }

    public function duplicateArticle(int $id): ?int
    {
        $original = $this->articleModel->findById($id);
        if (!$original) return null;

        unset($original['id'], $original['slug']);
        $original['title'] .= ' (Copy)';
        $newId = $this->createArticle($original);

        $blocks = $this->blockModel->getByArticleId($id);
        foreach ($blocks as $block) {
            unset($block['id']);
            $block['article_id'] = $newId;
            $this->blockModel->create($block);
        }

        return $newId;
    }
}
