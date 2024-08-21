<?php
namespace App\GraphQL\Queries;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderQuery
{
    public function orderHistory($root, array $args)
    {
        $user = Auth::user();
        $query = Order::query()
            ->where('user_id', $user->id);

        if (isset($args['status'])) {
            $query->where('status', $args['status']);
        }
        if (isset($args['sort'])) {
            $sort = $args['sort'];
            $direction = 'asc';

            if (str_ends_with($sort, '_desc')) {
                $sort = str_replace('_desc', '', $sort);
                $direction = 'desc';
            }

            $query->orderBy($sort, $direction);
        }
        $page = $args['page'] ?? 1;
        $count = $args['count'] ?? 10;
        return $query->get();
    }
}

