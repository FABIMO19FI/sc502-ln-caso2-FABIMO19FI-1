$(function () {
    const urlBase = "index.php";

    cargarTalleres();

    function cargarTalleres() {
        $.ajax({
            url: urlBase,
            type: "GET",
            data: { option: "talleres_json" },
            success: function (data) {
                data = JSON.parse(data);
                renderizarTalleres(data);
            },
            error: function () {
                mostrarMensaje("Error al cargar los talleres", "danger");
            }
        });
    }

    function renderizarTalleres(talleres) {
        let tbody = $("#talleres-body");
        tbody.empty();

        if (talleres.length === 0) {
            tbody.append(
                '<tr><td colspan="6" class="text-center text-muted">No hay talleres disponibles con cupos en este momento.</td></tr>'
            );
            return;
        }

        $.each(talleres, function (index, taller) {
            let fila = '<tr>' +
                '<td>' + (index + 1) + '</td>' +
                '<td>' + taller.nombre + '</td>' +
                '<td>' + taller.descripcion + '</td>' +
                '<td class="text-center">' + taller.cupo_maximo + '</td>' +
                '<td class="text-center"><span class="badge bg-success fs-6">' + taller.cupo_disponible + '</span></td>' +
                '<td class="text-center">' +
                    '<button class="btn btn-primary btn-sm btn-solicitar" data-id="' + taller.id + '" data-nombre="' + taller.nombre + '">' +
                        'Solicitar Inscripción' +
                    '</button>' +
                '</td>' +
            '</tr>';
            tbody.append(fila);
        });
    }

    $(document).on("click", ".btn-solicitar", function () {
        let tallerId = $(this).data("id");
        let tallerNombre = $(this).data("nombre");
        let boton = $(this);

        boton.prop("disabled", true).text("Enviando...");

        $.post(
            urlBase,
            { option: "solicitar", taller_id: tallerId },
            function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    mostrarMensaje(data.message, "success");
                    boton.text("Solicitud Enviada").addClass("btn-secondary").removeClass("btn-primary");
                } else {
                    mostrarMensaje(data.message, "danger");
                    boton.prop("disabled", false).text("Solicitar Inscripción");
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
