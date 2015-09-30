<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class SearchHistory extends Eloquent
{
    protected $collection = 'search_history';
    protected $fillable = ['place_id', 'place_name', 'tweets'];
}
