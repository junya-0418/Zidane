<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Repositories\Match\MatchRepositoryInterface;

use App\Post;
use App\Team;
use App\Match;
use App\Player;
use App\User;
use App\Mvp;
use App\Evaluation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MatchRepositoryInterface $match_repository)
    {
        $this->match_repository = $match_repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showMatches() {

        $matches = $this->match_repository->getMatchesForSearch();

        return $matches;
    }

    public function getPlayerRanking() {

        //選手の評価の平均点
        $player_ranking = DB::table('posts')
            ->join('evaluations', 'posts.id', '=', 'evaluations.posts_id')
            ->join('players', 'evaluations.player_id', '=', 'players.id')
            ->join('matches', 'posts.match_id', '=', 'matches.id')
            ->where('match_type', 'J1 第1節')
            ->select(DB::raw('players.team_id, number, name, player_id, AVG(evaluation) as player_evaluation_average'))
            ->groupBy('player_id')
            ->orderBy('player_evaluation_average', 'desc')
            ->take(5)
            ->get();

        return $player_ranking;

    }

}
