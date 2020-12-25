<?php

namespace App\Helper;

use App\Airport;
use App\Route;
use Illuminate\Support\Facades\Storage;




/**
 * Import files and store to database
 * required txt file
 */


class ImportData
{

    static public function import($fileName, $type= 0)
    {

        set_time_limit(0);

        $path =  storage_path('app/files/'.$fileName);

        $file = new \SplFileObject( $path );

        if( !$file ){

            return redirect('home' )->with('status', 'File not fund!.');

        }


        while( !$file -> eof() ) {

            $columns = $file -> fgets();
            $columns = str_getcsv(  $columns );
            $columns = str_replace( '"', '', $columns );

            $data =[];

            foreach ( $columns as $column ){

                $data[] =  $column == '\N' ? $column = 0 : str_replace('"', '', $column);

            }

            //Import airports
            if($type == 'airports') {

                if (isset($data[2]) && $data[2] != '') {  //  Check if city exists

                    Airport::create([

                        'airport_id' => $data[0],
                        'name' => $data[1],
                        'city' => $data[2],
                        'country' => $data[3],
                        'iata' => $data[4],
                        'icao' => $data[5],
                        'latitude' => $data[6],
                        'lognitude' => $data[7],
                        'altitude' => $data[8],
                        'timezone' => $data[9],
                        'dts' => $data[10],
                        'tz' => $data[11],
                        'type' => $data[12],
                        'source' => $data[13],

                    ]);

                }

            }

            //Import routes
            if($type == 'routes') {

                if (isset($data[2]) && $data[2] != '') {  //  Check if city exists

                    Route::create([

                        'airline' => $data[0],
                        'airline_id' => $data[1],
                        'source_airport' => $data[2],
                        'source_airport_id' => $data[3],
                        'destination_airport' => $data[4],
                        'destination_airport_id' => $data[5],
                        'codeshare' => $data[6],
                        'stops' => $data[7],
                        'equipment' => $data[8],
                        'price' => $data[9],

                    ]);

                }

            }

        }


        $file = null;
       //Delete file from local storage
        unlink( storage_path('app/files/'.$fileName) );

    }



}

