$(function () {
    let formLogin = $("#formLogin");
    const urlBase = "index.php";

    formLogin.on("submit", function (event) {
        event.preventDefault();

        let username = $("#username");
        let password = $("#password");

        if (username.val() === "" || password.val() === "") {
            mostrarMensaje("Debe completar todos los campos", "danger");
        } else {
            $.post(
                urlBase,
                {
                    username: username.val(),
                    password: password.val(),
                    option: "login"
                },
                function (data) {
                    data = JSON.parse(data);
                    if (data.response == "00") {
                        mostrarMensaje("Ingreso exitoso. Redirigiendo...", "success");
                        setTimeout(function () {
                            window.location = data.rol == "admin"
                                ? "index.php?page=admin"
                                : "index.php?page=talleres";
                        }, 800);
                    } else {
                        mostrarMensaje(data.message, "danger");
                    }
                }
            );
        }
    });

    function mostrarMensaje(texto, tipo) {
        $("#mensaje")
            .removeClass("d-none alert-success alert-danger alert-warning")
            .addClass("alert-" + tipo)
            .text(texto)
            .show();
    }
});
