<?php

namespace App\Http\Controllers;

use App\Custom\Modal;
use App\Models\clientes;
use App\Models\clienteservicios;
use App\Models\servicios;
use Illuminate\Http\Request;

class ClienteSeriviciosController extends Controller
{

    /**
     * Modal para adquirir un servicio
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modal $modal, Request $request)
    {
        $servicio = servicios::where('id', '=', $request->idServicio)->get();
        foreach ($servicio as $key => $value) {
            $nombre = $value['nombre'];
        }
        $contenidoModal = "<div class='card-body'>";
        $contenidoModal .=          "<p>Presione aceptar para adquirir el servicio: <b>$nombre</b><p/>";

        $contenidoModal .=          "<div class='form-floating mb-3'>";
        $contenidoModal .=          " <input type='number' class='form-control' placeholder='documento' id='documento'>";
        $contenidoModal .=          " <label for='documento'>Numero de documento</label>";
        $contenidoModal .=          "</div'>";


        $contenidoModal .=          "<div class='col mt-4'>";
        $contenidoModal .=              "<div class='row'>";
        $contenidoModal .=                  "<div class='col-12 col-lg-6'>";
        $contenidoModal .=                      "<div class='d-grid'>";
        $contenidoModal .=                      " <button  data-bs-dismiss='modal' class='btn btn-outline-danger mx-1'>Cancelar</button>";
        $contenidoModal .=                      "</div>";
        $contenidoModal .=                  "</div>";
        $contenidoModal .=                  "<div class='col-12 col-lg-6'>";
        $contenidoModal .=                      "<div class='d-grid'>";
        $contenidoModal .=          "            <button  id='btn-aceptar-servicio' value='$request->idServicio' class='btn btn-outline-primary mx-1'>Aceptar</button>";
        $contenidoModal .=                      "</div>";
        $contenidoModal .=                  "</div>";
        $contenidoModal .=              "</div>";
        $contenidoModal .=          "</div>";



        $contenidoModal .= "</div>";

        $modal->modalInformativa("text-primary", "Adquirir serivico", $contenidoModal);
    }

    /**
     * Adquirir un servicio
     * Recibe como parametro el documento del cliente
     * Y el id del servicio
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, clienteservicios $clienteSer, Modal $modal)
    {

        if (empty($request->documento) != 1) {

            $cliente = clientes::where("cedula", "=", $request->documento)->get();
            if ($cliente != null) {

                foreach ($cliente as $value) {
                    $idCliente = $value['id'];
                }

                $clienteSer->fkServicio = $request->idServicio;
                $clienteSer->fkCliente =  $idCliente;

                if ($clienteSer->save()) {
                    $modal->modalAlerta("text-primary", "Informacion", "Servicio adquirido con exicto.");
                }
            } else {
                $modal->modalAlerta("text-warning", "Informacion", "Aun no eres parte de nuestros clientes");
            }
        } else {
            $modal->modalAlerta("text-danger", "Informacion", "El documento es requerido para adquirir este servicio");
        }
    }
}
