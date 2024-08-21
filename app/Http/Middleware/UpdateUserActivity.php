<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;

class UpdateUserActivity
{
    /**
     * Обновление последней даты активности пользователя
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $id = Auth::id();
            $last_activity_key = "last_activity_" . $id;

            if(!Cache::has($last_activity_key)) {
                $datetime = Carbon::now();

                $user = User::find($id);
                $user->last_activity = $datetime;
                $user->save();

                Cache::put($last_activity_key, true, $datetime->addMinutes(10));
            }
        }

        return $next($request);
    }
}
