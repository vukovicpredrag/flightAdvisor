<?php

namespace App\Http\Controllers;

use App\City;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {

        $this -> middleware( 'auth' );

    }


    public function store(Request $request)
    {
       $comment = $request->comment;
       $cityId  = $request->city_id;
       $useId   = $request->user_id;

       Comment::create([
           'text'    => $comment,
           'city_id' => $cityId,
           'user_id' => $useId
       ]);

        $city = City::find($cityId);

        return view( 'user.comments.index', compact( 'city'));


    }


    public function show($id)
    {
        $city = City::find($id);

        return view( 'user.comments.index', compact( 'city'));

    }


    public function update(Request $request, $id)
    {

        $commentText = $request->comment;

        $comment = Comment::find($id);
        $comment->text = $commentText;
        $comment->save();

        return json_encode([ 'status' => true, 'messaga' => 'Comment not found!' ]);

    }


    public function destroy($id)
    {

        $comment = Comment::find($id);

        if( $comment ){

            $comment->delete();

            return json_encode(['status' => true]);

        }

        return json_encode([ 'status' => false, 'messaga' => 'Comment not found!' ]);

    }

}
