<?php

namespace App\GraphQL\Queries;

use App\Models\Product;

class ProductQuery
{
    public function listProducts($root, array $args)
    {
        $query = Product::query();
        if (isset($args['search'])) {
            $query->where('name', 'like', '%' . $args['search'] . '%');
        }
        if (isset($args['category_id'])) {
            $query->where('category_id', $args['category_id']);
        }
        if (isset($args['sort'])) {
            switch ($args['sort']) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }
        $page = $args['page'] ?? 1;
        $count = $args['count'] ?? 10;
        return $query->paginate($count, ['*'], 'page', $page);
    }
}
