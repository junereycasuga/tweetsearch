<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;

class SearchHistory extends Eloquent
{
    protected $collection = 'search_history';
    protected $fillable = ['cookie_id', 'search_term', 'lat', 'lng', 'tweets'];
}
