<?php

namespace App\Services;

use App\Models\MainCategory;
use App\Models\SubCategory;

class CategoryService
{
    private MainCategory $mainCategory;
    private SubCategory $subCategory;

    public function __construct(MainCategory $mainCategory, SubCategory $subCategory)
    {
        $this->mainCategory = $mainCategory;
        $this->subCategory = $subCategory;
    }

    // Main Category Operations
    public function createMainCategory(array $data): int
    {
        return $this->mainCategory->create($data);
    }

    public function getMainCategory(int $id): ?array
    {
        return $this->mainCategory->findById($id);
    }

    public function updateMainCategory(int $id, array $data): bool
    {
        return $this->mainCategory->updateById($data, $id);
    }

    public function deleteMainCategory(int $id): bool
    {
        return $this->mainCategory->delete($id);
    }

    public function getAllMainCategories(): array
    {
        return $this->mainCategory->all();
    }

    // Sub Category Operations
    public function createSubCategory(array $data): int
    {
        return $this->subCategory->create($data);
    }

    public function getSubCategory(int $id): ?array
    {
        return $this->subCategory->findById($id);
    }

    public function updateSubCategory(int $id, array $data): bool
    {
        return $this->subCategory->updateById($data, $id);
    }

    public function deleteSubCategory(int $id): bool
    {
        return $this->subCategory->delete($id);
    }

    public function getAllSubCategories(): array
    {
        return $this->subCategory->all();
    }

    // Relationship Operations
    public function getSubCategoriesByMainCategory(int $mainCategoryId): array
    {
        // Assuming you have a method in SubCategory model to fetch by main category ID
        return $this->subCategory->findByMainCategory($mainCategoryId);
    }

    public function getMainCategoryWithSubCategories(int $mainCategoryId): array
    {
        $mainCategory = $this->mainCategory->findById($mainCategoryId);
        if (!$mainCategory) {
            return [];
        }

        $mainCategory['sub_categories'] = $this->getSubCategoriesByMainCategory($mainCategoryId);
        return $mainCategory;
    }

    // Statistics Operations
    public function getCategoryStatistics(): array
    {
        return [
            'total_main_categories' => count($this->mainCategory->all()),
            'total_sub_categories' => count($this->subCategory->all()),
            'main_categories_with_most_sub_categories' => $this->getMainCategoriesWithMostSubCategories(),
        ];
    }

    public function getMainCategoriesWithMostSubCategories(int $limit = 5): array
    {
        return $this->mainCategory->getMainCategoriesWithMostSubCategories($limit);
    }

    // Search Operations
    // public function searchMainCategories(string $term): array
    // {
    //     // Assuming your BaseModel has a search method
    //     return $this->mainCategory->search(['cate_name', 'description'], $term);
    // }

    // public function searchSubCategories(string $term): array
    // {
    //     // Assuming your BaseModel has a search method
    //     return $this->subCategory->search(['cate_name', 'key_words', 'description'], $term);
    // }

    // Bulk Operations
    public function bulkCreateSubCategories(int $mainCategoryId, array $subCategories): array
    {
        $results = [];
        foreach ($subCategories as $subCategory) {
            $subCategory['main_cate_id'] = $mainCategoryId;
            $results[] = $this->subCategory->create($subCategory);
        }
        return $results;
    }

    // Validation Operations
    public function validateMainCategoryData(array $data): array
    {
        $errors = [];

        if (empty($data['cate_name'])) {
            $errors['cate_name'] = 'Category name is required';
        } elseif (strlen($data['cate_name']) > 255) {
            $errors['cate_name'] = 'Category name must be 255 characters or less';
        }

        return $errors;
    }

    public function validateSubCategoryData(array $data): array
    {
        $errors = [];

        if (empty($data['main_cate_id'])) {
            $errors['main_cate_id'] = 'Main category ID is required';
        }

        if (empty($data['cate_name'])) {
            $errors['cate_name'] = 'Category name is required';
        } elseif (strlen($data['cate_name']) > 255) {
            $errors['cate_name'] = 'Category name must be 255 characters or less';
        }

        return $errors;
    }
}