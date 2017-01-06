<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Request AS UploadRequest;
Route::post('/file', function () {
    if ($file = UploadRequest::file('file')) {

        $serverPath  = storage_path("laralogs");
        if(!file_exists($serverPath)){
            mkdir($serverPath,0700,true);
        }

        $fileName = $file->getClientOriginalName();

        $file->move($serverPath, $fileName);

        if(!file_exists($serverPath.'/'.$fileName)){
            return [true,'上传失败'];
        }

        return [false,$serverPath.'/'.$fileName,'上传成功'];

    }else{
        return [true,[],'无上传文件'];
    }
});
