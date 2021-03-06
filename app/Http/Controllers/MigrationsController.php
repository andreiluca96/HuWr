<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanMigration as Migration;
use Auth;
use Twitter;

class MigrationsController extends Controller
{
    public function store(Request $request)
    {
        $migration = new Migration;
        $departure = app('geocoder')->geocode($request->input('state-departure').', '.$request->input('country-departure'))->all()[0];
        $arrival = app('geocoder')->geocode($request->input('state-destination').', '.$request->input('country-destination'))->all()[0];

        $migration->departure_country = $departure->getCountryCode();
        $migration->departure_city = $departure->getLocality();
        $migration->departure_longitude = $departure->getCoordinates()->getLongitude();
        $migration->departure_latitude = $departure->getCoordinates()->getLatitude();

        $migration->arrival_country = $arrival->getCountryCode();
        $migration->arrival_city = $arrival->getLocality();
        $migration->arrival_longitude = $arrival->getCoordinates()->getLongitude();
        $migration->arrival_latitude = $arrival->getCoordinates()->getLatitude();

        $migration->adults = $request->input('number-of-adults');
        $migration->children = $request->input('number-of-children');

        $migration->reason = $request->input('reason');

        $migration->user_id = Auth::id();

        $migration->save();

        if ($request->input('twitter-share')) {
            $tweet = 'Migrated from '
                    .$migration->departure_city
                    .', '
                    .$migration->departure_country
                    .' to '
                    .$migration->arrival_city
                    .', '
                    .$migration->arrival_country
                    .' with '
                    .$migration->adults
                    .' adults  and '
                    .$migration->children
                    .' children because of '
                    .$migration->reason
                    .' #HuWr.';
            Twitter::postTweet(['status' => $tweet, 'format' => 'json']);
        }

        return back();
    }
}
