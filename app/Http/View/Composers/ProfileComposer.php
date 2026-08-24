<?php

namespace App\Http\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;

class ProfileComposer
{
    

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $links = [
            ['name' => 'Docs', 'url' => 'https://laravel.com/docs' ],
            ['name' => 'Laracasts', 'url' => 'https://laracasts.com"' ],
            ['name' => 'News', 'url' => 'https://laravel-news.com' ],
            ['name' => 'Blog', 'url' => 'https://blog.laravel.com' ],
            ['name' => 'Nova', 'url' => 'https://nova.laravel.com"' ],
            ['name' => 'Forge', 'url' => 'https://forge.laravel.com' ],
            ['name' => 'Vapor', 'url' => 'https://vapor.laravel.com"' ],
            ['name' => 'GitHub', 'url' => 'https://github.com/laravel/laravel' ],
        ];

        $view->with('links', $links);
    }
}