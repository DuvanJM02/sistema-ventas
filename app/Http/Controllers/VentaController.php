<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Http\Requests\VentaFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;
use Response;
use Illuminate\Support\Collection; 
use Carbon\Carbon;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request){
            $query = trim($request->get('searchText'));
            $ventas = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.num_comprobante', 'like', '%' . $query . '%')
            ->orderBy('v.idventa', 'desc')
            ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->paginate(5);
            
            return view('ventas.venta.index', ['ventas' => $ventas, 'searchText' => $query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', 'Cliente')->get();
        $articulos = DB::table('articulo as a')
        ->join('detalle_ingreso as di', 'a.idarticulo', 'di.idarticulo')
        ->select(DB::raw("CONCAT(a.codigo, ' - ', a.nombre) AS articulo"), "a.idarticulo", 'a.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))
        ->where('a.estado', 'Activo')
        ->where('a.stock', '>', '0')
        ->groupBy('articulo', 'a.idarticulo', 'a.stock')
        ->get();

        return view('ventas.venta.create', ['personas' => $personas, 'articulos' => $articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentaFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $venta = new Venta();

            $venta->idcliente = $request->get('idcliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');
            
            $myTime = Carbon::now('America/Bogota');
            $venta->fecha_hora = $myTime->toDateTimeString(); 
            $venta->impuesto = '19';
            $venta->estado = 'A';

            $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');

            $i = 0;

            while ($i < count($idarticulo)) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->idventa;
                $detalle->idarticulo = $idarticulo[$i];
                $detalle->cantidad = $cantidad[$i];
                $detalle->descuento = $descuento[$i];
                $detalle->precio_venta = $precio_venta[$i];
                $detalle->save();
                $i = $i + 1;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingreso  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = DB::table('venta as v')
        ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
        ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
        ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
        ->where('v.idventa', $id)
        ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
        ->first();

        $detalles = DB::table('detalle_venta as d')
        ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta')
        ->where('d.idventa', $id)->get();

        return view('ventas.venta.show', ['venta' => $venta, 'detalles' => $detalles]);
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
        $venta = Venta::findOrFail($id);
        $venta->estado = 'C';
        $venta->update();

        return Redirect::to('ventas/venta');
    }
}
