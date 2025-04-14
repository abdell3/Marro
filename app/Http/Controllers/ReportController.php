<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\ReportType;
use App\Services\ReportService;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $reportService;

    public function __construct(ReportService $reportServ)
    {
        $this->reportService = $reportServ;
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index($request)
    {
        $status = $request->input('status', 'pending');
        
        $reports = Report::with(['reportable', 'user_id'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.reports', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($reportableType, $reportableId)
    {
        return view('reports.create', [
            'reportableType' => $reportableType,
            'reportableId' => $reportableId,
            'reportTypes' => ReportType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->reportService->createReport($data);

        return redirect()->back()
            ->with('success', 'Votre report a été soumis avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($reportId)
    {
        $report = Report::with(['reportable', 'reporter'])->findOrFail($reportId);
        
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function userReports()
    {
        $reports = $this->reportService->getUserReports(auth()->id());

        return view('reports.user-index', compact('reports'));
    }
}
