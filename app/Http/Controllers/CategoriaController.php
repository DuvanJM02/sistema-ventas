<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CategoriaFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $query = trim($request->get('searchText'));
            $categorias = DB::table('categoria')->where('nombre', 'like', '%' . $query . '%')
            ->where('condicion', '1')
            ->orderBy('idcategoria', 'desc')
            ->paginate(5);
            
            return view('almacen.categoria.index', ['categorias' => $categorias, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('almacen.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaFormRequest $request)
    {
        $categoria = new Categoria();

        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion = '1';
        // guarda los datos en la tabla
        $categoria->save();

        return Redirect::to('almacen/categoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('almacen.categoria.show', ['categoria' => Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('almacen.categoria.edit', ['categoria' => Categoria::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaFormRequest $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');

        $categoria->update();

        return Redirect::to('almacen/categoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->condicion = '0';

        $categoria->update();

        return Redirect::to('almacen/categoria');
    }
}
