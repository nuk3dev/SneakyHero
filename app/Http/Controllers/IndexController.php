<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller {
    public function index() {

        $player = DB::table('player')
                ->orderBy('highestscore', 'desc')
                ->limit(5)
                ->get();
        return view('welcome')->with(['players' => $player]);
    }

    public function InsertAjaxData(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'secondsplayed' => 'required|numeric',
        ]);
    
        $data = [
            'name' => $request->input('username'),
            'highestScore' => $request->input('secondsplayed'),
        ];
    
        DB::table('player')->insert($data);

        return response()->json(['success' => true]);
    }
}



