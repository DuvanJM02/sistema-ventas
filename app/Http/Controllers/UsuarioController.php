<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request){
            $query = trim($request->get('searchText'));
            $usuarios = DB::table('users')
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);
            
            return view('seguridad.usuario.index', ['usuarios' => $usuarios, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seguridad.usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioFormRequest $request)
    {
        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);

        $usuario->save();

        return Redirect::to('seguridad/usuario');
    }

    public function show($id)
    {
        return view('seguridad.usuario.show', ['usuario' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('seguridad.usuario.edit', ['usuario' => User::findOrFail($id)]);
    }

    public function update(UsuarioFormRequest $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);

        $usuario->update();

        return Redirect::to('seguridad/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id)->delete();

        return Redirect::to('seguridad/usuario');
    }
}
