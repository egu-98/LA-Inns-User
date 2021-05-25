<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Inn;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $books = $user->books()->get();
        
        $inn_names = [];
        foreach( $books as $book ){
            $inn = Inn::find( $book->inn_id );
            $inn_names[] = $inn->name;
        }

        return view( 'user.index', [ 'user' => $user, 'books' => $books, 'inn_names' => $inn_names ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( User $user )
    {
        $user = User::find( $user->id );
        return view( 'user.edit', [ 'user' => $user ] );
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
        $user = User::find( $id );
        if( isset($request->name) ) $user->name = $request->name;
        if( isset($request->email) ) $user->email = $request->email;
        if( isset($request->password) ) $user->password = $request->password;
        $user->save();
        // userのidを外部キーにbooksテーブルから予約情報を取得する
        $books = [];
        return redirect( route( 'users.index', [ 'user' => $user, 'books' => $books ] ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
