<?php
namespace App\GraphQL\Queries;

use App\Models\Category;
use Exception;

class CategoryQuery
{
    public function listCategories()
    {
        try {
            return Category::whereNull('parent_id')
                ->with('subcategories')
                ->get();
        } catch (Exception $e) {
            throw new \Exception('Failed to load categories.');
        }
    }
}

