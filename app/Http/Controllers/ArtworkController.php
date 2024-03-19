<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    // Mostrar todos los Artworks
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

}
