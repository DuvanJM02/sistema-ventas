<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\PersonaFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;

class ProveedorController extends Controller
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
            $personas = DB::table('persona')
            ->where('nombre', 'like', '%' . $query . '%')
            ->where('tipo_persona', 'Proveedor')
            ->orWhere('num_documento', 'like', '%' . $query . '%')
            ->where('tipo_persona', 'Proveedor')
            ->orderBy('idpersona', 'desc')
            ->paginate(5);
            
            return view('compras.proveedor.index', ['personas' => $personas, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona();

        $persona->tipo_persona = "Proveedor";
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        
        // guarda los datos en la tabla
        $persona->save();

        return Redirect::to('compras/proveedor');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('compras.proveedor.show', ['persona' => Persona::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('compras.proveedor.edit', ['persona' => Persona::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');

        $persona->update();

        return Redirect::to('compras/proveedor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo';

        $persona->update();

        return Redirect::to('compras/proveedor');
    }
}
