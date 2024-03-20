<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|max:2048'
            ]);
            
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $file = $request->file('image');
            $cloudinaryUpload = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'valart',
            ]);
    
            if (!$cloudinaryUpload->getSecurePath() || !$cloudinaryUpload->getPublicId()) {
                throw new \Exception('No se ha podido almacenar la imagen');
            }
            
            $newImage = Image::create([
                'artwork_id' => $request->input('artwork_id'),
                'image_url' => $cloudinaryUpload->getSecurePath(),
                'public_id' => $cloudinaryUpload->getPublicId(),
            ]);
    
            return response()->json($newImage, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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


    public function destroy(string $id)
    {
        try {
            $image = Image::findOrFail($id);
    
            // Delete image from Cloudinary
            Cloudinary::destroy($image->public_id);
    
            // Delete image record from database
            $image->delete();
    
            return response()->json(['message' => 'Image deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete image: ' . $e->getMessage()], 500);
        }
    }
}
