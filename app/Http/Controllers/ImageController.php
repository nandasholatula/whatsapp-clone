<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image as Img;

class ImageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage()
    {
        return view('resizeImage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');

        // dd($file->getClientOriginalName(), $file->getClientOriginalExtension(), @is_array(getimagesize($file)));

        $image = $request->file('file');
        $input['imagename'] = time() . '.' . $image->extension();
        $destinationPath = storage_path() . '/app/public/upload/sendMedia/' . $input['imagename'];
        // $destinationPath = public_path('thumbnail/'). $input['imagename'];
        if (@is_array(getimagesize($file))) {
            $img = Img::make($image->path());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath);
            $url = '/storage/upload/sendMedia/' . $input['imagename'];
        } else {
            $path = 'upload/sendMedia';

            $path = Storage::disk('public')->put(
                $path,
                $file
            );
            $url = Storage::url($path);
        }

        // $destinationPath = public_path('/images');
        // $image->move($destinationPath, $input['imagename']);


        $imageDB = Image::create([
            'url' => $url,
            'name' => $input['imagename'],
            'type' => $file->getClientOriginalExtension()
        ]);

        return response()->json(['url' => $url, 'name' => $imageDB->name, 'type' => $file->getClientOriginalExtension()]);
    }
}
