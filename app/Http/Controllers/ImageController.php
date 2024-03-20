<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all();
        return response()->json($images, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'artwork_id' => 'required|exists:artworks,id',
                'image' => 'required|image|max:2048',
            ]);
    
            $image = $request->file('image');
    
            // Upload image to Cloudinary
            $cloudinaryUpload = Cloudinary::upload($image->getRealPath(), [
                'folder' => 'valart',
                'resource_type' => 'auto'
            ]);
    
            $imageUrl = $cloudinaryUpload->getSecurePath();
            $publicId = $cloudinaryUpload->getPublicId();
    
            // Create new image record
            $newImage = new Image();
            $newImage->artwork_id = $request->artwork_id;
            $newImage->image_url = $imageUrl;
            $newImage->public_id = $publicId;
            $newImage->save();
    
            return response()->json(['message' => 'Image uploaded successfully', 'image' => $newImage], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Image upload failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
