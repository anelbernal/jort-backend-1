<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index() {
        $files = File::all();
        return response()->json(["status" => "success", "count" => count($files), "data" => $files]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_name' => 'required'
        ]);

        $file = $request->file_name;
        $filename = explode(',', $file);
        $type = explode('/', $filename[0]);
        $filetype = explode(';', $type[1]);
        $fileType = $filetype[0];

        $fileName = uniqid().'.'.$fileType;

        Storage::disk('public')->put($fileName, base64_decode($filename[1]));

        return response('https://jortinc.com/backend/storage/app/public/'.$fileName);
    }
}

//please ensure that you have the necessary models and configuration iin place for this code to work properly, this code assumes the presence of a file model and the configuration of a public disk in the laravel filesystem configuration file ('config/filesystems.php)