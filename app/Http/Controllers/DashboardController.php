<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function dashboard() {
        $all_data = DB::table('player')->select('player_id', 'name', 'highestscore')->get();
        return view('dashboard')->with(['data' => $all_data]);
    }
    public function editPlayerById($id) {
        $player = DB::table('player')->where('player_id', $id)->limit(1)->get();
        return view('edit_player_by_id')->with(["player" => $player]);
    }
    public function inserteditedplayer(Request $request, $id) {
        $request->validate([
            'username' => 'required',
            'highscore' => 'required|numeric',
        ]);
        $data = [
            'name' => $request->input('username'),
            'highestscore' => $request->input('highscore'),
        ];
        DB::table('player')->where('player_id', $id)->limit(1)->update($data);
        return redirect('/dashboard');
    }   

    public function insertPlayer(Request $request) {
        $request->validate([
            'username' => 'required',
            'highscore' => 'required|numeric',
        ]);
        $data = [
            'name' => $request->input('username'),
            'highestscore' => $request->input('highscore'),
        ];
        DB::table('player')->insert($data);
        return redirect('/dashboard');
    }

    public function deletePlayerById($id) {
        DB::table('player')->where('player_id', $id)->delete();
        return redirect('/dashboard');
    }
}
