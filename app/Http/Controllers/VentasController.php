<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Ventas;
use App\Models\Stock;
use App\Models\Precios_productos;
use App\Models\Lotes;
use App\Models\User;
use App\Models\Clientes;
use App\Models\Detalle_ventas;
use App\Models\Compras;
use App\Models\Ubicacion;
use App\Models\Tipo;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;





class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function export($filtro = null, $fecha_inicio = null, $fecha_final = null, $id = null)
    {
        return Excel::download(new VentasExport($filtro = null, $fecha_inicio = null, $fecha_final = null, $id = null), 'ventas.xlsx');
    }

    public function imprimirFactura()
    {
        $pdf = PDF::loadView('ejemplo');
        return $pdf->download('ejemplo.pdf');
    }



    public function getVentas(Request $request)
    {


            $ubicacion = Ubicacion::all();
            $compras = Compras::all();
            $user = User::all();
            $clientes = Clientes::all();
            $ventas = Ventas::join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
                ->join('users', 'users.id', '=', 'ventas.user_id')
                ->join('compras', 'compras.id', '=', 'ventas.producto_id')
                ->select('ventas.id', 'ventas.unidades', 'ventas.nombre', 'ventas.cargorecibe', 'ventas.devolucion', 'clientes.responsable_id AS cliente', 'clientes.departamento AS ubicacion', 'users.name AS Vendedor', 'ventas.created_at AS Fecha', 'compras.serial AS serial')
                ->orderby('ventas.created_at', 'desc')
                ->get();



                return view('Ventas/mostrar', [
                    'ubicacion' => $ubicacion,
                    'ventas' => $ventas,
                    'compras' => $compras,
                    'clientes' => $clientes,
                    'user' => $user,

                ]);




    }
    public function fechaVista(Request $request){
        $start = Carbon::parse($request->get('fecha_inicial'));
        $end = Carbon::parse($request->get('fecha_final'));
        $ventas = Ventas::join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('users', 'users.id', '=', 'ventas.user_id')
        ->select('ventas.id', 'clientes.nombre AS cliente', 'users.name AS Vendedor', 'ventas.created_at AS Fecha')
        ->whereDate('ventas.created_at','<=',$end)
        ->whereDate('ventas.created_at','>=',$start)
        // ->get();
        ->paginate(50);

        return view('Ventas/mostrar', [
            'ventas' => $ventas,

        ]);
    }

    public function create()
    {
        $clientes = Clientes::join('compras', 'compras.id', '=', 'clientes.tipo')
        ->select('clientes.*', 'compras.elemento AS elemento', 'compras.caracteristicas AS caracteristicas')
        ->get();




        $stocks = Stock::join('compras', 'compras.id', '=', 'stock.compra_id')
            ->select('stock.*', 'compras.serial as producto')
            ->get();

        // $clientes = Clientes::all();
        $compras = Compras::all();
        $tipo = Tipo::all();
        $user = User::all();


        return view('Ventas/create', [
            'clientes'  => $clientes,
            'stocks'  => $stocks,
            'compras' => $compras,
            'tipo' => $tipo,
            'user' => $user,

        ]);
    }

    public function createVenta(Request $request)
    {
        $unidades = $request->input('unidades');
        $stock_id = $request->input('stock_id');
        $cliente_id = $request->input('cliente_id');
        $user_id = $request->input('user');
        $existencia = DB::table('compras')
        ->select('serial')
        ->where('serial', '=', $stock_id)
        ->exists();
        $mismo =  DB::table('clientes')->where('id', $cliente_id)->first();
        $tipos =  DB::table('compras')->where('id', $mismo->tipo)->first();



        // condicion para saber si coinciden los productos
        if ($tipos->serial != $stock_id) {
            $request->session()->flash('alert-danger', "No coinciden los productos ");
            return redirect()->back();
        }
        // condicion para saber si el codigo existe
        if ($existencia == false) {
            $request->session()->flash('alert-danger', "El producto ingresado, No existe ");
            return redirect()->back();
        }

        $stock   = Stock::where('id', $stock_id)->first();
        $compras = Compras::where('serial', $stock_id)->first();

        // condicion si no hay suficientes productos
        if ((int)$unidades > $tipos->unidades) {

            $request->session()->flash('alert-danger', "No hay suficientes $tipos->elemento - $tipos->caracteristicas, quedan solo $tipos->unidades ");
            return redirect()->back();
        }
        else
        {
            $clientes = Clientes::where('id', $cliente_id)->first();
            $ubicacions = Ubicacion::where('id', $clientes->departamento)->first();

        // enviamos datos a ventas
            $datasave =[
                'cliente_id'  => $cliente_id,
                'producto_id' => $tipos->id,
                'nombre'      =>  $request->input('name'),
                'cargorecibe' => $request->input('cargorecibe'),
                'user_id'     => $user_id,
                'unidades'    => (int)$unidades,
                'devolucion'    => (int)$unidades,
                'created_at'  => Carbon::now()->toDateTimeString(),
                'updated_at'  => Carbon::now()->toDateTimeString()
            ];
        // enviamos datos al stock
            $datasave2 =[
                'unidades'    => $tipos->unidades - (int)$unidades,
                'estado_ubi'  => $ubicacions->nombre,
                'estado_id'   => 3,
            ];
        // enviamos datos a compras
            $datasave3 =[
                'unidades'    => $tipos->unidades - (int)$unidades,
                // 'estado_ubi'  => $ubicacions->nombre,
            ];
        // Cambiamos el estado en clientes
            $datasave4 =[
                // 'estado'    => 'entregado',
                'entregado' => $clientes->entregado - $unidades //descontamos de la tabla de entregados
            ];
        // factura o historial
            $datasave5 =[
                'producto_id' => $unidades,
                'venta_id'     => $user_id, //usuario quien entrega
                'created_at'  => Carbon::now()->toDateTimeString(),
                'updated_at'  => Carbon::now()->toDateTimeString()
            ];

        // envio a la base de datos
            DB::table('ventas')->insert($datasave);
            DB::table('stock')->where('stock.id', $tipos->id)->update($datasave2);
            DB::table('compras')->where('compras.id', $tipos->id)->update($datasave3);
            DB::table('clientes')->where('clientes.id', $cliente_id)->update($datasave4);
            DB::table('detalle_ventas')->insert($datasave5);

        }

        $request->session()->flash('alert-success', 'Entrega realizada con exito!');
        return redirect()->route('ventas.lista', ['filtro' => 4]);

    }



}
