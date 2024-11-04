<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
            case 'email':
                return $query->where($column, $data);
            default:
                return $query;
        }
    }
}
