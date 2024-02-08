<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;




class LoginController{

    //funcion para el login
    public static function login(Router $router){
        
        $contenidoCentrado = true;
        $esPaginaPrincipal = true;
        $alertas = [];
        $barraprincipal = true;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();   
            
            if(empty($alertas)) {
                //verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if(!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('errores', 'El usuario no Existe o no esta confirmado');
                } else{
                    //el usuario existe
                    if(password_verify($_POST['password'], $usuario->password)){
                        //iniciar la sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        //REDIRECCIONAR UAN VEZ VALIDADO Y INICIADA LA SESION CON LOS DATOS
                        header('Location: /dashboard');
                        

                    } else {
                        Usuario::setAlerta('errores', 'Contraseña incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'esPaginaPrincipal' => $esPaginaPrincipal,
            'alertas' => $alertas,
            'barraprincipal' => $barraprincipal
            
        ]);
    }

    //funcino para el logout
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }
    }

    //funcion para crear cuenta 
    public static function crear(Router $router){

        $alertas = [];
        $usuario = new Usuario;
        $contenidoCentrado = true;
        $esPaginaSecundaria = true;
        $barraprincipal = true;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //hacemos que se guarden los datos del formulario para no introducirlos cada vez que no pasa la validacion
            $usuario->sincronizar($_POST);
            //hacemos que el usuario ingrese los datos segun nuestra validacion
            $alertas = $usuario->validarNuevaCuenta();

                // si no hay alertas en la validacion comprobamos si el usuario existe por medio del email
                if(empty($alertas)){
                
                    $existeUsuario = Usuario::where('email', $usuario->email);
                    //si el usuario ya existe volvemos a mostrar el arreglo de errores con dicha info
                    if($existeUsuario){
                        Usuario::setAlerta('errores', 'El Usuario ya esta registrado');
                        $alertas = Usuario::getAlertas();
                    } else{
                        //HASHEAR PASSWORD
                        $usuario->hashPassword();
                        //eliminar  password2 ya que no lo necesitamos despues de la validacion
                        unset($usuario->password2);
                        //crear token
                        $usuario->crearToken();
                        //crear el nuevo usuario si no existe el mail
                        $resultado = $usuario->guardar();

                        //enviar email
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarConfirmacion();


                       

                        if($resultado){
                            header('Location: /mensaje');
                        }

                    }
                }
        }

        //render a la vista 
        $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'esPaginaSecundaria' => $esPaginaSecundaria,
            'contenidoCentrado' => $contenidoCentrado,
            'usuario' => $usuario,
            'alertas' => $alertas,
            'barraprincipal' => $barraprincipal
        ]);
    }


    //funcion para recuperar contrseña si se olvida 
    public static function olvide(Router $router){

        $alertas = [];
        $contenidoCentrado = true;
        $esPaginaSecundaria = true;
        $barraprincipal = true;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                //buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado === "1") {
                    //Generar un nuevo token

                    $usuario->crearToken();
                    unset($usuario->password2);
                    //actualizar el usuario
                    $usuario->guardar();
                    //enviar el email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //imprimir la alerta
                    Usuario::setAlerta('exito', 'hemos enviado las intrucciones a tu email');
                } else{
                    Usuario::setAlerta('errores', 'El usuario no existe o no esta confirmado');
                    
                }
            }

        }
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi contraseña',
            'esPaginaSecundaria' => $esPaginaSecundaria,
            'contenidoCentrado' => $contenidoCentrado,
            'alertas' => $alertas,
            'barraprincipal' => $barraprincipal
        ]);

    }

     //funcion para reestablecer la contraseña 
     public static function reestablecer(Router $router){
        $esPaginaSecundaria = true;
        $contenidoCentrado = true;
        $mostrar = true;
        $barraprincipal = true;

        $token = s($_GET['token']);
        
        if(!$token) header('Location: /');
        
        //identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('errores', 'token no valido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //añadir la nueva contraseña
            $usuario->sincronizar($_POST);

            //validar el nuevo password
            $alertas = $usuario->validarPassword();
            
            if(empty($alertas)) {
                //hashear el nuevo password 
                $usuario->hashPassword();

                //eliminar token
                $usuario->token = null;

                //guardar el usuario en la bbdd
                $resultado = $usuario->guardar();

                //redireccionar
                if($resultado){
                    header('Location: /');
                }

                
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Contraseña',
            'contenidoCentrado' => $contenidoCentrado,
            'esPaginaSecundaria' => $esPaginaSecundaria,
            'alertas' => $alertas,
            'mostrar' => $mostrar,
            'barraprincipal' => $barraprincipal
        ]);
        
    }

    //funcion para reestablecer la contraseña 
    public static function mensaje(Router $router){
            
        $contenidoCentrado = true;
        $barraprincipal = true;

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada con exito',
            'contenidoCentrado' => $contenidoCentrado,
            'barraprincipal' => $barraprincipal
        ]);
    }

    //funcion para reestablecer la contraseña 
    public static function confirmar(Router $router){

        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        //encontrar el usuario con ese token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            //no se encontro el usuario con ese token en la bbdd
            Usuario::setAlerta('errores', 'Token no Valido');
        } else{
            //confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            //guardar en bbdd
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
            
        }

        $alertas = Usuario::getAlertas();

        $contenidoCentrado = true;
        $barraprincipal = true;

        $router->render('auth/confirmar', [
            'titulo' => 'confirma tu cuenta UpTask',
            'contenidoCentrado' => $contenidoCentrado,
            'alertas' => $alertas,
            'barraprincipal' => $barraprincipal
        ]);
             
    }




    //funcion para reestablecer la contraseña 
    public static function planes(Router $router){

        $contenidoCentrado = true;
        $esPaginaPrincipal = true;
        $barraprincipal = true;

        $router->render('navbar/planes', [
            'titulo' => 'Planes',
            'contenidoCentrado' => $contenidoCentrado,
            'esPaginaPrincipal' => $esPaginaPrincipal,
            'barraprincipal' => $barraprincipal
        ]);
             
    }
}