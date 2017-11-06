<?php

namespace App\Repository\User;

use Illuminate\Database\Eloquent\Collection;

interface UsersRepository
{
    public function search( $query = "");
}