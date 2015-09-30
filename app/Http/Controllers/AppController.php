<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Thujohn\Twitter\Facades\Twitter;

use App\SearchHistory;

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
    public function getTweets($lat, $long)
    {
        $data = [];

        $geo = json_decode($this->getGeoID($lat, $long));

        $search_status = Twitter::getSearch([
            'q'         =>  'place:'.$geo->id,
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

        SearchHistory::create([
            'place_id' => $geo->id,
            'place_name' => $geo->name,
            'lat' => $lat,
            'long' => $long,
            'tweets' => $data
            ]);

        return json_encode($data);
    }

    /**
     * Search tweets and save to database for caching
     *
     */
    public function search(Request $request)
    {
        $tweets = json_decode($this->getTweets($request->lat, $request->long));

        return \Response::json($tweets);
    }

}
