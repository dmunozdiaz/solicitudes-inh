<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller{
    public function viewDashboard(){
        return view('dashboard',[
          'aniosession' => $request->session()->get('anio-session')
        ]);
    }
}
