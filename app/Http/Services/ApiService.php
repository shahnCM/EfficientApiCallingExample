<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private CONST SYMBOL_LIST_CACHE = 'symbol_list';
    private CONST HISTORY_DATA_CACHE = 'history_data';

    public function getSymbolListFromCache(): ?array
    {
        return Cache::get(self::SYMBOL_LIST_CACHE);
    }
    public function getSymbolListFromApi(): array
    {
        try {
            $url = config('apicall.datahub.symbol_list_api_url');
            $apiCall = Http::timeout(30)->retry(3, 500)->get($url);
            $dataCollection = collect($apiCall->json());
            $symbolAndNamePairList = $dataCollection->pluck('Company Name', 'Symbol')->toArray();
            empty($symbolAndNamePairList) || Cache::put(self::SYMBOL_LIST_CACHE, $symbolAndNamePairList, now()->endOfMonth());
            return $symbolAndNamePairList;
        } catch (\Exception $e) {
            Log::channel('symbolListApiCall')->error($e?->getMessage());
            config('apicall.empty_array_over_exception.symbol_api') || throw new \Exception("Symbol is unprocessable");
            return [];
        }
    }

    public function getHistoryDataFromCache(string $symbol, ?string $region = null): ?array
    {
        $queryParams = "?symbol={$symbol}";
        is_null($region) || $queryParams .= "&region={$region}";
        return Cache::get(self::HISTORY_DATA_CACHE . $queryParams);
    }
    public function getHistoryDataFromApi(string $symbol, ?string $region = null): array
    {
        try {
            $queryParams = "?symbol={$symbol}";
            is_null($region) || $queryParams .= "&region={$region}";
            $url = config('apicall.rapid_api.history_data_api_url');
            $headers = ['X-RapidAPI-Key' => config('apicall.rapid_api.key'), 'X-RapidAPI-Host' => config('apicall.rapid_api.host')];
            $apiCall = Http::timeout(30)->retry(3, 500)->withHeaders($headers)->get($url . $queryParams);
            $historyData = $apiCall->json('prices');
            Cache::put(self::HISTORY_DATA_CACHE . $queryParams, $historyData, now()->addMinutes(15));
            return $historyData;
        } catch (\Exception $e) {
            Log::channel('historyDataApiCall')->error($e?->getMessage());
            config('apicall.empty_array_over_exception.history_api') || throw new \Exception("Price-History data is unprocessable");
            return [];
        }
    }
}
