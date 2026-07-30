<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VillageProfile;
use App\Models\PopulationData;
use App\Models\BudgetData;
use App\Models\HeroSlide;
use App\Models\Leader;
use App\Models\News;
use App\Models\Category;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::current();
        $latestPopulation = PopulationData::latest('year')->first();
        
        // Hero Slides
        $slides = HeroSlide::active()->ordered()->take(3)->get();

        // Leaders
        $leaders = Leader::where('is_active', true)->orderBy('sort_order')->get();

        // Kades for sambutan card
        $kades = Leader::where('is_active', true)->orderBy('sort_order')->first();

        $latestNews = News::with(['author', 'category'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Galeri Kegiatan Desa (6 Foto Terbaru)
        $galleries = Gallery::active()->latest()->take(6)->get();
            
        // Budget Summary
        $budgetSummary = null;
        $latestBudgetYear = BudgetData::max('year');
        if ($latestBudgetYear) {
            $budgetData = BudgetData::where('year', $latestBudgetYear)->get();
            $income = $budgetData->where('type', 'income');
            $expense = $budgetData->where('type', 'expense');
            $budgetSummary = [
                'year' => $latestBudgetYear,
                'total_income' => $income->sum('amount'),
                'total_expense' => $expense->sum('amount'),
                'income' => $income,
                'expense' => $expense,
            ];
        }

        // UMKM Desa Bawangan
        $umkmList = [
            ['nama' => 'Batik', 'deskripsi' => 'Karya seni lokal khas desa bawangan yang ikonik dan berkarakter.', 'ikon' => '🍂'],
            ['nama' => 'Kerajinan Kayu', 'deskripsi' => 'Aneka perabotan dan hiasan dari kayu berkualitas buatan pengrajin lokal.', 'ikon' => '🪵'],
            ['nama' => 'Berondong Ketan', 'deskripsi' => 'Camilan tradisional berondong ketan khas Bawangan yang renyah dan lezat.', 'ikon' => '🍚'],
            ['nama' => 'Produk Dupa', 'deskripsi' => 'Dupa aromatik tradisional buatan pengrajin lokal Desa Bawangan.', 'ikon' => '🪔'],
        ];

        return view('home', compact('profile', 'latestPopulation', 'budgetSummary', 'leaders', 'kades', 'latestNews', 'umkmList', 'slides', 'galleries'));
    }

    public function news(Request $request)
    {
        $query = News::with(['author', 'category'])->where('status', 'published');

        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $news = $query->latest('published_at')->paginate(9)->withQueryString();
        
        $categories = Category::withCount(['news' => function($q) {
            $q->where('status', 'published');
        }])->get();

        return view('berita.index', compact('news', 'categories'));
    }

    public function newsDetail($slug)
    {
        $news = News::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count jika belum dilihat dalam sesi ini
        $sessionKey = 'viewed_news_' . $news->id;
        if (!session()->has($sessionKey)) {
            $news->increment('views_count');
            session()->put($sessionKey, true);
        }

        $related = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('berita.detail', compact('news', 'related'));
    }

    public function demografi(Request $request)
    {
        $availableYears = PopulationData::orderByDesc('year')->pluck('year');
        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        $selectedYear = (int) $request->get('tahun', $availableYears->first());
        $population = PopulationData::where('year', $selectedYear)->first();
        $history = PopulationData::orderByDesc('year')->get();

        return view('demografi.index', compact('availableYears', 'selectedYear', 'population', 'history'));
    }

    public function apbdes(Request $request)
    {
        $availableYears = BudgetData::selectRaw('DISTINCT year')->orderByDesc('year')->pluck('year');
        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        $selectedYear = (int) $request->get('tahun', $availableYears->first());

        $incomeItems = BudgetData::forYear($selectedYear)->income()->get();
        $expenseItems = BudgetData::forYear($selectedYear)->expense()->get();

        $totalIncome = $incomeItems->sum('amount');
        $totalExpense = $expenseItems->sum('amount');
        $surplusDeficit = $totalIncome - $totalExpense;

        $incomeByCategory = $incomeItems->groupBy('category')->map(fn($group) => $group->sum('amount'));
        $expenseByCategory = $expenseItems->groupBy('category')->map(fn($group) => $group->sum('amount'));

        return view('apbdes.index', compact(
            'availableYears',
            'selectedYear',
            'incomeItems',
            'expenseItems',
            'totalIncome',
            'totalExpense',
            'surplusDeficit',
            'incomeByCategory',
            'expenseByCategory'
        ));
    }

    public function gallery(Request $request)
    {
        $query = Gallery::active();

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $galleries = $query->latest()->paginate(12)->withQueryString();
        
        $categories = Gallery::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category')
            ->unique();

        return view('galeri.index', compact('galleries', 'categories'));
    }
}
