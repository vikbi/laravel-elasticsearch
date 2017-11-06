<?php

namespace App\Repository\Profile;

use Illuminate\Database\Eloquent\Collection;

interface ProfileRepository
{
    public function search( $query = "");
}