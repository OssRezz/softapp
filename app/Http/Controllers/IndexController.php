<?php

namespace App\Http\Controllers;

use App\Models\servicios;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Routa para la vista de inicio
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaServicios = servicios::join('tiposervicios', 'tiposervicios.id', "=", "servicios.fkTipoServicio")
            ->select('tiposervicios.tipo', 'servicios.*')
            ->orderBy('id', 'desc')->paginate(5);

        return view('welcome', compact('listaServicios'));
    }
}
