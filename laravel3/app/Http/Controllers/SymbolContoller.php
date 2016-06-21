<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\math_symbol;

class SymbolContoller extends Controller
{
    //
    public function throwSymbols(){
    	$symbols = math_symbol::all();
    	return view('pages.myfirstjs',compact('symbols'));
    }
}
