<?php

namespace App\Services;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiResponseCacheService
{
    /**
     * Cache the api response, and if the request is already cached then return it.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $duration
     * @return mixed
     */
    public function cache(Request $request, Closure $next, int $duration = 60): mixed
    {
        // Generate a unique cache key for this request
        $cacheKey = 'api_response:' . md5($request->fullUrl());


        // Check if the response is already cached
        if (Cache::has($cacheKey)) {
            // Return the cached response
            return Cache::get($cacheKey);
        }

        // If the response is not cached, proceed with the request
        $response = $next($request);

        // Store the response in the cache for the specified duration
        Cache::put($cacheKey, $response, $duration);

        return $response;
    }

    /**
     * Delete the cache for a specific request.
     *
     * @param Request $request
     * @return void
     */
    public function deleteCache(Request $request): void
    {
        // Generate the cache key for the request and delete it if it exists
        $cacheKey = 'api_response:' . md5($request->fullUrl());
        Cache::forget($cacheKey);
    }

}
