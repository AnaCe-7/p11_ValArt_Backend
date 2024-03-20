<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageController extends Controller
{
    
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


    public function show(string $id)
    {
        try {
            $image = Image::findOrFail($id);
            return response()->json(['image' => $image], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Image not found'], 404);
        }
    }

 
    public function update(Request $request, string $id)
    {
        try {
            $image = Image::findOrFail($id);
    
            $request->validate([
                'artwork_id' => 'exists:artworks,id',
                'image' => 'image|max:2048',
            ]);
    
            if ($request->hasFile('image')) {
                // Upload new image to Cloudinary
                $imageFile = $request->file('image');
                $cloudinaryUpload = Cloudinary::upload($imageFile->getRealPath(), [
                    'folder' => 'valart',
                    'resource_type' => 'auto'
                ]);
                $imageUrl = $cloudinaryUpload->getSecurePath();
                $publicId = $cloudinaryUpload->getPublicId();
                
                // Delete previous image from Cloudinary
                Cloudinary::destroy($image->public_id);
                
                // Update image record
                $image->image_url = $imageUrl;
                $image->public_id = $publicId;
            }
    
            if ($request->filled('artwork_id')) {
                $image->artwork_id = $request->artwork_id;
            }
    
            $image->save();
    
            return response()->json(['message' => 'Image updated successfully', 'image' => $image], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update image: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
