<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Report;
use App\Models\Answer;
use App\Models\Comment;

class AdminController extends Controller
{
    public function stats() {
    
        $stats = [
            'num_questions' => Question::count(),
            'num_answers' => Answer::count(),
            'num_comments' => Comment::count(),
            'num_users' => User::count(),
        ];

        return view('pages.admin', ['stats' => $stats]);
    }

    public function users() {

        $users = User::where('id', '!=', 1)->orderBy('username')->paginate(10);
        
        return view('partials._users', compact('users'))->render();
    }

    public function reports() {
        $reports = Report::orderBy('date', 'desc')->paginate(10);
    
        return view('partials._reports', compact('reports'))->render();
    }
    
    public function chart(Request $request) {
        switch ($request->type) {
            case 'questions':
                $postChartData = $this->getQuestionChartData();
                return response()->json($postChartData);
            case 'users':
                $userChartData = $this->getUserChartData();
                return response()->json($userChartData);
            case 'categories':
                $categoryChartData = $this->getCategoryChartData();
                return response()->json($categoryChartData);
            default:
                $gameChartData = $this->getGameChartData();
                return response()->json($gameChartData);
        }
    }

    private function getQuestionChartData() {
        
        $startDate = now()->subMonths(12); 
        $endDate = now(); 
    
        $labels = [];
        $data = [];
    
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addMonth()) {
            $month = $date->format('F'); 
            $labels[] = $month;
    
            $questionCount = Question::whereYear('create_date', $date->year)
                ->whereMonth('create_date', $date->month)
                ->count();
    
            $data[] = $questionCount;
        }
    
        $postChartData = [
            'labels' => $labels,
            'data' => $data,
        ];
    
        return $postChartData;
    }

    private function getUserChartData() {

        $bronzeCount = User::where('rank', 'Bronze')->count();
        $goldCount = User::where('rank', 'Gold')->count();
        $masterCount = User::where('rank', 'Master')->count();

        $data = [$bronzeCount, $goldCount, $masterCount];

        $userChartData = [
            'labels' => ['Bronze', 'Gold', 'Master'],
            'data' => $data,
        ];

        return $userChartData;
    }

    private function getCategoryChartData() {

        $categories = GameCategory::all();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $labels[] = $category->name; 
            $data[] = $category->games()->count(); 
        }

        $categoryChartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $categoryChartData;
    }

    private function getGameChartData(){

        $games = Game::orderByDesc('nr_members')
                 ->limit(20)
                 ->get();

        $labels = [];
        $data = [];

        foreach ($games as $game) {
            $labels[] = $game->name; 
            $data[] = $game->members()->count(); 
        }

        $gameChartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $gameChartData;
    }
}
