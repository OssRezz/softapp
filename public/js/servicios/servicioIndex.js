$(function () {
    $(document).on("click", (e) => {
        //Modal para adquirir un servicio
        if (e.target.id === "btn-servicio") {
            const idServicio = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clienteservicios/create",
                type: "POST",
                data: {
                    idServicio: idServicio,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
            //Informacion del cliente para adquirir el servicio
        } else if (e.target.id === "btn-aceptar-servicio") {
            const idServicio = e.target.value;
            const documento = $("#documento").val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "clienteservicios/store",
                type: "POST",
                data: {
                    idServicio: idServicio,
                    documento: documento,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
        } else if (e.target.id === "btn-detalle-servicio") {
            alert(e.target.value);
        }
    });
});
