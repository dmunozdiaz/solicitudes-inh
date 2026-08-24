<?php

namespace App\Http\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Client;
use Auth;

class ClientsComposer
{
    

    /**
     * Create a new clients composer.
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
        $clients = Client::where('user_id', Auth::user()->id)->get();

        $view->with('clients', $clients);
    }
}