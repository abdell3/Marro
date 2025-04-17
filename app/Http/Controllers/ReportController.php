<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReportType;
use App\Models\Thread;
use App\Services\ReportService;
use App\Services\ReportTypeService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $reportService;
     protected $reportTypeService;
 
     public function __construct(ReportService $reportService, ReportTypeService $reportTypeService)
     {
         $this->reportService = $reportService;
         $this->reportTypeService = $reportTypeService;
         $this->middleware('auth');
     }
 
     public function index(Request $request)
     {
         
        $this->authorize('view', Report::class);
        $query = Report::query()->with(['user', 'reportType']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('type') && $request->type) {
            $query->where('report_type_id', $request->type);
        }
        
        $reports = $query->latest()->paginate(15);
        $reportTypes = ReportType::all();
        
        return view('admin.reports.index', compact('reports', 'reportTypes'));
     }
 
     public function create(Request $request)
     {
         $reportTypes = $this->reportTypeService->getAllReportTypes();
         $reportableType = $request->reportable_type;
         $reportableId = $request->reportable_id;
         
         return view('reports.create', compact('reportTypes', 'reportableType', 'reportableId'));
     }
 
     public function store(StoreReportRequest $request)
     {
         $this->reportService->createReport($request->validated());
         
         return redirect()->back()->with('success', 'Report submitted successfully. Our moderators will review it.');
     }
 
     public function show($id)
     {
        $report = Report::with(['user', 'reportType'])->findOrFail($id);
        $this->authorize('view', $report);
        
        $contentUrl = '#';
        
        if ($report->reportable) {
            switch ($report->reportable_type) {
                case 'App\\Models\\Post':
                    $contentUrl = route('posts.show', $report->reportable_id);
                    break;
                case 'App\\Models\\Comment':
                    $comment = Comment::find($report->reportable_id);
                    if ($comment) {
                        $contentUrl = route('posts.show', $comment->post_id) . '#comment-' . $comment->id;
                    }
                    break;
                case 'App\\Models\\Community':
                    $community = Community::find($report->reportable_id);
                    if ($community) {
                        $contentUrl = route('communities.show', $community->slug);
                    }
                    break;
                case 'App\\Models\\User':
                    $contentUrl = route('users.show', $report->reportable_id);
                    break;
                case 'App\\Models\\Thread':
                    $thread = Thread::find($report->reportable_id);
                    if ($thread) {
                        $contentUrl = route('threads.show', $thread->id);
                    }
                    break;
            }
        }
        
        return view('admin.reports.show', compact('report', 'contentUrl'));
     }
 
     public function update(UpdateReportRequest $request, $id)
     {
         $report = $this->reportService->getReportById($id);
         $this->authorize('update', $report);
         
         $this->reportService->updateReport($id, $request->validated());
         
         return redirect()->route('admin.reports.index')->with('success', 'Report updated successfully.');
     }
 
     public function updateStatus(Request $request, $id)
     {
         $request->validate([
             'status' => 'required|in:pending,resolved,rejected'
         ]);
         
         $report = $this->reportService->getReportById($id);
         $this->authorize('update', $report);
         
         $this->reportService->updateReportStatus($id, $request->status);
         
         return redirect()->route('admin.reports.index')->with('success', 'Report status updated successfully.');
     }
 
     public function destroy($id)
     {
         $report = $this->reportService->getReportById($id);
         $this->authorize('delete', $report);
         
         $this->reportService->deleteReport($id);
         
         return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
     }
}
