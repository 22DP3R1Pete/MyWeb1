<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only log POST requests to workout-plans endpoint
        if ($request->isMethod('post') && $request->is('workout-plans')) {
            Log::info('Workout Plan Form Submission', [
                'all_data' => $request->all(),
                'exercises' => $request->input('exercises'),
                'sets' => $request->input('sets'),
                'reps' => $request->input('reps'),
                'day' => $request->input('day'),
                'rest' => $request->input('rest')
            ]);
        }

        return $next($request);
    }
}
