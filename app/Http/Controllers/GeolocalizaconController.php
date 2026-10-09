<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeolocalizaconController extends Controller
{
   public function obtenerUbicacion(Request $request)
   {
    $ip = $request->ip();
    //$respuesta = Http::get("http://ip-api.com/json/{$ip}");
        $respuesta = Http::get("http://ip-api.com/json/201.131.7.239");

    
    if ($respuesta->failed()) {
        return response()->json(['error' => 'No se pudo obtener la ubicacion'],500);
    }  
    
   // return response()->json([
    return view('geolocalizacion.ipubicacion',compact('respuesta'));


    }
}
