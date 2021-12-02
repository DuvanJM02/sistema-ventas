<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use App\Models\Persona;

class SearchController extends Controller
{
    public function personas(Request $request){
        $term = $request->get('term');

        $querys = Persona::where('nombre', 'like', '%' . $term . '%')->get();

        $data = [];

        foreach($querys as $query){
            $data[] = [
                'label' => $query->nombre
            ];
        }

        return $data; 
    }

    public function articulos(Request $request){
        $term = $request->get('term');

        $querys = Articulo::where('nombre', 'like', '%' . $term . '%')->get();

        $data = [];

        foreach($querys as $query){
            $data[] = [
                'label' => $query->nombre
            ];
        }

        return $data; 
    }
}
