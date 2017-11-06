<?php

namespace App\Repository\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentUsersRepository implements UsersRepository
{
    public function search( $query = '')
    {
        return User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }
}
