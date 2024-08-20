<?php

namespace App\Http\Middleware;

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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }
}
