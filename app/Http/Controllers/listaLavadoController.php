<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Compras;
use App\Models\Ubicacion;

use App\Models\listalavado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class listaLavadoController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('admin');

        }

    public function getlistalavado(Request $request)
    {

        if($request){

            $query= trim($request->get('search'));
            $start= trim($request->get('fecha_inicial'));
            $end= trim($request->get('fecha_final'));

            $ubicacion = Ubicacion::all();
            // $listalavado = listalavado::join('ubicacions', 'ubicacions.id', '=', 'listalavados.tipo')
            // ->select('listalavados.*','ubicacions.nombre as nombre')
            // ->paginate(10);
            $listalavado = listalavado::join('ubicacions', 'ubicacions.id', '=', 'listalavados.servicio')
            ->join('compras', 'compras.id', '=', 'listalavados.tipo')
            ->select('listalavados.*','ubicacions.nombre as nombre', 'compras.elemento as elemento', 'compras.caracteristicas as carac','listalavados.unidades')
            ->where('compras.elemento','LIKE', '%' . $query . '%')
            ->get();


            return view('listalavado/lista', [
                'listalavado' => $listalavado,
                'search' => $query,
                'ubicacion' => $ubicacion,
                'start' => $start,
                'end' => $end,
            ]);
        }
    }
    public function create()
    {
        $listalavado = listalavado::all();
        $compras = Compras::all();
        $ubicacion = Ubicacion::all();

        return view('listalavado/create', [
            'listalavado' => $listalavado,
            'compras' => $compras,
            'ubicacion' => $ubicacion,
        ]);
    }

    public function createlistalavado(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'unidades'      => 'required',

        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error al ingresar registro');

            return redirect()->back();
        }

        $listalavado = new listalavado();
        $listalavado->tipo = $request->input('tipo');
        $listalavado->unidades = $request->input('unidades');
        $listalavado->servicio = $request->input('servicio');
        $listalavado->save();

        $request->session()->flash('alert-success', 'registrado con exito!');


        return redirect()->route('listalavado.lista');
    }

    public function update($id)
    {
        $listalavado = listalavado::where('id', $id)->first();
        $compras = Compras::all();
        $ubicacion = Ubicacion::all();

        return view('listalavado/editar', [
            'listalavado' => $listalavado,
            'compras' => $compras,
            'ubicacion' => $ubicacion,
        ]);
    }

    public function updatelistalavado(Request $request, $listalavado_id)
    {

        $listalavado = listalavado::where('id', $listalavado_id)->first();

        //validamos los datos
        $validate = Validator::make($request->all(), [
            'unidades'      => 'required',
        ]);

        if ($validate->fails()) {
            $request->session()->flash('alert-danger', 'Error al ingresar usuario');

            return redirect()->back();
        }

        $listalavado->tipo = $request->input('tipo');
        $listalavado->unidades = $listalavado->unidades + $request->input('unidades');
        $listalavado->servicio = $request->input('servicio');

        $listalavado->save();

        $request->session()->flash('alert-success', 'Precio actualizado con exito!');


        return redirect()->route('listalavado.lista');
    }

    public function fechaVista(Request $request){
        $query= trim($request->get('search'));
        $servi=$request->input('departamento');

        if ($servi != null){
        $ubicacion = Ubicacion::all();
        $start = Carbon::parse($request->get('fecha_inicial'));
        $end = Carbon::parse($request->get('fecha_final'));
        $listalavado = listalavado::join('ubicacions', 'ubicacions.id', '=', 'listalavados.servicio')
        ->join('compras', 'compras.id', '=', 'listalavados.tipo')
        ->select('listalavados.*','ubicacions.nombre as nombre', 'compras.elemento as elemento', 'compras.caracteristicas as carac','listalavados.unidades')
        ->where('listalavados.servicio', $servi)
        ->whereDate('listalavados.created_at','<=',$end)
        ->whereDate('listalavados.created_at','>=',$start)
        ->get();

        return view('listalavado/lista', [
            'listalavado' => $listalavado,
            'search' => $query,
            'ubicacion' => $ubicacion,
            'start' => $start,
            'end' => $end,

        ]);
    }else
        $ubicacion = Ubicacion::all();
        $start = Carbon::parse($request->get('fecha_inicial'));
        $end = Carbon::parse($request->get('fecha_final'));
        $listalavado = listalavado::join('ubicacions', 'ubicacions.id', '=', 'listalavados.servicio')
        ->join('compras', 'compras.id', '=', 'listalavados.tipo')
        ->select('listalavados.*','ubicacions.nombre as nombre', 'compras.elemento as elemento', 'compras.caracteristicas as carac','listalavados.unidades')
        ->whereDate('listalavados.created_at','<=',$end)
        ->whereDate('listalavados.created_at','>=',$start)
        ->get();

        return view('listalavado/lista', [
            'listalavado' => $listalavado,
            'search' => $query,
            'ubicacion' => $ubicacion,
            'start' => $start,
            'end' => $end,

        ]);

    }
}
