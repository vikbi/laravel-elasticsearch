<?php

namespace App\Repository\Company;

use App\Company;
use Illuminate\Database\Eloquent\Collection;

class EloquentCompanyRepository implements CompanyRepository
{
    public function search( $query = '')
    {
        return Company::where('name', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->orWhere('size', 'like', "%{$query}%")
            ->orWhere('industry', 'like', "%{$query}%")
            ->orWhere('keywords', 'like', "%{$query}%")
            ->get();
    }
}
