<?php

namespace App\Http\Middleware;

use App\Actions\Utility\GetNavbarMenu;
use App\Http\Actions\Utility\GetSidebarMenu;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $sidebarMenus = (new GetSidebarMenu())->handle();

        return array_merge(parent::share($request), [
            "app_name" => config("app.name"),
            "user" => fn() => $request->user()
                ? $request->user()->only("id", "name", "email")
                : null,
            "role" => fn() => $request->user()
                ? $request->user()->role->name
                : null,
            'sidebar_menus' => $sidebarMenus,

        ]);
    }
}
