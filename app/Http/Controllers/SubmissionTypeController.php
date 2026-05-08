<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionTypeController extends Controller
{
    /**
     * Show submission type selection page
     */
    public function index()
    {
        return view('submissions.select-type');
    }

    /**
     * Logbook Entry Page
     */
    public function createLogbook()
    {
        return view('submissions.create-logbook');
    }

    /**
     * Analytical Report Page
     */
    public function createAnalyticalReport()
    {
        return view('submissions.create-analytical-report');
    }

    public function analyticalReportType()
    {
        return view('submissions.analytical-report-type');
    }
}