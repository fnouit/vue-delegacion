<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $filtro = $request->filtro;
         
        if ($buscar==''){
            $regiones = Region::orderBy('id', 'asc')->paginate(15);
        }
        else{
            $regiones = Region::where($filtro, 'like', '%'. $buscar . '%')->orderBy('id', 'asc')->paginate(3);
        }
         
 
        return [
            'pagination' => [
                'total'        => $regiones->total(),
                'current_page' => $regiones->currentPage(),
                'per_page'     => $regiones->perPage(),
                'last_page'    => $regiones->lastPage(),
                'from'         => $regiones->firstItem(),
                'to'           => $regiones->lastItem(),
            ],
            'regiones' => $regiones
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $region = new Region();
        $region->nombre = $request->nombre;
        $region->sede = $request->sede;
        $region->coordinador = $request->coordinador;
        $region->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        if (!$request->ajax()) return redirect('/');
        $region = Region::findOrFail($request->id);
        $region->nombre = $request->nombre;
        $region->sede = $request->sede;
        $region->coordinador = $request->coordinador;
        $region->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        Region::findOrFail($request->id)->delete();
    }
}
