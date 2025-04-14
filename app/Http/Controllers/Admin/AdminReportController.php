<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
        $this->middleware(['auth', 'can:manage_reports']);
    }

    /**
     * Affiche les reports en attente
     */
    public function pendingReports()
    {
        $reports = $this->reportService->getPendingReport();
        
        return view('', compact('reports'));
    }

    /**
     * Affiche les détails d'un report
     */
    public function show(int $id)
    {
        $report = $this->reportService->getReport($id);
        
        return view('', compact('report'));
    }

    /**
     * Traite un report (approve/reject)
     */
    public function handleReport(Request $request, int $id)
    {
        $this->reportService->handleReport(
            $id,
            $request->status,
            auth()->id()
        );

        return redirect()->route('')
            ->with('success', 'Report traité avec succès');
    }

}
