<?php

namespace App\Http\Middleware;

use App\Services\ApiResponseCacheService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheApiResponse
{

    public function __construct(protected ApiResponseCacheService $apiResponseCacheService)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, int $duration = 30): Response
    {
        // Check if the request should be cached
        if ($this->shouldCacheResponse(request: $request)) {
            return $this->apiResponseCacheService->cache(
                request: $request,
                next: $next,
                duration: $duration
            );
        }

        // If caching is not enabled for this request, simply pass it through
        return $next($request);
    }

    /**
     * A criteria for when to cache the response
     * @param Request $request
     * @return bool
     */
    private function shouldCacheResponse(Request $request): bool
    {
        return $request->isMethod(method: 'GET') && str_starts_with(
                haystack: $request->getPathInfo(),
                needle: '/api/v1'
            );
    }
}
