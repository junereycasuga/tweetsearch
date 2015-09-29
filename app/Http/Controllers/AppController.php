<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Thujohn\Twitter\Facades\Twitter;

class AppController extends Controller
{

    /**
     * Search Geolocation data
     *
     * @param varchar lat
     * @param varchar long
     * @return json
     */
    private function getGeoID($lat, $long)
    {
        $result = [];
        $geo = Twitter::getGeoSearch([
            'lat'           =>  $lat,
            'long'          =>  $long,
            'granularity'   =>  'city',
            'format'        =>  'array'
            ]);

        $result['id'] = $geo['result']['places'][0]['id'];
        $result['name'] = $geo['result']['places'][0]['name'];

        return json_encode($result);
    }

    /**
     * Search tweets by place.
     *
     * @param varchar   lat
     * @param varchar   long
     * @return json
     */
    private function getTweets($lat, $long)
    {
        $data = [];

        $geo = $this->getGeoID('14.6839606', '121.0622039');

        $search_status = Twitter::getSearch([
            'q'         =>  'place:'.$geo['id'],
            'format'    =>  'array'
            ]);

        foreach($search_status['statuses'] as $status) {
            $arr = [];

            $arr['id'] = $status['id'];
            $arr['text'] = $status['text'];
            $arr['user']['id'] = $status['user']['id'];
            $arr['user']['name'] = $status['user']['name'];
            $arr['user']['screen_name'] = $status['user']['screen_name'];
            $arr['user']['image'] = $status['user']['profile_image_url_https'];
            $arr['coordinates'] = $status['coordinates']['coordinates'];

            array_push($data, $arr);
        }

        return $data;
    }

    /**
     * Search tweets and save to database for caching
     *
     */
    public function search($lat, $long)
    {
        $tweets = $this->getTweets($lat, $long);

        return $tweets;
    }

}
