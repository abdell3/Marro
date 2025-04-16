<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportTypeRequest;
use App\Http\Requests\UpdateReportTypeRequest;
use App\Services\ReportTypeService;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    protected $reportTypeService;

    public function __construct(ReportTypeService $reportTypeService)
    {
        $this->reportTypeService = $reportTypeService;
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('admin.report-types.index', compact('reportTypes'));
    }

    public function create()
    {
        return view('admin.report-types.create');
    }

    public function store(StoreReportTypeRequest $request)
    {
        $this->reportTypeService->createReportType($request->validated());
        return redirect()->route('admin.report-types.index')->with('success', 'Report type created successfully.');
    }

    public function edit($id)
    {
        $reportType = $this->reportTypeService->getReportTypeById($id);
        return view('admin.report-types.edit', compact('reportType'));
    }

    public function update(UpdateReportTypeRequest $request, $id)
    {
        $this->reportTypeService->updateReportType($id, $request->validated());
        return redirect()->route('admin.report-types.index')->with('success', 'Report type updated successfully.');
    }

    public function destroy($id)
    {
        $this->reportTypeService->deleteReportType($id);
        return redirect()->route('admin.report-types.index')->with('success', 'Report type deleted successfully.');
    }
}
