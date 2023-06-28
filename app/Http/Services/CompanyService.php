<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\CompanyDetail;
use Illuminate\Support\Collection;

class CompanyService
{
    private ApiService $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService;
    }
    public function saveCompanyDataInDatabase(array $data): bool
    {
        return (bool) CompanyDetail::create($data);
    }

    /**
     * @throws \Exception
     */
    public function getCompanySymbolList(): array
    {
        return $this->apiService->getSymbolListFromCache()
            ?? $this->apiService->getSymbolListFromApi();
    }

    /**
     * @throws \Exception
     */
    public function getHistoryDataByCompanySymbol(string $symbol, ?string $region = null): array
    {
        return $this->apiService->getHistoryDataFromCache($symbol, $region)
            ?? $this->apiService->getHistoryDataFromApi($symbol, $region);
    }

    public function filterHistoryDataByDateRange($historyData, $startDate, $endDate): array|Collection
    {
        $data = collect($historyData);
        $timestampStart = Carbon::parse($startDate)->getTimestamp();
        $timestampEnd = Carbon::parse($endDate)->getTimestamp();

        return $data
            ->where('date', '>=', $timestampStart)
            ->where('date', '<=', $timestampEnd)
            ->toArray();
    }
}
