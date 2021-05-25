<?php

namespace App\Http\Controllers;

use App\Book;
use App\Plan;
use App\Inn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {     
        $plans = Plan::where( 'inn_id', $request->inn_id )->get();
        return view( 'book.index', [ 'user_id' => $request->user_id, 'inn_id' => $request->inn_id, 'plans' => $plans ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preCreateBook( Request $request )
    {     
        $plans = Plan::where( 'inn_id', $request->inn_id )->get();
        return view( 'book.pre_create', [ 'user_id' => $request->user_id, 'inn_id' => $request->inn_id, 'plans' => $plans ] );
    }

    public function create( Request $request )
    {   
        $book = new Book;
        $book->user_id = $request->user_id;
        $book->inn_id = $request->inn_id;
        $plan_id = explode( '_', $request->plan );
        $book->plan_id = $plan_id[ 0 ];
        $book->rooms = $request->rooms;
        $book->checkin_date = $request->checkin_date;
        $book->checkout_date = $request->checkout_date;

        $checkin_date = explode( '-', $book->checkin_date );
        $checkin_date = $checkin_date[ 0 ] . "年 " . (int)$checkin_date[ 1 ] . "月 " . (int)$checkin_date[ 2 ] . "日";

        $checkout_date = explode( '-', $book->checkout_date );
        $checkout_date = $checkout_date[ 0 ] . "年 " . (int)$checkout_date[ 1 ] . "月 " . (int)$checkout_date[ 2 ] . "日";
        
        $plan = Plan::find( $plan_id[ 0 ] );
        return view( 'book.create', [ 'book' => $book, 'plan' => $plan, 'checkin_date' => $checkin_date, 'checkout_date' => $checkout_date ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book;
        $book->user_id = $request->user_id;
        $book->inn_id = $request->inn_id;
        $plan_id = explode( '_', $request->plan );
        $book->plan_id = $plan_id[ 0 ];
        $book->rooms = $request->rooms;
        $book->checkin_date = $request->checkin_date;
        $book->checkout_date = $request->checkout_date;
        $book->save();

        $inn = Inn::find( $book->inn_id );
        $plans = $inn->plans()->get();
        $reviews = $inn->reviews()->get();
        return view( 'inn.show', [ 'inn' => $inn, 'plans' => $plans, 'reviews' => $reviews ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find( $id );

        $checkin_date = explode( '-', $book->checkin_date );
        $checkin_date = $checkin_date[ 0 ] . "年 " . (int)$checkin_date[ 1 ] . "月 " . (int)$checkin_date[ 2 ] . "日";

        $checkout_date = explode( '-', $book->checkout_date );
        $checkout_date = $checkout_date[ 0 ] . "年 " . (int)$checkout_date[ 1 ] . "月 " . (int)$checkout_date[ 2 ] . "日";
        
        $plan = Plan::find( $book->plan_id );
        $inn = Inn::find( $book->inn_id );
        return view( 'book.show', [ 'book' => $book, 'plan' => $plan, 'checkin_date' => $checkin_date, 'checkout_date' => $checkout_date, 'inn' => $inn ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        Book::find( $id )->delete();
        
        $user = Auth::user();
        $books = $user->books()->get();
        
        $inn_names = [];
        foreach( $books as $book ){
            $inn = Inn::find( $book->inn_id );
            $inn_names[] = $inn->name;
        }

        return view( 'user.index', [ 'user' => $user, 'books' => $books, 'inn_names' => $inn_names ] );
    }
}
