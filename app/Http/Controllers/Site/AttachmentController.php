<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\SiteController;

class AttachmentController extends SiteController {

    public function __construct() {
       // parent::__construct();
       
//        $this->middleware('auth');
//        $this->middleware(function ($request, $next) {
//            $this->user = auth()->user();
//            return $next($request);
//        });
    }

    public function ImageUpload($request, $file_name = 'profiles') {
        $validator = Validator::make($request->all(), [
                    0 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            $path = '';
        } else {
            $input = $request->all();         // $image = $input[];
            $path = '';
            if ($request->hasFile(0)) {
                $image = $request->file(0);
                $name = time() . '.' . $image->getClientOriginalExtension();
                //$destinationPath = public_path('/uploads/' . $file_name);
//                $image->move($destinationPath, $name);
                $destinationPath = 'uploads/' . $file_name . '/' . $name;
                move_uploaded_file($image, $destinationPath);
                $path = '/'.$destinationPath;
//                if (isset($input['yes_compress']) && $input['yes_compress'] == 1) {
//                    $all_size_url = Compress_Modify_Image($file_name, $file_name . '/' . $name,1);
//                }
            }
        }
        return $path;
    }

    public function VideoUpload($request, $file_name = 'videos') {
        $validator = Validator::make($request->all(), [
               0 => 'required|mimes:mov,avi,asf,mkv,swf,mpg,mp4,MP4,mp3,ai,WAV,ogg,qt|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
        ]);
        if ($validator->fails()) {
            $path = '';
        } else {
            $input = $request->all();  //$video = $input[0];
            $path = '';
            if ($request->hasFile(0)) {
                $image = $request->file(0);
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/' . $file_name);
                //$destinationPath = public_path('/uploads/' . $file_name);
//                $image->move($destinationPath, $name);
                $destinationPath = 'uploads/' . $file_name . '/' . $name;
                move_uploaded_file($image, $destinationPath);
                $path = '/'.$destinationPath;
            }
        }
        return $path;
    }

    public function FileUpload($request, $file_name = 'files') {
        $validator = Validator::make($request->all(), [
                    0 => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,psd,ai,txt,jnt|max:2048',
        ]);
        if ($validator->fails()) {
            $path = '';
        } else {
            $input = $request->all();         // $file = $input[];
            $path = '';
            if ($request->hasFile(0)) {
                $image = $request->file(0);
                $name = time() . '.' . $image->getClientOriginalExtension();
                //$destinationPath = public_path('/uploads/' . $file_name);
//                $image->move($destinationPath, $name);
                $destinationPath = 'uploads/' . $file_name . '/' . $name;
                move_uploaded_file($image, $destinationPath);
                $path = '/'.$destinationPath;
            }
        }
        return $path;
    }

//*********************************************************************************
//  $this->validate($request, [
//            0 => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,psd,ai,txt,jnt|max:2048',
//        ]);
}
