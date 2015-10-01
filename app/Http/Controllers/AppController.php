<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Thujohn\Twitter\Facades\Twitter;

use App\SearchHistory;

class AppController extends Controller
{

    public function __construct()
    {
        if(!isset($_COOKIE['id'])) {
            setcookie('id', rand().time(), time() + 60*60);
        }
    }

    /**
     * Search tweets by place.
     *
     * @param varchar   city
     * @param number    lat
     * @param number    lng
     * @return json
     */
    public function getTweets($city, $lat, $lng)
    {
        $city = strtoupper($city);
        $data = [];

        $tweets = SearchHistory::where('cookie_id', '=', $_COOKIE['id'])->where('search_term', '=', $city)->get();

        if(count($tweets) == 0) {
            $search_status = Twitter::getSearch([
                'q'         =>  $city,
                'geocode'   =>  $lat.",".$lng.",5km",
                'format'    =>  'array'
                ]);

            foreach($search_status['statuses'] as $status) {
                $arr = [];

                $arr['cookie_id'] = $_COOKIE['id'];
                $arr['id'] = $status['id'];
                $arr['text'] = $status['text'];
                $arr['tweeted_at'] = $status['created_at'];
                $arr['user']['id'] = $status['user']['id'];
                $arr['user']['name'] = $status['user']['name'];
                $arr['user']['screen_name'] = $status['user']['screen_name'];
                $arr['user']['image'] = $status['user']['profile_image_url_https'];
                $arr['coordinates']['lat'] = $status['coordinates']['coordinates'][0];
                $arr['coordinates']['lng'] = $status['coordinates']['coordinates'][1];

                if($arr['coordinates']['lng'] != null && $arr['coordinates']['lng'] != null) {
                    array_push($data, $arr);
                }
            }

            SearchHistory::create([
                'cookie_id' => $_COOKIE['id'],
                'search_term' => $city,
                'lat' => $lat,
                'lng' => $lng,
                'tweets' => $data
                ]);
        } else {
            $data = $tweets[0]->tweets;
        }

        return json_encode($data);
    }

    /**
     * Shows home page
     * 
     */
    public function index()
    {
        return view('app/search');
    }

    /**
     * Shows search history page
     * 
     */
    public function history()
    {
        $history = SearchHistory::where('cookie_id','=',$_COOKIE['id'])->get();

        return view('app/history', ['history' => $history]);
    }

    /**
     * Search tweets and save to database for caching
     * 
     * @param Request   $request
     */
    public function search(Request $request)
    {
        $tweets = json_decode($this->getTweets($request->city, $request->lat, $request->lng));

        return \Response::json($tweets);
    }
}
