<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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
