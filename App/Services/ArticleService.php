<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleBlock;
use Exception;

class ArticleService
{
    private Article $articleModel;
    private ArticleBlock $blockModel;

    public function __construct()
    {
        $this->articleModel = new Article();
        $this->blockModel = new ArticleBlock();
    }

    /** Create an article with optional blocks */
    public function createArticle(array $data, array $blocks = []): int
    {
        $articleId = $this->articleModel->create($data);

        foreach ($blocks as $order => $block) {
            $block['article_id'] = $articleId;
            $block['block_order'] = $order;
            $this->blockModel->create($block);
        }

        return $articleId;
    }

    /** Update article and optionally its blocks */
    public function updateArticle(int $id, array $data, ?array $blocks = null): bool
    {
        $success = $this->articleModel->updateById($data, $id);

        if ($blocks !== null) {
            $this->blockModel->deleteByArticleId($id);

            foreach ($blocks as $order => $block) {
                $block['article_id'] = $id;
                $block['block_order'] = $order;
                $this->blockModel->create($block);
            }
        }

        return $success;
    }

    /** Delete article and cascade blocks */
    public function deleteArticle(int $id): bool
    {
        return $this->articleModel->delete($id);
    }

    /** Get article with its blocks */
    public function getArticleWithBlocks(int $id): ?array
    {
        $article = $this->articleModel->findById($id);
        if (!$article) return null;

        $blocks = $this->blockModel->getByArticleId($id);
        $article['blocks'] = $blocks;

        return $article;
    }

    /** Get all articles with optional limit */
    public function listArticles(int $limit = 50): array
    {
        return $this->articleModel->all( $limit);
    }

    /** Add a block to an article */
    public function addBlockToArticle(int $articleId, array $block): int
    {
        $block['article_id'] = $articleId;

        // Determine next block order
        $last = $this->blockModel->getMaxOrder($articleId);
        $block['block_order'] = $last + 1;

        return $this->blockModel->create($block);
    }

    /** Reorder blocks in an article */
    public function reorderBlocks(int $articleId, array $orderedIds): bool
    {
        foreach ($orderedIds as $index => $blockId) {
            $this->blockModel->updateById(['block_order' => $index], $blockId);
        }
        return true;
    }

    /** Search articles by criteria or keywords */
    public function searchArticles(array $filters = [], string $search = '', array $options = []): array|int
    {
        return $this->articleModel->searchBy($filters, ['title', 'key_words'], $search, $options);
    }

    /** Get blocks by article */
    public function getBlocksByArticle(int $articleId): array
    {
        return $this->blockModel->getByArticleId($articleId);
    }

    /** Get parent article for a block */
    public function getArticleForBlock(int $blockId): ?array
    {
        $block = $this->blockModel->findById($blockId);
        if (!$block) return null;

        return $this->articleModel->findById((int)$block['article_id']);
    }
}
