@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card-header">

                    <div class="row">

                        <div class="col-md-12">

                            <h4>Flight Finder | find the cheapest flights</h4>

                        </div>

                    </div>
                </div>

                <div class="card"><br>

                    <div class="card-body">

                        <form action="{{ route('find.flight') }}" method="GET">

                        <div class="row">

                            <div class="col-md-1">

                                <p class="float-right"> <b> From: </b> </p>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <select name="cityFrom" id="cityFrom" class="form-control">

                                        <option  value="-1" selected> All </option>

                                        @if(isset($airportFrom))

                                            <option value="{{ $airportFrom -> city }}" selected> {{ $airportFrom -> city }} ( {{$airportFrom -> country  }} )</option>

                                        @endif

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-1 float-right">

                                <p class="float-right"><b> To: </b></p>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <select name="cityTo" id="cityTo" class="form-control">

                                        <option  value="-1" selected> All </option>

                                        @if(isset($airportTo))

                                            <option value="{{ $airportTo -> city }}" selected> {{ $airportTo -> city }} ( {{$airportTo -> country  }} )</option>

                                        @endif

                                    </select>

                                    <input type="hidden" id="citySearch" data-cites-url="{{ route('city.list') }}">

                                </div>

                            </div>

                            <div class="col-md-2">

                                <button type="submit" class="btn btn-primary" id="findFlight"> <i class="fas fa-search"></i> Find</button>

                            </div>


                        </div>

                        </form><br>

                        @if( isset($cheapestRoutes) && count($cheapestRoutes) )

                        <div class="row">

                            @foreach( $cheapestRoutes as $route )

                                <div class="col-md-4" style="margin-bottom: 20px">

                                    <div class="card">

                                        <div class="card-body">

                                            <p><b>{{ $route->sourceAirport->city }}</b> ( {{ $route->sourceAirport->name }} ) </p>
                                            <i class="fa fa-arrow-circle-down flight-arrow" aria-hidden="true" ></i>
                                            <p><b> {{ $route->destinationAirport->city }}</b>  ( {{ $route->destinationAirport->name }} )</p>
                                            <p><b>Price: </b> {{ $route->price }} </p>

                                        </div>

                                    </div>

                                </div>

                                <i class="fa fa-arrow-right flight-arrow-middle" aria-hidden="true"></i>

                            @endforeach

                                <div class="card" style="margin-left: 20px">

                                    <div class="card-body" style="text-align: center">

                                        <i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color:green;"></i><br><br>
                                        <p>TOTAL PRICE: <b> {{ $priceSum }} </b></p> <hr>
                                        <p><i>Distance: {{ $distanceSum }} kilometers </i></p>

                                    </div>

                                </div>

                            </div>

                        @endif

                        @if (isset($noFlight))

                            <div class="alert alert-danger"> No flights for this route </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection


