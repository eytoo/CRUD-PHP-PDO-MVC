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
     * Metodo que sirve para validar el login
     *
     * @param      object         $usuario
     * @return     boolean
     */
    public static function login($usuario)
    {
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $usu  = $usuario->getUsuario();
        $pass = $usuario->getPassword();

        $resultado->bindParam(":usuario", $usu);
        $resultado->bindParam(":password", $pass);

        $resultado->execute();

        if ($resultado->rowCount() > 0) {
            $filas = $resultado->fetch();
            if ($filas["usuario"] == $usuario->getUsuario()
                && $filas["password"] == $usuario->getPassword()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Metodo que sirve para obtener un usuario
     *
     * @param      object         $usuario
     * @return     object
     */
    public static function getUsuario($usuario)
    {
        $query = "SELECT id,nombre,email,usuario,privilegio,fecha_registro FROM usuarios WHERE usuario = :usuario AND password = :password";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $usu  = $usuario->getUsuario();
        $pass = $usuario->getPassword();

        $resultado->bindParam(":usuario", $usu);
        $resultado->bindParam(":password", $pass);

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
     * Metodo que sirve para obtener un usuario por su id
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
     * Metodo que sirve obtener todos los usuarios
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
     * Metodo que sirve para registrar usuarios
     *
     * @param      object         $usuario
     * @return     boolean
     */
    public static function registrar($usuario)
    {
        $query = "INSERT INTO usuarios (nombre,email,usuario,password,privilegio) VALUES (:nombre,:email,:usuario,:password,:privilegio)";

        self::getConexion();

        $resultado = self::$cnx->prepare($query);

        $resultado->bindParam(":nombre", $usuario->getNombre());
        $resultado->bindParam(":email", $usuario->getEmail());
        $resultado->bindParam(":usuario", $usuario->getUsuario());
        $resultado->bindParam(":password", $usuario->getPassword());
        $resultado->bindParam(":privilegio", $usuario->getPrivilegio());

        if ($resultado->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Metodo que sirve para crear nuevos usuarios
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
