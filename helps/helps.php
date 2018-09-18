<?php

/**
 * Función que sirve para validar y limpiar  un campo
 *
 * @param     input         $campo         Tiene que ser campo de tipo POST
 * @return     string
 */
function validar_campo($campo)
{
    $campo = trim($campo);
    $campo = stripcslashes($campo);
    $campo = htmlspecialchars($campo);

    return $campo;
}

function getPrivilegio($p)
{
    $privilegio = "";
    switch ($p) {
        case 1:
            $privilegio = "Administrador";
            break;

        case 2:
            $privilegio = "Usuario";
            break;

        default:
            $privilegio = "- No definido -";
            break;
    }

    return $privilegio;
}
