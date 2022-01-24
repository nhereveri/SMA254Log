<?php

namespace Airviro\SMA254Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Airviro\SMA254Log\SMA254Log;

class SMA254LogController extends Controller
{
    public function index()
    {
        return SMA254Log::orderBy('unixtime', 'desc')->paginate(env('SMA254LOG_PAGINATION', 100));
    }

    public function show($id)
    {
        return SMA254Log::findOrFail($id);
    }

    public function proceso($uf, $proceso)
    {
        return SMA254Log::where('uf', '=', $uf)->where('proceso', '=', $proceso)->orderBy('unixtime', 'asc')->cursorPaginate(env('SMA254LOG_PAGINATION', 100));
    }

    public function procesoFrom($uf, $proceso, $from)
    {
        return SMA254Log::where('uf', '=', $uf)->where('proceso', '=', $proceso)->where('unixtime', '>=', $from)->orderBy('unixtime', 'asc')->cursorPaginate(env('SMA254LOG_PAGINATION', 100));
    }

    public function procesoFromTo($uf, $proceso, $from, $to)
    {
        return SMA254Log::where('uf', '=', $uf)->where('proceso', '=', $proceso)->where('unixtime', '>=', $from)->where('unixtime', '<=', $to)->orderBy('unixtime', 'asc')->cursorPaginate(env('SMA254LOG_PAGINATION', 100));
    }

    public function dispositivo($uf, $proceso, $dispositivo)
    {
        $output = array();
        $procesos = $this->proceso($uf, $proceso);
        foreach($procesos as $proceso) {
            foreach($proceso->data as $data) {
                if($data['dispositivoId'] == $dispositivo) {
                    array_push($output, [
                        'unixtime' => $proceso->unixtime,
                        'uf' => $proceso->uf,
                        'proceso' => $proceso->proceso,
                        'id' => $proceso->id,
                        'dispositivo' => $data['dispositivoId'],
                        'parametros' => $data['parametros'],
                        'enviado' => $proceso->enviado
                    ]);
                }
            }
        }
        return response()->json($output, 200);
    }

    public function parametro($uf, $proceso, $dispositivo, $parametro)
    {
        $output = array();
        $procesos = $this->proceso($uf, $proceso);
        foreach($procesos as $proceso) {
            foreach($proceso->data as $data) {
                if($data['dispositivoId'] == $dispositivo) {
                    foreach($data['parametros'] as $par) {
                        if($par['nombre'] == $parametro) {
                            array_push($output, [
                                'unixtime' => $proceso->unixtime,
                                'uf' => $proceso->uf,
                                'proceso' => $proceso->proceso,
                                'id' => $proceso->id,
                                'dispositivo' => $data['dispositivoId'],
                                'parametro' => $par['nombre'],
                                'unidad' => $par['unidad'],
                                'valor' => $par['valor'],
                                'enviado' => $proceso->enviado
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json($output, 200);
    }

    public function from($uf, $proceso, $dispositivo, $parametro, $from)
    {
        $output = array();
        return $this->procesoFrom($uf, $proceso, $from);
    }

    public function fromTo($uf, $proceso, $dispositivo, $parametro, $from, $to)
    {
        $output = array();
        return $this->procesoFromTo($uf, $proceso, $from, $to);
    }

    public function highcharts($uf, $proceso, $dispositivo, $parametro, $from, $to)
    {
        $output = array();
        $procesos = $this->procesoFromTo($uf, $proceso, $from, $to);

        foreach($procesos as $proceso) {
            foreach($proceso->data as $data) {
                if($data['dispositivoId'] == $dispositivo) {
                    foreach($data['parametros'] as $par) {
                        if($par['nombre'] == $parametro) {
                            array_push($output, [
                                'x' => $proceso->unixtime*1000,
                                'y' => $par['valor'],
                                'id' => $proceso->id,
                                'unidad' => $par['unidad'],
                                'enviado' => $proceso->enviado*1000
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json(array(
            'previous_page_url' => $procesos->previousPageUrl(),
            'next_page_url' => $procesos->nextPageUrl(),
            'data' => $output
        ), 200);
    }
}
