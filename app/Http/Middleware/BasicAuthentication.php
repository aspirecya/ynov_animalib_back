<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BasicAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = $this->decodeAuth($request);
        list($email, $token) = explode(':', $auth);
        if ($token === config('graphql.token')) {
            $user = User::where('email', $email)->firstOrFail();
            Auth::login($user);

            return $next($request);
        }

        abort(403, 'Access denied');
    }

    private function decodeAuth(Request $request)
    {
        $header = $request->header('Authorization', '');

        $position = strrpos($header, 'Basic ');

        if ($position !== false) {
            $header = substr($header, $position + 6);

            return base64_decode($header);
        }

        return ':';
    }
}
