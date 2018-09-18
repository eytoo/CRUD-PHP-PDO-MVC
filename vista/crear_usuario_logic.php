<?php

include '../controlador/UsuarioControlador.php';
include '../helps/helps.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["txtNombre"]) && isset($_POST["txtEmail"]) && isset($_POST["txtUsuario"]) && isset($_POST["txtPassword"])) {

        $txtNombre     = validar_campo($_POST["txtNombre"]);
        $txtEmail      = validar_campo($_POST["txtEmail"]);
        $txtUsuario    = validar_campo($_POST["txtUsuario"]);
        $txtPassword   = validar_campo($_POST["txtPassword"]);
        $txtPrivilegio = 2;

        if (isset($_POST["id"])) {
            if (UsuarioControlador::crearUsuario($txtNombre, $txtEmail, $txtUsuario, $txtPassword, $txtPrivilegio, validar_campo($_POST["id"]))) {
                header("location:index.php");
            }
        } else {
            if (UsuarioControlador::crearUsuario($txtNombre, $txtEmail, $txtUsuario, $txtPassword, $txtPrivilegio, null)) {
                header("location:index.php");
            }
        }

    }
} else {
    header("location:crear_usuario_form.php?error=1");
}
