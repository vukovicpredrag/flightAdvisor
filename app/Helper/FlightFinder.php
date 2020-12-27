<?php

namespace App\Helper;
use App\Route;


/**
 * Founding the cheapest flight between cities
 * Include all possible routes and steps
 */


class FlightFinder {


    public $nodes = [];

    public function allNodes(){

        return $this->nodes;
    }


    public function start($startId, $endId)
    {

        $pathsFrom = $this->paths_from($startId);

        return $this->paths_to($pathsFrom, $endId);

    }


    public function paths_to($nodes, $toNode) {

        $path    = [];
        $routes  = [];
        $current = $toNode;

        //Check if node exits
        if (isset($nodes[$current])) {
            array_push($path, $toNode);
        }

        while(isset($nodes[$current])) {

            $routes[ $current ] = $nodes[$current];
            $nextNode = $nodes[$current];
            array_push($path, $nextNode);
            $current = $nextNode;

        }

        $reversed = array_reverse($routes, true);

        $finalRoutes = [];

        foreach ($reversed as $key => $value ){

            //Group flights to the destination and get one with the lowest price
            $minPrice = Route::where('source_airport_id', $value)
                ->where('destination_airport_id', $key)
                ->orderBy('price','asc')
                ->first();

            $finalRoutes[] = $minPrice -> id;

        }

        return $finalRoutes;

    }

    public function paths_from($from) {

        $dist = [];
        $visited = [];
        $previous = [];
        $dist[$from] = 0;

        $priority = new PrioritySorting();
        $priority->add(array($dist[$from], $from));

        //Include routes
        $fileName = public_path('json/routes.json');
        $file = file_get_contents( $fileName );
        $nodes = json_decode( $file, true );

        while($priority->size() > 0) {

            list($distance, $u) = $priority->remove();
            if(isset($visited[$u])) { continue; }
            $visited[$u] = true;

            if(isset($nodes[$u])) {
                foreach ($nodes[$u] as $edge) {
                    $alt = $dist[$u] + $edge['price'];
                    $end = $edge['end'];

                    if (!isset($dist[$end]) || $alt < $dist[$end]) {

                        $previous[$end] = $u;
                        $dist[$end]     = $alt;
                        $priority->add(array($dist[$end], $end));

                    }
                }
            }
        }

        return $previous;

    }


    public function addedge($start, $end, $price = 0) {

        if (!isset($this->nodes[$start])) {

            $this->nodes[$start] = [];

        }

        array_push($this->nodes[$start], $this->edge($start, $end, $price));

    }


    public function edge( $start, $end, $price )
    {

        $x = new \stdClass();
        $x->start = $start;
        $x->end   = $end;
        $x->price = $price;

        return $x;

    }


}





