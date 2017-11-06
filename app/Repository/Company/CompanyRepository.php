<?php

namespace App\Repository\Company;

use Illuminate\Database\Eloquent\Collection;

interface CompanyRepository
{
    public function search( $query = "");
}