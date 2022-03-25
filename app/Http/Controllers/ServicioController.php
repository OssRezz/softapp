<?php

namespace App\Http\Controllers;

use App\Custom\Modal;
use App\Models\aws;
use App\Models\servicios;
use Illuminate\Http\Request;
use App\Models\clientes;
use App\Models\tiposervicios;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class ServicioController extends Controller
{
    /**
     * Routa para la vista de servicios
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaServicios = servicios::orderBy('id', 'asc')->paginate(5);
        $listaTipoServicio = tiposervicios::All();
        return view('servicios.servicio', compact('listaServicios', 'listaTipoServicio'));
    }

    /**
     * modal para ver el detalle de los servicios
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Modal $modal)
    {
        $listaServicios = servicios::join('tiposervicios', 'tiposervicios.id', "=", "servicios.fkTipoServicio")
            ->select('tiposervicios.tipo', 'servicios.*')
            ->where('servicios.id', '=', $request->idServicio)->get();

        foreach ($listaServicios  as $listaServicios) {
            $nombre = $listaServicios['nombre'];
            $fechaInicio = $listaServicios['fechaInicio'];
            $fechaFin = $listaServicios['fechaFin'];
            $tipo = $listaServicios['tipo'];
            $observaciones = $listaServicios['observaciones'];
            $imagen = $listaServicios['imagen'];
        }



        $contenidoModal = "<div class='card p-0'>";
        $contenidoModal .= "    <img src='$imagen' loading='lazy' class='img-fluid img-thumbnail imgsize'>";
        $contenidoModal .= "    <div class='card-body p-0'>";
        $contenidoModal .= "        <ul class='list-group'>";
        $contenidoModal .= "            <li class='list-group-item'><b>Servicio: </b>$nombre</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Tipo servicio: </b>$tipo</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Fecha inicio: </b>$fechaInicio</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Fecha fin: </b>$fechaFin</li>";
        $contenidoModal .= "            <li class='list-group-item'><b>Observaciones: </b>$observaciones</li>";
        $contenidoModal .= "        </ul>";

        $contenidoModal .= "    </div>";
        $contenidoModal .= "</div>";

        $modal->modalCardUser("text-primary", "Detalle servicio", $contenidoModal);
    }

    /**
     * Almacenar un servicio
     * Recibe como parametro el nombre, fecha de inicio, fecha de fin, imagen y observaciones
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, servicios $servicio)
    {
        $request->validate([
            'Nombre' =>  'required',
            'file' =>  'required|image',
            'observacionesServicio' =>  'required',
            'inicioServicio' =>  'required',
            'finalServicio' =>  'required',
            'tipoServicio' =>  'required'
        ]);
        //Almacenamos la imagen en AWS S3
        $dataAws = aws::All();
        foreach ($dataAws as $aws) {
            $key = $aws['key'];
            $secret = $aws['secret'];
            $bucket = $aws['bucket'];
        }
        //Configuracion las opciones de aws s3, como la region, key y secret
        $S3Options = [
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' =>
            [
                'key' => $key,
                'secret' => $secret
            ],
        ];
        $s3 = new S3Client($S3Options);
        //Ingresamos la informacion a aws s3
        $uploadObject = $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $request->file,
            'SourceFile' => $request->file('file')
        ]);

        $servicio->nombre = $request->Nombre;
        $servicio->observaciones = $request->observacionesServicio;
        $servicio->fechaInicio = $request->inicioServicio;
        $servicio->fechaFin = $request->finalServicio;
        $servicio->fkTipoServicio = $request->tipoServicio;
        $servicio->imagen = $uploadObject['ObjectURL'];

        if ($servicio->save()) {
            return redirect()->back()->with('message', 'El servicio se ha registrado exitosamente');
        } else {
            return redirect()->back()->with('message', 'El servicio no se puede registrar');
        }
    }
}
