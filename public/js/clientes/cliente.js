$(function () {
    $(document).on("click", (e) => {
        //Funcion nos muestra la modal con el detalle del cliente al hacer click en el nombre
        if (e.target.className === "mouse-pointer cliente sorting_1") {
            const idCliente = e.target.id;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/show",
                type: "POST",
                data: {
                    idCliente: idCliente,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });

            //Funcion nos muestra la modal con la datatable de los servicios adquiridos por el cliente
        } else if (e.target.id === "btn-detalle-cliente") {
            const idCliente = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/detalle",
                type: "POST",
                data: {
                    idCliente: idCliente,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });

            //Funcion nos muestra la modal de actualizar del cliente
        } else if (e.target.id === "btn-edit-cliente") {
            const idCliente = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/edit",
                type: "POST",
                data: {
                    idCliente: idCliente,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
            //Funcion recibe los parametros para actualizar el cliente
        } else if (e.target.id === "btn-actualizar-cliente") {
            const idCliente = e.target.value;
            const nombre = $("#nombreCliente").val();
            const cedula = $("#cedulaCliente").val();
            const telefono = $("#telefonoCliente").val();
            const correo = $("#correoCliente").val();
            const observaciones = $("#observacionesCliente").val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/update",
                type: "POST",
                data: {
                    idCliente: idCliente,
                    nombre: nombre,
                    cedula: cedula,
                    telefono: telefono,
                    correo: correo,
                    observaciones: observaciones,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
            //Funcion nos muestra la modal para eliminar un cliente
        } else if (e.target.id === "btn-delete-cliente") {
            const idCliente = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/modalDestroy",
                type: "POST",
                data: {
                    idCliente: idCliente,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
            //Function para eliminar el cliente
        } else if (e.target.id === "btn-destroy-cliente") {
            const idCliente = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clientes/destroy",
                type: "POST",
                data: {
                    idCliente: idCliente,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
        }
    });
});
