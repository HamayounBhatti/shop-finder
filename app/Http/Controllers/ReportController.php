<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Claim;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyClaimsExport;

class ReportController extends Controller
{
    public function monthlyReport()
    {
        // Default to current month
        $currentMonth = Carbon::now()->format('Y-m');
        $months = $this->getAvailableMonths();
        
        return view('reports.monthly-report-form', compact('currentMonth', 'months'));
    }

    public function generateMonthlyReport(Request $request, $month = null)
{
    // Handle both GET (month parameter) and POST (month input)
    $monthValue = $month ?? $request->input('month', Carbon::now()->format('Y-m'));
    
    // Validate the month format
    $validator = Validator::make(['month' => $monthValue], [
        'month' => 'required|date_format:Y-m',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }
    
    $date = Carbon::parse($monthValue);
    $startOfMonth = $date->copy()->startOfMonth();
    $endOfMonth = $date->copy()->endOfMonth();
    
    // Base query with role-based filters
    $query = Claim::whereBetween('purchase_date', [$startOfMonth, $endOfMonth])
                ->orderBy('purchase_date');
    
    // Apply role-based filters
    if (Auth::user()->role->name == 'Shop') {
        $query->where('shop_id', Auth::user()->shop_id);
    }
    
    $query->whereHas('shops', function($query) {
        $query->where('is_active', 1);
    });
    
    $claims = $query->with('shops')->get();
    
    return view('reports.monthly-report-view', [
        'date' => $date,
        'claims' => $claims,
        'totalClaims' => $claims->count(),
        'pendingClaims' => $claims->where('status', 0)->count(),
        'submittedClaims' => $claims->where('status', 1)->count(),
        'rejectedClaims' => $claims->where('status', 2)->count(),
        'reparingClaims' => $claims->where('status', 3)->count(),
        'replacingClaims' => $claims->where('status', 4)->count(),
        'receivedClaims' => $claims->where('status', 5)->count(),
        'locallyClosedClaims' => $claims->where('status', 6)->count(),
    ]);
}

    protected function getAvailableMonths()
    {
        // Get distinct months from claims data
        $months = Claim::selectRaw('DATE_FORMAT(purchase_date, "%Y-%m") as month')
                     ->groupBy('month')
                     ->orderBy('month', 'desc')
                     ->pluck('month');
        
        return $months;
    }

    public function exportMonthlyReport(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);
        
        // Convert the string to Carbon object first
        $month = Carbon::createFromFormat('Y-m', $request->month);
        
        $filename = 'claims-report-' . $month->format('F-Y') . '.xlsx';
        
        return Excel::download(new MonthlyClaimsExport($month), $filename);
    }
}