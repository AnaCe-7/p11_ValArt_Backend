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

}
