<?php 

require_once __DIR__ . '/../includes/app.php';
use MVC\Router;
use Controllers\LoginController;
use Controllers\TareaController;
use Controllers\Dashboardcontroller;
$router = new Router();

//login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//crear cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

//olvide mi contrseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

//reestrablecer la constraseña
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

//Confirmacion de cuenta 
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

$router->get('/planes', [LoginController::class, 'planes']);

// ZONA DE PROYECTOS
$router->get('/dashboard', [Dashboardcontroller::class, 'index']);
$router->get('/crear-proyecto', [Dashboardcontroller::class, 'crear_proyecto']);
$router->post('/crear-proyecto', [Dashboardcontroller::class, 'crear_proyecto']);
$router->get('/proyecto', [Dashboardcontroller::class, 'proyecto']);
$router->get('/perfil', [Dashboardcontroller::class, 'perfil']);
$router->post('/perfil', [Dashboardcontroller::class, 'perfil']);
$router->get('/cambiar-password', [Dashboardcontroller::class, 'cambiar_password']);
$router->post('/cambiar-password', [Dashboardcontroller::class, 'cambiar_password']);

// API para las tareas
$router->get('/api/tareas', [TareaController::class, 'index']);
$router->post('/api/tarea', [TareaController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();