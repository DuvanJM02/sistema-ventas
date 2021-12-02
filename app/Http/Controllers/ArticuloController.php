<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ArticuloFormRequest;
use DB;
use PDF;
use Illuminate\Support\Facades\Redirect;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $articulos = DB::table('articulo as a')
                ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
                ->select('a.idarticulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
                ->where('a.nombre', 'like', '%' . $query . '%')
                ->where('a.estado', 'Activo')
                ->orWhere('a.codigo', 'like', '%' . $query . '%')
                ->where('a.estado', 'Activo')
                ->orderBy('a.idarticulo', 'desc')
                ->paginate(5);

            return view('almacen.articulo.index', ['articulos' => $articulos, 'searchText' => $query]);
        }
    }

    public function imprimir()
    {
        $articulos = DB::table('articulo as a')
            ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
            ->select('a.idarticulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
            ->where('a.estado', 'Activo')
            // ->groupBy('a.idarticulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
            ->orderBy('a.idarticulo', 'desc')
            ->get();

        $fecha = date('Y-m-d');
        $data = compact('articulos', 'fecha');
        $pdf = PDF::loadView('almacen.articulo.imprimir', $data);
        return $pdf->stream();
        // return view('almacen.articulo.imprimir', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = DB::table('categoria')->where('condicion', '1')->get();
        return view('almacen.articulo.create', ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloFormRequest $request)
    {
        $articulo = new Articulo();

        $articulo->idcategoria = $request->get('idcategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');
        $articulo->estado = 'Activo';



        // guardar imagen en la carpeta public
        if ($request->imagen) {
            $image = $request->file('imagen');
            $request->imagen->move(public_path() . '/img/articulos/', $image->getClientOriginalName());
            $articulo->imagen = $image->getClientOriginalName();
        }

        // guarda los datos en la tabla
        $articulo->save();

        return Redirect::to('almacen/articulo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('almacen.articulo.show', ['articulo' => Articulo::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = DB::table('categoria')->where('condicion', '1')->get();

        return view('almacen.articulo.edit', ['articulo' => $articulo, 'categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo = Articulo::findOrFail($id);

        $articulo->idcategoria = $request->get('idcategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->nombre;
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');
        $articulo->estado = 'Activo';


        // guardar imagen en la carpeta public
        if ($request->imagen) {
            $image = $request->file('imagen');
            $request->imagen->move(public_path() . '/img/articulos/', $image->getClientOriginalName());
            $articulo->imagen = $image->getClientOriginalName();
        }

        $articulo->update();

        return Redirect::to('almacen/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->estado = 'Inactivo';

        $articulo->update();

        return Redirect::to('almacen/articulo');
    }
}
