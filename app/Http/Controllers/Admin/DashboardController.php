<?php 



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Services\ReportService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * 
     */
    protected $userService;
    protected $reportService;

    public function __construct(UserService $userService, ReportService $reportService)
    {
        $this->userService = $userService;
        $this->reportService = $reportService;
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        
        $userCount = User::count();
        $postCount = Post::count();
        $communityCount = Community::count();
        $pendingReportsCount = Report::where('status', 'pending')->count();

        
        $userStats = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        
        $postStats = Post::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $topCommunities = Community::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        
        $recentReports = Report::with(['user', 'reportType'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'userCount',
            'postCount',
            'communityCount',
            'pendingReportsCount',
            'userStats',
            'postStats',
            'topCommunities',
            'recentReports',
            'posts'
        ));
    }
}

