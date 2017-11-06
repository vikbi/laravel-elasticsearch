<?php

namespace App\Repository\Profile;

use App\Profile;
use Illuminate\Database\Eloquent\Collection;

class EloquentProfileRepository implements ProfileRepository
{
    public function search( $query = '')
    {
        return Profile::where('name', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->orWhere('company_name', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->orWhere('education', 'like', "%{$query}%")
            ->get();
    }
}
