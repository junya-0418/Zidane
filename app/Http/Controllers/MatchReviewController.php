<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Team;
use App\Match;
use App\Post;
use App\Mvp;
use App\Player;

class MatchReviewController extends Controller
{

    public function index($id) {

        $teams = Team::all();
        $match = Match::find($id);
        $home_team_id = $match->home_team_id;
        $away_team_id = $match->away_team_id;

        //mvp数集計
        $mvp_outputs = DB::table('mvps')
            ->join('players', 'mvps.player_id', '=', 'players.id')
            ->join('posts', 'mvps.posts_id', '=', 'posts.id')
            ->where('match_id', $match->id)
            ->select(DB::raw('players.team_id, player_id, number, name, count(*) as player_count'))
            ->groupBy('player_id')
            ->get();

        //選手の評価の平均点
        $user_evaluation_outputs = DB::table('posts')
            ->join('evaluations', 'posts.id', '=', 'evaluations.posts_id')
            ->join('players', 'evaluations.player_id', '=', 'players.id')
            ->where('match_id', $match->id)
            ->select(DB::raw('players.team_id, number, name, player_id, AVG(evaluation) as player_evaluation_average'))
            ->groupBy('player_id')
            ->get();

        $home_team_evaluation_outputs = $user_evaluation_outputs->where('team_id', '=', $home_team_id)->sortBy('number');

        $away_team_evaluation_outputs = $user_evaluation_outputs->where('team_id', '=', $away_team_id)->sortBy('number');

        //ホームチームに投稿したユーザーとアウェイチームに投稿したユーザーを取ってくる
        $users = DB::table('posts')
            ->join('users', 'posts.user_id', 'users.id')
            ->where('match_id', $match->id)
            ->get();

        $home_team_users = $users->where('team_id', $home_team_id);
        $away_team_users = $users->where('team_id', $away_team_id);

        return view('matchReview',
            compact('teams', 'match', 'mvp_outputs', 'home_team_evaluation_outputs', 'away_team_evaluation_outputs', 'home_team_users', 'away_team_users'));

    }
}
