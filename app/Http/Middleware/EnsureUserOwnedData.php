<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUserOwnedData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get users id
        $userId = Auth()->user()->id;

        // Find users data
        $user = User::find($userId);

        // return not found if users doesn't exist
        if (!$user) {
            return response()->json([
                'message' => 'Data Not Found'
            ], 404);
        }
        
        return $next($request);
    }
}
