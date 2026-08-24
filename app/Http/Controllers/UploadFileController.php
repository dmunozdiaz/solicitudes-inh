<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function showUploadFile(Request $request)
    {
        if ($request->has('files')) {
            $uploadedFile = $request->file('files');
            $filename = time().'_'.$uploadedFile->getClientOriginalName();

            Storage::disk('local')->putFileAs(
                'files/',
                $uploadedFile,
                $filename
            );

            $upload = new Upload;
            $upload->filename = $filename;

            // $upload->user()->associate(auth()->user());

            $upload->save();

            return response()->json([
                  'success'=>true,
               'id' => $upload->id
               ]);
        }
   

        return response()->json(['success'=>false]);
    }
}
