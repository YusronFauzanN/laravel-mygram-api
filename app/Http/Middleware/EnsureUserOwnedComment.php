<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;

class EnsureUserOwnedComment
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
        $comment = Comment::find($request->id);

        // return not found if users doesn't exist
        if ( !$comment || $comment->user_id != $userId) {
            return response()->json([
                'message' => 'Data Not Found'
            ], 404);
        }

        return $next($request);
    }
}
