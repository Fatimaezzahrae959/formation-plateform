<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class LastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $userId = auth()->id();
            $key = 'last_activity_' . $userId;

            // نحفظو آخر نشاط كل دقيقة فقط
            if (!Cache::has($key)) {
                Cache::put($key, now(), 60); // 60 ثانية

                // نحدثو في DB
                auth()->user()->update([
                    'last_activity_at' => now()
                ]);
            }
        }

        return $next($request);
    }
}