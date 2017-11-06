<?php

namespace App;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Searchable;

}
