<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoriaController extends Controller
{
    /**
     * 
     * 
     */
    public function select(){
        $categorias = Category::all();

        return response()->json([
            'success'=> true, 
            'categorias'=> $categorias
            ]);
    }

    
}
