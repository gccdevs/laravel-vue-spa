<?php

namespace App\Http\Controllers;

use App\Components\Core\Menu\MenuItem;
use App\Components\Core\Menu\MenuManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SinglePageController extends Controller
{
    public function displaySPA()
    {
        /**
         * @var User $currentUser
         */
        $currentUser = Auth::user();
        $menuManager = new MenuManager();
        $menuManager->setUser($currentUser);
        $menuManager->addMenus([
            new MenuItem([
                'group_requirements' => [],
                'permission_requirements' => ['superuser'],
                'label'=> __('sidebar.home'),
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon'=>'dashboard',
                'route_type'=>'vue',
                'route_name'=>'admin.home'
            ]),
            new MenuItem([
                'group_requirements' => [],
                'permission_requirements' => ['superuser'],
                'label'=>__('sidebar.formListLabel'),
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon'=>'featured_play_list',
                'route_type'=>'vue',
                'route_name'=>'admin.form.list'
            ]),
            new MenuItem([
                'group_requirements' => [],
                'permission_requirements' => ['superuser'],
                'label'=> __('sidebar.event_planner'),
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon'=>'calendar_view_day',
                'route_type'=>'vue',
                'route_name'=>'admin.event.index'
            ]),

            new MenuItem([
                'nav_type' => MenuItem::$NAV_TYPE_DIVIDER
            ])
        ]);

        $menus = $menuManager->getFiltered();

        view()->share('nav',$menus);

        return view('layouts.app');
    }
}
