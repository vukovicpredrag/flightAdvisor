@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card-header">
                    <form method="GET" action="{{ route('city.search') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <h4> Cities </h4>
                        </div>

                        <div class="col-md-5 pull-right">

                        </div>

                        <div class="col-md-3 pull-right">

                            <select name="city" class="form-control" id="citySearchBox">

                                <option  value="all" selected> All </option>

                                @foreach( \App\City::distinct('name')->get() as $city )

                                    <option @if(isset($_GET['$city']) && $_GET['$city'] == $city->name) selected @endif value="{{ $city->name }}" > {{ $city->name }} </option>

                                @endforeach

                            </select>

                        </div>
                        <div class="col-md-2 pull-right">

                            <button  type="submit" class="btn btn-primary">Search</button>

                        </div>

                    </div>
                    </form>
                </div>

                @if (session('status'))

                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>

                @endif

                @if(count($errors) > 0)

                    <div class="alert alert-danger">

                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>


                @endif

                @foreach( $cities as $city )

                    <div class="card">

                        <div class="card-body">

                            <h4>{{ $city -> name }}</h4><hr>

                            <p>{{ $city -> description }}</p>

                            <a class="float-right comments"  href="{{ route('comments.show', $city->id  ) }}"> comments ( {{ \App\Comment::where('city_id', $city->id)->count()  }} )</></a>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>


@endsection


