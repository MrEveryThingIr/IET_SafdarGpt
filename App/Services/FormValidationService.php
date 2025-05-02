<?php
namespace App\Services;

class FormValidationService {
    public static function validateDemandForm(array $data): array {
        $errors = [];

        if (empty($data['supply_demand'])) $errors['supply_demand'] = 'انتخاب عرضه یا تقاضا الزامی است.';
        if (empty($data['category'])) $errors['category'] = 'دسته‌بندی الزامی است.';
        if (empty($data['goods_services'])) $errors['goods_services'] = 'نوع مورد الزامی است.';
        if (empty($data['title']) || str_word_count($data['title']) < 2) $errors['title'] = 'عنوان معتبر وارد کنید.';

        return $errors;
    }
}
