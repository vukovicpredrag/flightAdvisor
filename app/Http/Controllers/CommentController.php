<?php

namespace App\Http\Controllers;

use App\City;
use App\Comment;
use Illuminate\Http\Request;
use function Sodium\compare;

class CommentController extends Controller
{
    public function __construct()
    {

        $this -> middleware( 'auth' );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);

        return view( 'user.comments.index', compact( 'city'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $commentText = $request->comment;

        $comment = Comment::find($id);
        $comment->text = $commentText;
        $comment->save();

        return json_encode([ 'status' => true, 'messaga' => 'Comment not found!' ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
