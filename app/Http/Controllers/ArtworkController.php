<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    
    public function index()
    {
        $artworks = Artwork::all();
        return response()->json($artworks, 200);
    }

    public function store(Request $request)
    {
        try {

            $artwork = new Artwork;
            $artwork -> title = $request -> title;
            $artwork -> description = $request -> description;
            $artwork -> image = $request -> image;
            $artwork -> classification = $request -> classification;
            $artwork -> technique = $request -> technique;
            $artwork -> details = $request -> details;
            $artwork -> measures = $request -> measures;
            $artwork->save();
            
            return response()->json([
                'success' => true,
                'data' => $artwork
            ], 201);
    
            } catch(\Exception $e){
                return response()->json(['error' => 'Failed to store artwork'], 500);
            }
    }


    public function show(string $id)
    {
        $artwork = Artwork::find($id);

        if (!$artwork) {
            return response()->json(['error' => 'Artwork not found'], 404);
        }
            return response()->json($artwork, 200);
    }


    public function update(Request $request, string $id)
    {
        try {
            $artwork = Artwork::find($id);
            $artwork -> title = $request -> title;
            $artwork -> description = $request -> description;
            $artwork -> image = $request -> image;
            $artwork -> classification = $request -> classification;
            $artwork -> technique = $request -> technique;
            $artwork -> details = $request -> details;
            $artwork -> measures = $request -> measures;
            $artwork->save();

        return response()->json([
            'success' => true,
            'data' => $artwork
        ], 200);

        }  catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update artwork'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $artwork = Artwork::find($id);
            if (!$artwork) {
                return response()->json(['error' => 'Artwork not found'], 404);
            }
            $artwork->delete();
            return response()->json([
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete artwork'], 500);
        }
    } 

}
