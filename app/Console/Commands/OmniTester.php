<?php

namespace App\Console\Commands;

use App\Airport;
use App\Helper\Graph;
//include(app_path().'/Helper/Graph.php');

use App\Route;
//use Graph;



use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class OmniTester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omnitester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Only for testing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

//        $route = Route::find(1);
//
//        dd( $route -> sourceAirport -> name );

//
//        $file = new \SplFileObject( resource_path() . '/data/airports.txt' );
//
//        while( !$file -> eof() ) {
//
//            $columns = $file -> fgets();
//
//            $columns = str_getcsv(  $columns );
//
//            $columns = str_replace( '"', '', $columns );
//
//
//            $data =[];
//
//            foreach ( $columns as $column ){
//
//                $data[] =  $column == '\N' ? $column = 0 : str_replace('"', '', $column);
//
//            }
//
//
//            Airport::create([
//
//                'airport_id' => isset($data[0]),
//                'name'       => isset($data[1]),
//                'city'       => isset($data[2]),
//                'country'    => isset($data[3]),
//                'iata'       => isset($data[4]),
//                'icao'       => isset($data[5]),
//                'latitude'   => isset($data[6]),
//                'lognitude'  => isset($data[7]),
//                'altitude'   => isset($data[8]),
//                'timezone'   => isset($data[9]),
//                'dts'        => isset($data[10]),
//                'tz'         => isset($data[11]),
//                'type'       =>  isset($data[12]),
//                'source'     => isset($data[13]),
//
//            ]);
//
//        }


//        unlink( storage_path('app/files/airports-1608472645.txt') );


        function runTest() {
            $g = new Graph();

//                $route = Route::select(['*', DB::raw(('MIN(price) as min_price'))])->where('source_airport_id', 2912) ->where( 'destination_airport_id', 4029 ) -> get();
//
//            $route = Route::where('source_airport_id', 2912) ->where( 'destination_airport_id', 4029 )
//                ->groupBy(['source_airport_id', 'destination_airport_id'])
//                ->min('price');





////              STORE ROUTE TO JSON
//
//                $routes = Route::select(['*', DB::raw(('MIN(price) as min_price'))])->groupBy('source_airport_id', 'destination_airport_id' ) -> get();
//
//                foreach ( $routes as $route ){
//                     $g->addedge( $route->source_airport_id, $route->destination_airport_id, $route->min_price, $route->id );
//                }
//
//
//            $routesJson = json_encode( $g -> allNodes(), 1 );
//
//                                $file = storage_path('app/json/routes.json');
//                file_put_contents( $file, $routesJson );
//
////              END STORE ROUTE TO JSON




//
            list($distances, $prev, $ids ) = $g->paths_from(2965);

//            $distances =  $g->paths_from(2965)[0];
//            $prev =  $g->paths_from(2965)[1];

            $path = $g->paths_to($prev, 2990 , $ids );


            print_r($path);



        }


        runTest();


    }
}
