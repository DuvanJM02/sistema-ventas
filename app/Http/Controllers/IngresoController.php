<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\DetalleIngreso;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\IngresoFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;
use Response;
use Illuminate\Support\Collection;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;

class IngresoController extends Controller
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
            $ingresos = DB::table('ingreso as i')
            ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.num_comprobante', 'like', '%' . $query . '%')
            ->orderBy('i.idingreso', 'desc')
            ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->paginate(5);
            
            return view('compras.ingreso.index', ['ingresos' => $ingresos, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', 'Proveedor')->get();
        $articulos = DB::table('articulo as a')
        ->select(DB::raw("CONCAT(a.codigo, ' - ', a.nombre) AS articulo"), "a.idarticulo")
        ->where('a.estado', 'Activo')
        ->get();

        return view('compras.ingreso.create', ['personas' => $personas, 'articulos' => $articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngresoFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $ingreso = new Ingreso();

            $myTime = Carbon::now('America/Bogota');
            $ingreso->idproveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $ingreso->fecha_hora = $myTime->toDateTimeString();
            $ingreso->impuesto = '19';
            $ingreso->estado = 'A';

            $ingreso->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $i = 0;

            while ($i < count($idarticulo)) {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso;
                $detalle->idarticulo = $idarticulo[$i];
                $detalle->cantidad = $cantidad[$i];
                $detalle->precio_compra = $precio_compra[$i];
                $detalle->precio_venta = $precio_venta[$i];
                $detalle->save();
                $i = $i + 1;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
        ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
        ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
        ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
        ->where('i.idingreso', $id)
        ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
        ->first();

        $detalles = DB::table('detalle_ingreso as d')
        ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
        ->where('d.idingreso', $id)->get();

        return view('compras.ingreso.show', ['ingreso' => $ingreso, 'detalles' => $detalles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingreso $ingreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingreso $ingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C';
        $ingreso->update();

        return Redirect::to('compras/ingreso');
    }
}
