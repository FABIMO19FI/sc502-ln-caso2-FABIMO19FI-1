$(function () {
    const urlBase = "index.php";

    if ($("#solicitudes-body").length) {
        cargarSolicitudes();
    }

    function cargarSolicitudes() {
        $.ajax({
            url: urlBase,
            type: "GET",
            data: { option: "solicitudes_json" },
            success: function (data) {
                data = JSON.parse(data);
                renderizarSolicitudes(data);
            },
            error: function () {
                mostrarMensaje("Error al cargar las solicitudes", "danger");
            }
        });
    }

    function renderizarSolicitudes(solicitudes) {
        let tbody = $("#solicitudes-body");
        tbody.empty();

        if (solicitudes.length === 0) {
            tbody.append(
                '<tr><td colspan="5" class="text-center text-muted">No hay solicitudes pendientes en este momento.</td></tr>'
            );
            return;
        }

        $.each(solicitudes, function (index, sol) {
            let fila = '<tr id="fila-' + sol.id + '">' +
                '<td>' + sol.id + '</td>' +
                '<td>' + sol.taller_nombre + '</td>' +
                '<td>' + sol.usuario_username + '</td>' +
                '<td>' + sol.fecha_solicitud + '</td>' +
                '<td class="text-center">' +
                    '<button class="btn btn-success btn-sm btn-aprobar me-2" data-id="' + sol.id + '">Aprobar</button>' +
                    '<button class="btn btn-danger btn-sm btn-rechazar" data-id="' + sol.id + '">Rechazar</button>' +
                '</td>' +
            '</tr>';
            tbody.append(fila);
        });
    }

    // Aprobar solicitud
    $(document).on("click", ".btn-aprobar", function () {
        let solicitudId = $(this).data("id");
        let fila = $("#fila-" + solicitudId);
        let boton = $(this);

        boton.prop("disabled", true).text("Procesando...");

        $.post(
            urlBase,
            { option: "aprobar", id_solicitud: solicitudId },
            function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    mostrarMensaje(data.message, "success");
                    fila.fadeOut(500, function () { $(this).remove(); });
                } else {
                    mostrarMensaje(data.message, "danger");
                    boton.prop("disabled", false).text("Aprobar");
                }
            }
        );
    });

    $(document).on("click", ".btn-rechazar", function () {
        let solicitudId = $(this).data("id");
        let fila = $("#fila-" + solicitudId);
        let boton = $(this);

        boton.prop("disabled", true).text("Procesando...");

        $.post(
            urlBase,
            { option: "rechazar", id_solicitud: solicitudId },
            function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    mostrarMensaje(data.message, "success");
                    fila.fadeOut(500, function () { $(this).remove(); });
                } else {
                    mostrarMensaje(data.message, "danger");
                    boton.prop("disabled", false).text("Rechazar");
                }
            }
        );
    });

    $("#btnLogout").on("click", function () {
        $.post(urlBase, { option: "logout" }, function () {
            window.location.href = "index.php?page=login";
        });
    });

    function mostrarMensaje(texto, tipo) {
        $("#mensaje")
            .removeClass("d-none alert-success alert-danger alert-warning")
            .addClass("alert-" + tipo)
            .text(texto)
            .fadeIn();

        setTimeout(function () {
            $("#mensaje").fadeOut(function () {
                $(this).addClass("d-none");
            });
        }, 4000);
    }
});
