<?php

namespace App\Custom;

class Table
{
    public function tableSede($color, $tituloModal, $contenidoBody, $documento)
    {

        echo "<!-- Modal -->";
        echo "<div class='modal fade' id='modalAlerta' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true' style='display: block;' data-keyboard='false' data-backdrop='static'>";
        echo "  <div class='modal-dialog modal-lg modal-dialog-centered'>";
        echo "    <div class='modal-content'>";
        echo "      <div class='modal-header  border-0'>";
        echo "        <h5 class='modal-title $color' id='exampleModalLabel'>" . $tituloModal . "</h5>";
        echo "                <button type='button' class='btn-close' id='close' data-bs-dismiss='modal' aria-label='Close'></button>";
        echo "      </div>";
        echo "      <div class='modal-body'>";


        echo "<table class='table table-hover table-sm' id='tablaDetalle' class='display' style='width: 100%'>";
        echo  "<thead>";
        echo  "  <tr>";
        echo  "    <th class='text-center'>Cliente</th>";
        echo  "    <th class='text-center'>Cedula</th>";
        echo  "    <th class='text-center'>Servicio</th>";
        echo  "    <th class='text-center'>F. Inicio</th>";
        echo  "    <th class='text-center'>F. Fin</th>";
        echo  "  </tr>";
        echo  "</thead>";
        echo $contenidoBody;
        echo  "</table>";

        echo "       </div>";
        echo "      </div>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
        echo "<script>$('#modalAlerta').modal('show')</script>";
        echo  "<script>$('#tablaDetalle').DataTable({'search': {'search': $documento}, responsive: true, order: [[0, 'desc']] });</script>";
        echo  "<script>$('#tablaDetalle_filter input').text('1231231245');</script>";
    }
}
