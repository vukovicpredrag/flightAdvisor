@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4> Comments for {{ $city -> name }}  </h4>
                        </div>

                    </div>
                </div>

                <div class="card ">

                    <div class="card-body">

                    <input type="hidden" name="city_id" value="{{ $city->id }}">

                        <select class="form-control comments-number" name="limit"  >
                            <option value="">All</option>
                            <option @if(isset($_GET['limit']) && $_GET['limit'] == 1) selected @endif value="1">1</option>
                            <option @if(isset($_GET['limit']) && $_GET['limit'] == 5) selected @endif value="5">5</option>
                            <option @if(isset($_GET['limit']) && $_GET['limit'] == 10) selected @endif value="10">10</option>

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

                            </div><hr>


                            @php $comments = $city->comments; if(isset($_GET['limit']) && $_GET['limit'] != ''){ $comments = $city->comments->take($_GET['limit']); } @endphp

                            @foreach( $comments as $comment )

                                <div class="comment">

                                    <div class="card ">

                                        <div class="card-body">

                                            <textarea disabled class="form-control comment-text">{{ $comment -> text }}</textarea><br>

                                            @if( Auth::user()->id == $comment->user_id )
                                                <button data-url="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger delete-comment">Delete</button>
                                                <button data-url="{{ route('comments.update', $comment->id) }}"  type="submit" class="btn btn-primary edit-comment">Edit</button>
                                            @endif

                                            <small class="float-right">  <b>{{ $comment->user->name }}</b> | created: {{ $comment->created_at->diffForHumans() }} </small>  <br>
                                            <small class="float-right updated-comment"> @if( $comment->created_at != $comment->updated_at) updated: {{  $comment->updated_at->diffForHumans() }} @endif </small>

                                      </div>
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

             </div>

         </div>

    </div>






@endsection


