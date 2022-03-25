$(function () {
    $(document).on("click", (e) => {
        //Modal con el detalle de los servicios
        if (e.target.id === "btn-detalle-servicio") {
            const idServicio = e.target.value;
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "servicios/create",
                type: "POST",
                data: {
                    idServicio: idServicio,
                },
                success: function (result) {
                    $("#response").html(result);
                },
            });
        }
    });
});
