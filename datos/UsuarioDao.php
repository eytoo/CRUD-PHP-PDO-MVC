<?php

include 'Conexion.php';
include '../entidades/Usuario.php';

class UsuarioDao extends Conexion
{
    protected static $cnx;

    private static function getConexion()
    {
        self::$cnx = Conexion::conectar();
    }

    private static function desconectar()
    {
        self::$cnx = null;
    }

    /**
     * Metodo que sirve para obtener o buscar un usuario por su id
     *
     * @param      object         $usuario
     * @return     object
     */
    public static function getUsuarioPorId($id)
    {
        $query = "SELECT id,nombre,email,usuario,privilegio,fecha_registro FROM usuarios WHERE id = :id";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $resultado->bindParam(":id", $id);

        $resultado->execute();

        $filas = $resultado->fetch();

        $usuario = new Usuario();
        $usuario->setId($filas["id"]);
        $usuario->setNombre($filas["nombre"]);
        $usuario->setUsuario($filas["usuario"]);
        $usuario->setEmail($filas["email"]);
        $usuario->setPrivilegio($filas["privilegio"]);
        $usuario->setFecha_registro($filas["fecha_registro"]);

        return $usuario;
    }

    /**
     * Metodo que sirve para eliminar un usuario
     *
     * @param      object         $usuario
     * @return     boolean
     */
    public static function eliminarUsuario($id)
    {
        $query = "DELETE FROM usuarios WHERE id = :id";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $resultado->bindParam(":id", $id);

        $resultado->execute();

        if ($resultado->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Metodo que sirve obtener o listar todos los usuarios
     *
     * @return     object
     */
    public static function getUsuarios()
    {
        $query = "SELECT id,nombre,email,usuario,privilegio,fecha_registro FROM usuarios";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $resultado->execute();

        $filas = $resultado->fetchAll();

        return $filas;
    }

    /**
     * Metodo que sirve para crear y editar usuarios
     *
     * @param      object         $usuario
     * @return     boolean
     */
    public static function crearUsuario($usuario)
    {
        if (is_null($usuario->getId())) {
            $query = "INSERT INTO usuarios (nombre,email,usuario,password,privilegio) VALUES (:nombre,:email,:usuario,:password,:privilegio)";
        } else {
            $query = "UPDATE usuarios SET nombre=:nombre,email=:email,usuario=:usuario,password=:password WHERE id=:id";
        }

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $nombre     = $usuario->getNombre();
        $email      = $usuario->getEmail();
        $usu        = $usuario->getUsuario();
        $password   = $usuario->getPassword();
        $privilegio = $usuario->getPrivilegio();

        if (!is_null($usuario->getId())) {
            $id = $usuario->getId();
            $resultado->bindParam(":id", $id);
        } else {
            $resultado->bindParam(":privilegio", $privilegio);
        }

        $resultado->bindParam(":nombre", $nombre);
        $resultado->bindParam(":email", $email);
        $resultado->bindParam(":usuario", $usu);
        $resultado->bindParam(":password", $password);

        if ($resultado->execute()) {
            return true;
        }

        return false;
    }

}
