@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">


                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            <h4> Cities </h4>
                        </div>

                        <div class="col-md-5 pull-right">

                        </div>

                        <div class="col-md-3 pull-right">

                            <input class="form-control" type="text" id="searchCity" placeholder="Search by city name">

                        </div>
                        <div class="col-md-2 pull-right">

                            <button class="btn btn-primary">Search</button>

                        </div>

                    </div>
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

                            <a class="float-right comments"  href="{{ route('comments.show', $city->id  ) }}">comments ( {{ \App\Comment::where('city_id', $city->id)->count()  }} )</></a>

                        </div>

                        <div class="card comments-box" style="display: none">

                            <div class="card-body">

                                <h4 class="comment-title">Comments </h4>

                                    <select class="form-control comments-number" name="comments_number"  data-url="{{ route('city.index') }}">
                                        <option value="all">All</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select><br>


                                <a href="" class="write-comment">Write a comment</a><br>

                                <div class="write-comment-box">

                                    <form action="{{ route('comments.store') }}" method="POST">
                                        {{ csrf_field() }}

                                        <textarea name="comment" class="form-control" rows="4" cols="50"> </textarea><br>
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="city_id" value="{{ $city->id }}">
                                        <button type="submit" class="btn btn-primary">Send</button>

                                    </form>

                                </div>

                                <hr>

{{--                                @php$comments = $commentNumber ? $city->comments->take($commentNumber) : $city->comments @endphp--}}

                                @foreach( $city->comments as $comment )

                                    <div class="comment">

                                        <textarea disabled class="form-control comment-text">{{ $comment -> text }}</textarea><br>

                                        @if( Auth::user()->id == $comment->user_id )
                                            <button data-url="{{ route('comments.destroy', $comment->id) }}" data-token="{{ csrf_token() }}" class="btn btn-danger delete-comment">Delete</button>
                                            <button data-url="{{ route('comments.update', $comment->id) }}" data-token="{{ csrf_token() }}" type="submit" class="btn btn-primary edit-comment">Edit</button>
                                        @endif

                                        <small class="float-right">  <b>{{ $comment->user->name }}</b> | <i>{{ $comment->created_at->diffForHumans() }}</i> </small>
                                        <hr style="clear:both">

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

                }}

            </div>

        </div>

    </div>
    <div id="overlay"></div>
    <div id="loader"></div>



@endsection


