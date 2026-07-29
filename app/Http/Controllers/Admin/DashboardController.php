<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetData;
use App\Models\News;
use App\Models\PopulationData;
use App\Models\User;
use App\Models\Leader;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'pending_approval' => News::where('status', 'submitted')->count(),
            'draft_news' => News::where('status', 'draft')->count(),
            'rejected_news' => News::where('status', 'rejected')->count(),
            'total_users' => User::count(),
            'total_leaders' => Leader::count(),
        ];

        $pendingApprovals = News::with(['author', 'category'])
            ->where('status', 'submitted')
            ->latest()
            ->take(4)
            ->get();

        $recentNews = News::with(['author', 'category'])
            ->latest()
            ->take(4)
            ->get();

        $latestPopulation = PopulationData::latest('year')->first();
        $latestBudgetYear = BudgetData::max('year');

        $budgetSummary = null;
        if ($latestBudgetYear) {
            $budgetSummary = [
                'year' => $latestBudgetYear,
                'total_income' => BudgetData::forYear($latestBudgetYear)->income()->sum('amount'),
                'total_expense' => BudgetData::forYear($latestBudgetYear)->expense()->sum('amount'),
            ];
        }

        return view('admin.dashboard', compact('stats', 'pendingApprovals', 'recentNews', 'latestPopulation', 'budgetSummary'));
    }
}

