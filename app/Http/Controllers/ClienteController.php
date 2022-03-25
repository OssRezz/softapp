<?php

namespace App\Http\Controllers;

use App\Custom\Modal;
use App\Custom\Table;
use Illuminate\Http\Request;
use App\file;
use App\Models\aws;
use App\Models\clientes;
use App\Models\clienteservicios;
use App\Models\servicios;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use PDOException;

class ClienteController extends Controller
{
    /**
     * Retorna a la vista de clientes 
     *Tiene como parametro listaClientes la cual contiene todos los clientes.

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaClientes = clientes::orderBy('id', 'asc')->paginate(5);
        return view('clientes.cliente', compact('listaClientes'));
    }

    /**
     * Almacena un cliente a la base de datos
     * retorna un mensaje por sesion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, clientes $cliente)
    {
        $request->validate([
            'Nombre' =>  'required',
            'Cedula' =>  'required',
            'Email' =>  'required',
            'Telefono' =>  'required',
            'file' =>  'required|image',
            'Observaciones' =>  'required'
        ]);

        //Estoy usando AWS S3 para almacenar la imagen en un servidor
        //En la base de datos se encuentran el key, secret, bucket
        $dataAws = aws::All();
        foreach ($dataAws as $aws) {
            $key = $aws['key'];
            $secret = $aws['secret'];
            $bucket = $aws['bucket'];
        }
        //Enviamos los paraemtros de configuracion: Servidor, key, secret
        $S3Options = [
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' =>
            [
                'key' => $key,
                'secret' => $secret
            ],
        ];
        //Subimos el archivo
        $s3 = new S3Client($S3Options);
        $uploadObject = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $request->file,
            'SourceFile' => $request->file('file')
        ]);

        $cliente->nombre = $request->Nombre;
        $cliente->cedula = $request->Cedula;
        $cliente->correo = $request->Email;
        $cliente->telefono = $request->Telefono;
        $cliente->observaciones = $request->Observaciones;
        $cliente->imagen = $uploadObject['ObjectURL'];

        //Si la cedula se encuentra en la base de datos, no dejara ingresar la informacion
        $clienteInDatabase = clientes::where('cedula', '=', $request->Cedula)->first();
        if ($clienteInDatabase) {
            return redirect()->back()->with('message', 'El cliente ya se encuentra registrado');
        } else {
            if ($cliente->save()) {
                return redirect()->back()->with('message', 'El cliente se ha creado exitosamente');
            } else {
                return redirect()->back()->with('message', 'El cliente no se puede crear');
            }
        }
    }

    /**
     * Modal detalle del cliente con servicio
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Modal $modal, Request $request)
    {
        $listaCliente = clientes::where('id', '=', $request->idCliente)->get();
        foreach ($listaCliente  as $value) {
            $nombre = $value['nombre'];
            $cedula = $value['cedula'];
            $telefono = $value['telefono'];
            $correo = $value['correo'];
            $imagen = $value['imagen'];
            $observaciones = $value['observaciones'];
        }

        $listaServicios = clienteservicios::join('clientes', 'clientes.id', "=", "clienteservicios.fkCliente")
            ->join('servicios', 'servicios.id', "=", "clienteservicios.fkServicio")
            ->select('clientes.nombre', 'servicios.nombre as servicio')
            ->Where('fkCliente', '=', $request->idCliente)->get();

        $contenidoModal = "<div class='card p-0'>";
        $contenidoModal .= "    <img src='$imagen' loading='lazy' class='img-fluid img-thumbnail imgsize'>";
        $contenidoModal .= "    <div class='card-body p-0'>";
        $contenidoModal .= "        <ul class='list-group'>";
        $contenidoModal .= "            <li class='list-group-item'><b>Nombre: </b>$nombre</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Cedula: </b>$cedula</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Telefono: </b>$telefono</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Correo: </b>$correo</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Observaciones: </b>$observaciones</li>";
        $contenidoModal .= "        </ul>";
        $contenidoModal .= "        <hr>";
        $contenidoModal .= "        <ul class='list-group'>";
        $contenidoModal .= "            <li class='list-group-item'><h5><b class='text-primary'>Servicios: </b></h5></li>";
        if (count($listaServicios) > 1) {
            foreach ($listaServicios as $servicios) {
                $contenidoModal .= "            <li class='list-group-item'><b>{$servicios['servicio']} </b></li>";
            }
        } else {
            $contenidoModal .= "            <li class='list-group-item'><b>Cliente sin servicios activos</b></li>";
        }
        $contenidoModal .= "        </ul>";

        $contenidoModal .= "    </div>";
        $contenidoModal .= "</div>";

        $modal->modalCardUser("text-primary", "Detalle cliente", $contenidoModal);
    }

    /**
     * DataTable con todos los servicios del cliente
     *
     * @return \Illuminate\Http\Response
     */
    public function datalleCliente(Table $table, Modal $modal, Request $request)
    {
        $listaCliente = clientes::where('id', '=', $request->idCliente)->get();
        foreach ($listaCliente  as $value) {
            $cedula = $value['cedula'];
        }
        $listaServicios = clienteservicios::join('clientes', 'clientes.id', "=", "clienteservicios.fkCliente")
            ->join('servicios', 'servicios.id', "=", "clienteservicios.fkServicio")
            ->select('servicios.nombre as servicio', 'servicios.fechaInicio', 'servicios.fechaFin', 'clientes.nombre as cliente', 'clientes.cedula',)
            ->Where('fkCliente', '=', $request->idCliente)->get();

        $contenidoModal = "</tbody>";
        foreach ($listaServicios as $key => $value) {
            # code...
            $contenidoModal .= "<tr>";
            $contenidoModal .= "<td class='text-center'>{$value['cliente']}</td>";
            $contenidoModal .= "<td class='text-center'>{$value['cedula']}</td>";
            $contenidoModal .= "<td class='text-center'>{$value['servicio']}</td>";
            $contenidoModal .= "<td class='text-center'>{$value['fechaInicio']}</td>";
            $contenidoModal .= "<td class='text-center'>{$value['fechaFin']}</td>";
            $contenidoModal .= "</td>";
            $contenidoModal .= "</tr>";
        }
        $contenidoModal .= "</tbody>";
        $table->tableSede("text-primary", "Datalle", $contenidoModal, $cedula);
    }


    /**
     * Modal para editar un cliente
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modal $modal, Request $request)
    {

        $ClienteById = clientes::where('id', '=', $request->idCliente)->get();

        $contenidoModal = "                <div class='row g-3'>";

        foreach ($ClienteById as $key => $client) {

            $contenidoModal .= "                  <div class='col-12'>";
            $contenidoModal .= "                    <div class='form-floating'>";
            $contenidoModal .= "                      <input  id='nombreCliente' value='{$client['nombre']}' type='text' class='form-control' placeholder='Nombre cliente'>";
            $contenidoModal .= "                      <label for='nombreCliente'>Nombre cliente</label>";
            $contenidoModal .= "                    </div>";
            $contenidoModal .= "                  </div>";
            //
            $contenidoModal .= "                  <div class='col-12'>";
            $contenidoModal .= "                    <div class='form-floating'>";
            $contenidoModal .= "                      <input id='cedulaCliente' type='number' value='{$client['cedula']}' class='form-control' placeholder='Cedula cliente'>";
            $contenidoModal .= "                      <label for='cedulaCliente'>Cedula cliente</label>";
            $contenidoModal .= "                    </div>";
            $contenidoModal .= "                  </div>";
            //
            $contenidoModal .= "                  <div class='col-12'>";
            $contenidoModal .= "                    <div class='form-floating'>";
            $contenidoModal .= "                      <input id='telefonoCliente' type='number' value='{$client['telefono']}' class='form-control' placeholder='Telefono cliente'>";
            $contenidoModal .= "                      <label for='telefonoCliente'>Telefono cliente</label>";
            $contenidoModal .= "                    </div>";
            $contenidoModal .= "                  </div>";
            //
            $contenidoModal .= "                  <div class='col-12'>";
            $contenidoModal .= "                    <div class='form-floating'>";
            $contenidoModal .= "                      <input id='correoCliente' type='email' value='{$client['correo']}' class='form-control' placeholder='Correo cliente'>";
            $contenidoModal .= "                      <label for='correoCliente'>Correo cliente</label>";
            $contenidoModal .= "                    </div>";
            $contenidoModal .= "                  </div>";
            //
            $contenidoModal .= "                  <div class='col-12'>";
            $contenidoModal .= "                    <div class='form-floating'>";
            $contenidoModal .= "                      <textarea  id='observacionesCliente' placeholder='Observaciones' class='form-control' style='height: 100px'>{$client['observaciones']}</textarea>";
            $contenidoModal .= "                      <label for='observacionesCliente'>Observaciones cliente</label>";
            $contenidoModal .= "                    </div>";
            $contenidoModal .= "                  </div>";
            //
            $contenidoModal .= "                <div class='d-grid'>";
            $contenidoModal .= "                <button class='btn btn-outline-primary' value='{$client['id']}'  id='btn-actualizar-cliente'>Acualizar cliente</button>";
            $contenidoModal .= "                </div>";
        }

        $contenidoModal .= "                </div>";

        $modal->modalInformativa("text-primary", "Actualizar cliente", $contenidoModal);
    }


    /**
     * Actualizar un cliente
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modal $modal, clientes $cliente)
    {

        if (
            empty($request->nombre) != 1 && empty($request->cedula) != 1 &&
            empty($request->correo) != 1  && empty($request->telefono) != 1 &&
            empty($request->observaciones) != 1
        ) {

            $ClienteById = clientes::where('id', '=', $request->idCliente)->get();
            foreach ($ClienteById as $key => $value) {
                $imagen = $value['imagen'];
            }
            $cliente = clientes::find($request->idCliente);
            $cliente->nombre = $request->nombre;
            $cliente->cedula = $request->cedula;
            $cliente->correo = $request->correo;
            $cliente->telefono = $request->telefono;
            $cliente->observaciones = $request->observaciones;
            $cliente->imagen = $imagen;

            if ($cliente->update()) {
                $modal->modalAlerta("text-primary", "Informacion", 'El cliente se ha actualizado con exito');
            } else {
                $modal->modalAlerta("text-primary", "Informacion", 'El cliente no se puede actualizar');
            }
        } else {
            $modal->modalAlerta("text-danger", "Informacion", 'Todos los campos son requeridos');
        }
    }

    /**
     * Modal para eliminar un cliente
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modalDestroy(Request $request, Modal $modal)
    {
        $contenidoModal = "<div class='card-body'>";
        $contenidoModal .=          "<p class='mb-3'>¿Eliminar este cliente?<p/>";

        $contenidoModal .=          "<div class='col mt-4'>";
        $contenidoModal .=              "<div class='row'>";
        $contenidoModal .=                  "<div class='col-12 col-lg-6'>";
        $contenidoModal .=                      "<div class='d-grid'>";
        $contenidoModal .=                           " <button  data-bs-dismiss='modal' class='btn btn-outline-danger mx-1'>Cancelar</button>";
        $contenidoModal .=                      "</div>";
        $contenidoModal .=                  "</div>";
        $contenidoModal .=                  "<div class='col-12 col-lg-6'>";
        $contenidoModal .=                      "<div class='d-grid'>";
        $contenidoModal .=          "                <button  id='btn-destroy-cliente' value='$request->idCliente' class='btn btn-outline-primary mx-1'>Eliminar</button>";
        $contenidoModal .=                      "</div>";
        $contenidoModal .=                  "</div>";
        $contenidoModal .=              "</div>";
        $contenidoModal .=          "</div>";

        $contenidoModal .= "</div>";

        $modal->modalInformativa("text-danger", "Eliminar cliente", $contenidoModal);
    }

    /**
     * Eliminar un cliente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modal $modal)
    {
        try {
            if (clientes::where('id', $request->idCliente)->firstorfail()->delete()) {
                $modal->modalAlerta("text-primary", "Informacion", 'Cliente eliminado exitosamente');
            }
        } catch (PDOException $e) {
            $modal->modalAlerta("text-danger", "Informacion", 'Este cliente no se puede eliminar, dado que tiene registros asociados');
        }
    }
}
