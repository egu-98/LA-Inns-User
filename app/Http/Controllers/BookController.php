<?php

namespace App\Http\Controllers;

use App\Book;
use App\Plan;
use App\Inn;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

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
        $inn = Inn::find( $request->inn_id );
        return view( 'book.pre_create', [ 'user_id' => $request->user_id, 'inn_id' => $request->inn_id, 'plans' => $plans, 'inn_name' => $inn->name ] );
    }

    public function create( Request $request )
    {   
        // validation
        $this->validate( $request, [
            'checkin_date' => 'required',
            'checkout_date' => 'required',
            'plan' => 'required',
            'rooms' => 'integer|required|min:1',
        ] );

        // room availability validation 
        $inn = Inn::find( $request->inn_id );
        $bookings = Book::where( 'inn_id', $request->inn_id )->where( 'checkout_date', '>=', $request->checkin_date )->
                        where( 'checkin_date', '<=', $request->checkout_date )->orderBy('checkin_date', 'asc')->get(); 
        
        $begin = new DateTime( $request->checkin_date );
        $end = new DateTime( $request->checkout_date );
        $diff = $end->diff( $begin );
        $vacant_rooms = array();
        for( $i = 0; $i < $diff->days + 1; $i++ ){
            $vacant_rooms[ $begin->format( 'Y-m-d' ) ] = $inn->rooms;
            $begin->modify( '+1 day' );
        }
        
        // days when reservations are already full.
        $impossible_days = array(); 
        foreach( $bookings as $booking ){

            $begin = new DateTime( $request->checkin_date );
            $end = new DateTime( $request->checkout_date );
            
            $begin_other = new DateTime( $booking->checkin_date );
            $end_other = new DateTime( $booking->checkout_date );

            $end_other->modify( '-1 day' );
            if( $begin < $begin_other ) $begin = $begin_other;
            if( $end > $end_other ) $end = $end_other;

            $rooms = $booking->rooms;
            while( $begin <= $end ){
                $vacant_rooms[ $begin->format( 'Y-m-d' ) ] -= $rooms;
                if( $vacant_rooms[ $begin->format( 'Y-m-d' ) ] <= 0 ){
                    $impossible_days[] = $begin->format( 'Y???m???d???' ) ;
                }
                $begin->modify( '+1 day' );
                
            }
        }
        
        // error messerge
        $room_error = array();
        $rdays = array();
        if( count( $impossible_days ) > 0 ){
            $room_error[] =  $impossible_days[ 0 ];
            for( $i = 1; $i < count( $impossible_days ); $i++ ){
                $room_error[ 0 ] .= ", " . $impossible_days[ $i ];
            }
            $room_error[ 0 ] .= "??????????????????????????????????????????";  
        }

        foreach( $vacant_rooms as $key => $vr){
            if( $vr < $request->rooms && $vr > 0 ){
                $rdays[] = new DateTime( $key );
            }
        }

        if( count( $rdays ) > 0 ){
            for( $i = 0; $i < count( $rdays ); $i++ ){
                $date = $rdays[ $i ]->format( 'Y???m???d???' );
                $room_error[] = $date . "??????????????????" . $vacant_rooms[ $rdays[ $i ]->format( 'Y-m-d' ) ] . "???????????????";
            }
        }
        
        // room capacity
        if( $inn->rooms < $request->rooms ) $room_error[] = '????????????' . $inn->rooms . '?????????????????????';
        
        $erorr_count = count( $room_error );
        if( $erorr_count > 0 ){
            $plans = Plan::where( 'inn_id', $request->inn_id )->get();
            return view( 'book.pre_create', [ 'user_id' => $request->user_id, 'inn_id' => $request->inn_id, 'plans' => $plans, 'inn_name' => $inn->name, 'room_error' => $room_error ] );
        }


        // make a booking
        $book = new Book;
        $book->user_id = $request->user_id;
        $book->inn_id = $request->inn_id;
        $plan_id = explode( '_', $request->plan );
        $book->plan_id = $plan_id[ 0 ];
        $book->rooms = $request->rooms;
        $book->checkin_date = $request->checkin_date;
        $book->checkout_date = $request->checkout_date;

        $checkin_date = $begin->format( 'Y???m???d???' );
        $checkout_date = $end->format( 'Y???m???d???' );
        
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
        return view( 'book.done_booking' );
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
        $checkin_date = $checkin_date[ 0 ] . "??? " . (int)$checkin_date[ 1 ] . "??? " . (int)$checkin_date[ 2 ] . "???";

        $checkout_date = explode( '-', $book->checkout_date );
        $checkout_date = $checkout_date[ 0 ] . "??? " . (int)$checkout_date[ 1 ] . "??? " . (int)$checkout_date[ 2 ] . "???";
        
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
