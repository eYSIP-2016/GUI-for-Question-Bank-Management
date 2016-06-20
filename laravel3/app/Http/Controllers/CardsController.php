<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;	

use \App\card;

use DB;
use Log;

class CardsController extends Controller
{
    public function index () {

    	$cards = card::all();
    	Log::info($cards);

    	return view('cards.index',compact('cards'));
    }

    public function showCard(card $id) {
    	$card=DB::find($id);
    	return view('cards.show',compact('card'));
    }
}
