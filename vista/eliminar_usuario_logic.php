<?php

include '../controlador/UsuarioControlador.php';
include '../helps/helps.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {

        $id = validar_campo($_GET["id"]);

        if (UsuarioControlador::eliminarUsuario($id)) {
            header("location:index.php");
        }

    }
} else {
    header("location:index.php?error=1");
}
