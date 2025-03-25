<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceSubdirectory
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = trim($request->path(), '/');

        // Ensure the request is under /app/myapp
        if (!str_starts_with($path, 'app/myapp')) {
            return redirect('/app/myapp' . ($path !== '' ? '/' . $path : ''));
        }

        return $next($request);
    }
}
