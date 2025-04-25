<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModerationController extends Controller
{
    /**
     * @var ReportServiceInterface
     */
    protected $reportService;

    /**
     * ModerationController constructor.
     */
    public function __construct(ReportServiceInterface $reportService)
    {
        $this->reportService = $reportService;
        
        // Apply auth middleware for all actions
        $this->middleware('auth');
        
        // Apply role middleware for moderator or admin
        $this->middleware('role:moderator|admin');
    }

    /**
     * Display the moderation dashboard.
     */
    public function index()
    {
        $reports = $this->reportService->getAllReports();

        return view('moderation.index', [
            'reports' => $reports
        ]);
    }

    /**
     * Display the specified report.
     */
    public function show($id)
    {
        $report = $this->reportService->getReportById($id);

        return view('moderation.show', [
            'report' => $report
        ]);
    }

    /**
     * Handle the report (ignore or delete content).
     */
    public function handleReport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'in:ignore,delete_content'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $action = $request->input('action');
        $result = $this->reportService->handleReport($id, $action);

        if (!$result) {
            return redirect()->back()
                ->with('error', 'Erreur lors du traitement du signalement.');
        }

        return redirect()->route('moderation.index')
            ->with('success', $action === 'ignore' ? 'Signalement ignoré.' : 'Contenu supprimé.');
    }

    /**
     * Display reported posts.
     */
    public function reportedPosts()
    {
        $reports = $this->reportService->getAllReports()->filter(function ($report) {
            return $report->reportable_type === 'App\\Models\\Post';
        });

        return view('moderation.reported-posts', [
            'reports' => $reports
        ]);
    }

    /**
     * Display reported comments.
     */
    public function reportedComments()
    {
        $reports = $this->reportService->getAllReports()->filter(function ($report) {
            return $report->reportable_type === 'App\\Models\\Comment';
        });

        return view('moderation.reported-comments', [
            'reports' => $reports
        ]);
    }
}
