<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * Корневой шаблон, загружаемый при первом посещении страницы.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Определите текущую версию.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Определите параметры, которые будут общими по умолчанию.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $auth = [
            'user' => null,
            'isSysAdmin' => false
        ];

        if (Auth::check()) {
            $auth = [
                'user' => $request->user(),
                'isSysAdmin' => $request->user()->isSysAdmin()
            ];
        }

        return [
            ...parent::share($request),
            'auth' => $auth,
        ];
    }
}
