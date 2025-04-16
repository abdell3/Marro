<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReportType;
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
 
     public function index()
     {
         // Only moderators and admins can see all reports
         $this->authorize('moderator');
         
         $reports = $this->reportService->getAllReports();
         return view('admin.reports.index', compact('reports'));
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
         $report = $this->reportService->getReportById($id);
         $this->authorize('view', $report);
         
         return view('admin.reports.show', compact('report'));
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
