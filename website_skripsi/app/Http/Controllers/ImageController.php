<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\DecryptRequest;
use App\Http\Requests\EncryptRequest;

class ImageController extends Controller
{
    public function encrypt (EncryptRequest $request) {
        $validated = $request->validated();
        
        $file = $validated['image'];
        $plain_image = file_get_contents($file->path());
        $plain_image_64 = base64_encode($plain_image);
        $formData = [
            'p1' => $validated['p1'],
            'p2' => $validated['p2'],
            'k1' => $validated['k1'],
            'k2' => $validated['k2'],
            'x0' => $validated['x0'],
            'a0' => $validated['a0'],
            'x1' => $validated['x1'],
            'a1' => $validated['a1'],
            'a' => $validated['a'],
            'b' => $validated['b'],
        ];

        # Send encrypt request
        $response = Http::timeout(120)
            ->attach(
                'image', 
                $plain_image, // Read file contents
                $file->getClientOriginalName() // Use original file name
            )
            ->post('http://127.0.0.1:5000/encrypt', $formData);
        
        // Convert Base64 to binary data
        $img_binary = base64_decode($response['file']);

        // Save image into database
        $image = new Image();
        $now = now();
        $image->name = "$now";
        $image->data = $img_binary;        
        $image->save(); 

        // Get the original JSON response from the API
        $originalResponse = json_decode($response, true);
        
        return back()->with([
            'success_encrypt' => 'Image encrypted successfully.',
            'hash' => $originalResponse['hash'],
            'width' => $originalResponse['width'],
            'height' => $originalResponse['height'],
            'image_cipher_id' => $image->id,
            'image_cipher' => $originalResponse['file'],
            'image_plain' => $plain_image_64,
            'p1' => $validated['p1'],
            'p2' => $validated['p2'],
            'k1' => $validated['k1'],
            'k2' => $validated['k2'],
            'x0' => $validated['x0'],
            'a0' => $validated['a0'],
            'x1' => $validated['x1'],
            'a1' => $validated['a1'],
            'a' => $validated['a'],
            'b' => $validated['b'],
        ]);
    }

    public function decrypt (DecryptRequest $request) {
        $validated = $request->validated();
        $file = $validated['image'];
        $cipher_image = file_get_contents($file->path());
        // Encode the file content as base64
        $cipher_image_64 = base64_encode($cipher_image);
        $formData = [
            'p1' => $validated['p1'],
            'p2' => $validated['p2'],
            'k1' => $validated['k1'],
            'k2' => $validated['k2'],
            'x0' => $validated['x0'],
            'a0' => $validated['a0'],
            'x1' => $validated['x1'],
            'a1' => $validated['a1'],
            'a' => $validated['a'],
            'b' => $validated['b'],
            'width' => $validated['width'],
            'height' => $validated['height'],
            'hashing' => $validated['hashing'],
        ];
    
        $response = Http::timeout(120)
            ->attach(
                'image', 
                file_get_contents($file->path()), // Read file contents
                $file->getClientOriginalName() // Use original file name
            )
            ->post('http://127.0.0.1:5000/decrypt', $formData);

        $originalResponse = json_decode($response, true);     
        return back()->with([
            'success_decrypt' => 'Image decrypted successfully.',
            'image_cipher' => $cipher_image_64,
            'image_plain' => $originalResponse['file'],
            'p1' => $validated['p1'],
            'p2' => $validated['p2'],
            'k1' => $validated['k1'],
            'k2' => $validated['k2'],
            'x0' => $validated['x0'],
            'a0' => $validated['a0'],
            'x1' => $validated['x1'],
            'a1' => $validated['a1'],
            'a' => $validated['a'],
            'b' => $validated['b'],
            'width' => $validated['width'],
            'height' => $validated['height'],
            'hashing' => $validated['hashing'],
        ]);
    }

    public function sendImage (Request $request) {
        $image = Image::find($request->image_cipher_id);
        if(!$image || !$request->users){
            return back()->with('failed_send', 'image sent failed');
        }
        foreach($request->users as $target){
            $user = User::find($target);
            $user->images()->attach($image) ;
        }

        return back()->with('success_send', 'image sent successfully');
    }

    public function getImage (User $user) {
        $imagesData = [];
        // dd($user->images());
        $images = $user->images()->select('id', 'name')->get();
        foreach($images as $image) {
            $imagesData[] = [
                "id" => $image->id,
                "name" => $image->name,
            ];
        }
         // Return the image data as a JSON response
        return response()->json([
            'images' => $imagesData,
        ]);
    }

    public function show (Image $image) {
        $response = base64_encode($image->data);
        return response()->json([
            'file' => $response,
        ]);
    }
}
