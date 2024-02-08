<?php


namespace Controllers;

use MVC\Router;
use Model\Proyecto;

 class Dashboardcontroller{
    public static function index (Router $router){

        session_start();
        isAuth();
        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        

        $router->render('dashboard/index', [
            'titulo' => 'proyectos',
            'proyectos' => $proyectos
            

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
        
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
            

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

 }