<?php

namespace App\Helper;
use App\Route;


/**
 * Founding the cheapest flight between cities
 */


class FlightFinder {


    public $nodes = [];

    public function allNodes(){

        return $this->nodes;
    }


    public function addedge($start, $end, $price = 0, $id = 0) {

        if (!isset($this->nodes[$start])) {

            $this->nodes[$start] = array();

        }

        array_push($this->nodes[$start], $this->edge($start, $end, $price, $id));

    }


    public function start($startId, $endId)
    {

        list($distances, $prev, $ids) = $this->paths_from($startId);
        return $this->paths_to($prev, $endId);

    }


    public function edge( $start, $end, $price, $id )
    {

        $x = new \stdClass();

        $x->start = $start;
        $x->end   = $end;
        $x->price = $price;
        $x->id    = $id;

        return $x;

    }

    public function paths_from($from) {

        $ids = [];
        $dist = [];
        $visited = [];
        $previous = [];
        $dist[$from] = 0;

        $proprity = new PrioritySorting("compareWeights");
        $proprity->add(array($dist[$from], $from));

        //Include json route file
        $fileName = public_path('json/routes.json');
        $file = file_get_contents( $fileName );
        $nodes = json_decode( $file, true );

        while($proprity->size() > 0) {

            list($distance, $u) = $proprity->remove();
            if (isset($visited[$u])) { continue; }

            $visited[$u] = true;

            if(isset($nodes[$u])) {

                foreach ($nodes[$u] as $edge) {

                    $alt   = $dist[$u] + $edge['price'];
                    $end   = $edge['end'];
                    $ids[] = $edge['id'];

                    if (!isset($dist[$end]) || $alt < $dist[$end]) {

                        $previous[$end] = $u;
                        $dist[$end] = $alt;
                        $proprity->add(array($dist[$end], $end));

                    }

                }

            }

        }

        return array($dist, $previous, $ids );
    }

    public function paths_to($node_dsts, $tonode) {

        $path    = [];
        $routes  = [];
        $current = $tonode;

        //Check if node exits
        if (isset($node_dsts[$current])) {
            array_push($path, $tonode);
        }

        while(isset($node_dsts[$current])) {

            $routes[ $current ] = $node_dsts[$current];
            $nextnode = $node_dsts[$current];
            array_push($path, $nextnode);
            $current = $nextnode;

        }

        $reversed = array_reverse($routes, true);

        $finalArr = [];

        foreach ($reversed as $key => $value ){

            $minPrice = Route::where('source_airport_id', $value) ->where('destination_airport_id', $key)
                ->groupBy(['source_airport_id', 'destination_airport_id'])
                ->min('price');

            $finalArr[] = Route::where('source_airport_id', $value)->where('destination_airport_id', $key)->where('price', $minPrice)->first('id')->id;

        }

        return $finalArr;

    }

    public function getpath($from, $to) {

        list($distances, $prev) = $this->paths_from($from);
        return $this->paths_to($prev, $to);

    }


}





