<?php

namespace App\Services;

use App\Models\IETAnnounce;
use App\Models\IETAnnounceComment;

class IETAnnounceService
{
    protected $announceModel;
    protected $commentModel;

    public function __construct()
    {
        $this->announceModel = new IETAnnounce();
        $this->commentModel = new IETAnnounceComment();
    }

    /**
     * Create a new announce record.
     *
     * @param array $data
     * @return int
     */
    public function createAnnounce(array $data): int
    {
        // Validate required fields
        $this->validateAnnounceData($data);

        // Create the announce
        return $this->announceModel->create($data);
    }

    /**
     * Update an existing announce record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateAnnounce(int $id, array $data): bool
    {
        // Validate required fields
        $this->validateAnnounceData($data);

        // Update the announce
        return $this->announceModel->updateById($data, $id);
    }

    /**
     * Fetch all announces.
     *
     * @return array
     */
    public function getAllAnnounces(): array
    {
        return $this->announceModel->all();
    }

    /**
     * Fetch a specific announce by ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getAnnounceById(int $id): ?array
    {
        return $this->announceModel->findById($id);
    }

    /**
     * Delete an announce by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteAnnounce(int $id): bool
    {
        return $this->announceModel->delete($id);
    }

    /**
     * Fetch announces by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getAnnouncesByUserId(int $userId): array
    {
        return $this->announceModel->getByUser($userId);
    }

    /**
     * Fetch announces with filtering options.
     *
     * @param string $supplyDemand
     * @param array $keywords
     * @param string $goodsServices
     * @param int|null $subCategoryId
     * @return array
     */
    public function filterAnnounces(string $supplyDemand = '', array $keywords = [], string $goodsServices = '', ?int $subCategoryId = null): array
    {
        return $this->announceModel->specified($supplyDemand, $keywords, $goodsServices, $subCategoryId);
    }

    /**
     * Add a comment to an announce.
     *
     * @param array $data
     * @return int
     */
    public function addComment(array $data): int
    {
        // Validate required fields
        $this->validateCommentData($data);

        // Create the comment
        return $this->commentModel->create($data);
    }

    /**
     * Fetch comments by announce ID.
     *
     * @param int $announceId
     * @return array
     */
    public function getCommentsByAnnounceId(int $announceId): array
    {
        return $this->commentModel->getByAnnounceId($announceId);
    }

    /**
     * Fetch comments by user ID (commentor).
     *
     * @param int $userId
     * @return array
     */
    public function getCommentsByCommentorId(int $userId): array
    {
        return $this->commentModel->getByCommentorId($userId);
    }

    /**
     * Fetch commentor details for a comment.
     *
     * @param int $commentorId
     * @param string $feature
     * @return array|string|null
     */
    public function fetchCommentor(int $commentorId, string $feature = '')
    {
        return $this->commentModel->fetchCommentor($commentorId, $feature);
    }

    /**
     * Validate announce data.
     *
     * @param array $data
     * @return void
     * @throws \Exception
     */
    protected function validateAnnounceData(array $data): void
    {
        if (empty($data['user_id']) || empty($data['supply_demand']) || empty($data['goods_services']) || empty($data['title']) || empty($data['unit'])) {
            throw new \Exception('Required fields are missing for the announce.');
        }

        if (!in_array($data['supply_demand'], ['supply', 'demand'])) {
            throw new \Exception('Invalid supply/demand value.');
        }

        if (!in_array($data['goods_services'], ['goods', 'services'])) {
            throw new \Exception('Invalid goods/services value.');
        }
    }

    /**
     * Validate comment data.
     *
     * @param array $data
     * @return void
     * @throws \Exception
     */
    protected function validateCommentData(array $data): void
    {
        if (empty($data['commentor_id']) || empty($data['announce_id']) || empty($data['comment'])) {
            throw new \Exception('Required fields are missing for the comment.');
        }
    }


    /**
 * Fetch announces by user ID with optional filters.
 *
 * @param int $userId
 * @param array $filters
 * @return array
 */
public function getAnnouncesByUserWithFilters(int $userId, array $filters = []): array
{
    return $this->announceModel->getFilteredByUser($userId, $filters);
}

}