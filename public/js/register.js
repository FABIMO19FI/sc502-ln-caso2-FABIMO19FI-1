$(function () {
    let formRegister = $("#formRegister");
    const urlBase = "index.php";

    formRegister.on("submit", function (event) {
        event.preventDefault();

        let username = $("#username");
        let password = $("#password");

        if (username.val() === "" || password.val() === "") {
            mostrarMensaje("Debe completar todos los campos", "danger");
            return;
        }

        $.ajax({
            url: urlBase,
            type: "POST",
            data: $(this).serialize() + "&option=register",
            success: function (data) {
                data = JSON.parse(data);
                if (data.response === "00") {
                    mostrarMensaje("Registro exitoso. Redirigiendo...", "success");
                    setTimeout(function () {
                        window.location.href = "index.php?page=talleres";
                    }, 800);
                } else {
                    mostrarMensaje(data.message, "danger");
                }
            },
            error: function () {
                mostrarMensaje("Error de conexión con el servidor", "danger");
            }
        });
    });

    function mostrarMensaje(texto, tipo) {
        $("#mensaje")
            .removeClass("d-none alert-success alert-danger alert-warning")
            .addClass("alert-" + tipo)
            .text(texto)
            .show();
    }
});
