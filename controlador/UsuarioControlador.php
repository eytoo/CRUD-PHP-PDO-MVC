<?php

include '../datos/UsuarioDao.php';

class UsuarioControlador
{

    public function getUsuarios()
    {
        return UsuarioDao::getUsuarios();
    }

    public function crearUsuario($nombre, $email, $usuario, $password, $privilegio, $id)
    {
        $obj_usuario = new Usuario();
        $obj_usuario->setNombre($nombre);
        $obj_usuario->setUsuario($usuario);
        $obj_usuario->setEmail($email);
        $obj_usuario->setPrivilegio($privilegio);
        $obj_usuario->setPassword($password);
        if (!is_null($id)) {
            $obj_usuario->setId($id);
        }

        return UsuarioDao::crearUsuario($obj_usuario);
    }

    public function getUsuarioPorId($id)
    {
        return UsuarioDao::getUsuarioPorId($id);
    }

    public function eliminarUsuario($id)
    {
        return UsuarioDao::eliminarUsuario($id);
    }

}
