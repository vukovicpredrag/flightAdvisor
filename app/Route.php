<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{

    protected $guarded = [];

    public function sourceAirport(){

        return $this->belongsTo(Airport::class, 'source_airport_id', 'airport_id');

    }


    public function destinationAirport(){

        return $this->belongsTo(Airport::class, 'destination_airport_id', 'airport_id');

    }


    //Distance calculator
    public function distance($lat1, $lon1, $lat2, $lon2) {

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            return ($miles * 1.609344);

        }
    }

}
