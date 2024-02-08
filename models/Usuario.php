<?php 

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //validar login
    public function validarLogin(){
        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) && $this->email){
            self::$alertas['errores'][] = 'EMAIL NO VALIDO';
        }
        if(!$this->email){
            self::$alertas['errores'] [] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['errores'] [] = 'La contraseña no puede ir vacia';
        }
        return self::$alertas;
    }

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['errores'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->email){
            self::$alertas['errores'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }
    
    //validacion para cuentas nuevas
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['errores'] [] = 'El nombre es obligatorio';
        }
        if(!$this->email){
            self::$alertas['errores'] [] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['errores'] [] = 'La contraseña no puede ir vacia';
        }
        if(strlen($this->password) < 6 && ($this->password)){
            self::$alertas['errores'] [] = 'La contraseña debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2 && strlen($this->password) >= 6){
            self::$alertas['errores'] [] = 'Las contraseñas no coinciden';
        }

        return self::$alertas;
    } 

    //validar un email
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['errores'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['errores'][] = 'EMAIL NO VALIDO';
        }
        return self::$alertas;
    }
    //validar la contraseña
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['errores'] [] = 'La contraseña no puede ir vacia';
        }
        if(strlen($this->password) < 6 && ($this->password)){
            self::$alertas['errores'] [] = 'La contraseña debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }
    // hashear el password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function nuevo_password(){
        if(!$this->password_actual){
            self::$alertas['errores'][] = 'La contraseña actual no puede ir vacia';
        }
        if(!$this->password_nuevo && $this->password_actual){
            self::$alertas['errores'][] = 'La contraseña nueva no puede ir vacia';
        }
        if($this->password_nuevo && strlen($this->password_nuevo) < 6 && $this->password_actual){
            self::$alertas['errores'][] = 'La contraseña nueva debe tener mas de 6 caracteres';
        }
        return self::$alertas;
    }

    public function comprobar_password(){
        return password_verify($this->password_actual, $this->password);
    }
}