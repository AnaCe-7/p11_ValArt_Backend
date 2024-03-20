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
        try {
            $images = Image::all();
            return response()->json($images, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
                throw new \Exception('The image could not be stored');
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
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|max:2048'
            ]);
    
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
    
            $image = Image::findOrFail($id);
    
            // Elimino la imagen anterior de Cloudinary
            Cloudinary::destroy($image->public_id);
    
            // Subo la nueva imagen a Cloudinary
            $file = $request->file('image');
            $cloudinaryUpload = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'valart',
            ]);
    
            if (!$cloudinaryUpload->getSecurePath() || !$cloudinaryUpload->getPublicId()) {
                throw new \Exception('No se ha podido almacenar la imagen');
            }
    
            // Actualiza los detalles de la imagen en la base de datos
            $image->update([
                'image_url' => $cloudinaryUpload->getSecurePath(),
                'public_id' => $cloudinaryUpload->getPublicId(),
            ]);
    
            return response()->json($image, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
