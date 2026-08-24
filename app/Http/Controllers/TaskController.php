<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Traits\UtilsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    use UtilsTrait;
    
    public function taskprocess(Request $request)
    {
        $core = $this->getCoreWorkflow();
       
        $task = $core->getTaksProcess($request->idprocess);

        return response()->json(['success'=>true, 'task' => $task]);
    }
}
