<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Golchha21\ReSmushIt\ReSmushIt;

trait ImageOperations{

    /* 
        * To resize Image
    */
    public function resize($image,$width = null,$height = null)
    {
        if($image == null){
            return null;
        }
        return Image::make($image)->resize($width,$height);
    }

    /* 
        ! Stores image in storage
    */
    public function saveImage($folder = "uploads", $image, $namePrefix = "image",$optimize = false,$classType = "UploadedFile")
    {
        if($image == null){
            return null;
        }
        $folder .= '/'.date('Y').'/'.date('m').'/'.date('d');
        if($classType == "UploadedFile"){
            $filename = $namePrefix."-".time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/'.$folder,$filename);
        }else{
            $image = $image->encode('jpg');
            $filename = $namePrefix."-".time().'.jpg';
            Storage::put('public/'.$folder.'/'.$filename, $image);
            
        }
        $path = 'storage/'.$folder.'/'.$filename;

        if($optimize == true){
            $opt = new ReSmushIt();
            $opt->path(public_path($path));
        }
        
        return $path;
    }

    /* 
        ! Delete Image if exists
    */

    public function deleteImage($path)
    {
        
        if($path != null && Storage::exists('public/'.$path)){
            Storage::delete('public/'.$path);
        }
        
    }
    /* 
        @param $classType must be "UploadedFile" if you are uploading new image
                for rezsized images $classType could be null
    */
    public function updateImage($old,$new,$folder = "uploads",$namePrefix = "image",$optimize = false,$classType = "UploadedFile")
    {
        $this->deleteImage($old);
        return $this->saveImage($folder,$new,$namePrefix,$optimize,$classType);
    }
}