<?php


namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;

class Dashboardcontroller{
    public static function index (Router $router){

        session_start();
        isAuth();
        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        

        $router->render('dashboard/index', [
            'titulo' => 'proyectos',
            'proyectos' => $proyectos,
            
            

        ]);
    }

    public static function crear_proyecto (Router $router){

        session_start();

        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                //generar una url unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                //almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];
                // Guardar el proyecto 
                $proyecto->guardar();

                //redireccionar
                header('Location: /proyecto?url=' . $proyecto->url);

            }
        }
        
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear proyecto',
            'alertas' => $alertas
            

        ]);
    }

    public static function perfil(Router $router){

        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)){

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    Usuario::setAlerta('errores', 'Email no valido, cuenta ya registrada');
                    $alertas = $usuario->getAlertas();
                }else{
                    //guardar el usuario
                    $usuario->guardar();
                    Usuario::setAlerta('exito', 'Cambios Guardados Correctamente');
                    $alertas = $usuario->getAlertas();
                    //asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }   
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
            

        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $token = $_GET['url'];
        if(!$token) header('Location: /dashboard');

        //revisar que la persona que lo visita es la que lo creo 
        $proyecto = Proyecto::Where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');
        }
        

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto

        ]);
    }

    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario= Usuario::find($_SESSION['id']);

            //sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();
            
            if(empty($alertas)){
                
                $resultado = $usuario->comprobar_password();
                
                if($resultado){
                    //Asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //hashear el nuevo password
                    $usuario->hashPassword();

                    //actualizar usuario
                    $resultado = $usuario->guardar();
                    
                    if($resultado){
                        Usuario::setAlerta('exito', 'Contraseña actualizada con exito!');
                        $alertas = $usuario->getAlertas();
                    }


                } else{
                    Usuario::setAlerta('errores', 'Contraseña actual incorrecta');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' =>'Cambiar Contraseña',
            'alertas' => $alertas
        ]);
    }



}