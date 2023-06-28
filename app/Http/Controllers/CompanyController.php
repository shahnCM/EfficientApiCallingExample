<?php

namespace App\Http\Controllers;

use App\Rules\Symbol;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Services\CompanyService;

class CompanyController extends Controller
{
    public function create(): View
    {
        return view('company.create');
    }
    public function store(Request $request, CompanyService $companyService)
    {
        $request->validate([
            'symbol' => ['required', new Symbol],
            'email' => ['required','email'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date', 'before_or_equal:' . now()->format('Y-m-d')],
            'end_date' => ['required', 'date', 'after_or_equal:start_date', 'before_or_equal:' . now()->format('Y-m-d')]
        ]);

        $data = $request->except('_token');
        $symbol = $data['symbol'];
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        try {
            $companyService->saveCompanyDataInDatabase($data);
            $historyData = $companyService->getHistoryDataByCompanySymbol($symbol);
            $filteredHistoryData = $companyService->filterHistoryDataByDateRange($historyData, $startDate, $endDate);
            return view('company.history', compact('symbol', 'filteredHistoryData'));
        } catch (\Exception $e) {
            return back()->with('error', $e?->getMessage());
        }
    }
}
