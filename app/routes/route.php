<?php

namespace app\routes;

use config\Database;
use app\controller\MiembroController;
use app\controller\AportacionController;
use app\controller\AsociadoController;
use app\controller\BalanceController;
use app\controller\UserController;
use app\controller\LogroController;
use app\controller\ContactoController;
use app\controller\PersonaController;
use app\controller\EventoPersonaController;
use app\controller\EventoController;
use app\controller\EventoMiembroController;
use app\controller\NoticiaController;
use app\controller\NoticiaPersonaController;
use app\controller\MiembrosLogrosController;
use app\controller\CategoriaController;
use app\controller\TesoreroController;

if (!isset($GLOBALS['router'])) {
    die("Error: El enrutador no está inicializado.");
}

$router = $GLOBALS['router']; // Obtiene la instancia global
$db = new Database();

// Instancia del controlador con la base de datos

$userController = new UserController($db);
$miembroController = new MiembroController($db);
$logroController = new LogroController($db);
$contactoController = new ContactoController($db);
$personaController = new PersonaController($db);
$eventoPersonaController = new EventoPersonaController($db);
$eventoController = new EventoController($db);
$eventoMiembroController = new EventoMiembroController($db);
$noticiaController = new NoticiaController($db);
$noticiaPersonaController = new NoticiaPersonaController($db);
$miembrosLogrosController = new MiembrosLogrosController($db);
$userController = new UserController($db);
$categoriaController  = new CategoriaController($db);
$aportacionController = new AportacionController($db);
$asociadoController = new AsociadoController($db);
$balanceController = new BalanceController($db);
$tesoreroController = new TesoreroController($db);
// -----------------------
// Rutas para Authenticacion
// -----------------------

$router->addRoute('POST', '/auth/login', [$userController, 'login']);
$router->addRoute('POST', '/auth/register', [$userController, 'register']);
$router->addRoute('POST', '/auth/logout', [$userController, 'logout']);

// -----------------------
// Rutas para Usuarios
// -----------------------
$router->addRoute('GET', '/users', [$userController, 'getAll']);
$router->addRoute('GET', '/users/:id', [$userController, 'getById']);
$router->addRoute('POST', '/users', [$userController, 'create']);
$router->addRoute('PUT', '/users/:id', [$userController, 'update']);
$router->addRoute('DELETE', '/users/:id', [$userController, 'delete']);


// Ruta de Miembros
$router->addRoute('GET', '/miembros/total/:estado', [$miembroController, 'totalCountMiembro']);
$router->addRoute('GET', '/miembros', [$miembroController, 'listAll']);
$router->addRoute('GET', '/miembros/:id', [$miembroController, 'getById']);
$router->addRoute('PUT', '/miembros/:id', [$miembroController, 'updateById']);
$router->addRoute('DELETE', '/miembros/:id', [$miembroController, 'deleteById']);

// Ruta de Logros
$router->addRoute('GET', '/logros', [$logroController, 'listLogros']);
$router->addRoute('GET', '/logros/total', [$logroController, 'countTotalLogro']);
$router->addRoute('POST', '/logros', [$logroController, 'createLogro']);
$router->addRoute('PUT', '/logros/:id', [$logroController, 'update']);
$router->addRoute('DELETE', '/logros/:id', [$logroController, 'deleteById']);


// Ruta de Contactos
$router->addRoute('GET', '/contacto', [$contactoController, 'listContactos']);
$router->addRoute('GET', '/contacto/:id', [$contactoController, 'getById']);
$router->addRoute('POST', '/contacto', [$contactoController, 'createContacto']);
$router->addRoute('PUT', '/contacto/:id', [$contactoController, 'update']);
$router->addRoute('DELETE', '/contacto/:id', [$contactoController, 'deleteById']);

// Ruta de Personas
$router->addRoute('GET', '/persona', [$personaController, 'listPersonas']);
$router->addRoute('GET', '/persona/:id', [$personaController, 'getById']);
$router->addRoute('POST', '/persona', [$personaController, 'createPersona']);
$router->addRoute('PUT', '/persona/:id', [$personaController, 'update']);
$router->addRoute('DELETE', '/persona/:id', [$personaController, 'deleteById']);

// Ruta de EventoPersonas
$router->addRoute('GET', '/evento/persona', [$eventoPersonaController, 'listEventoPersona']);
$router->addRoute('GET', '/evento/persona/:id', [$eventoPersonaController, 'getById']);
$router->addRoute('POST', '/evento/persona', [$eventoPersonaController, 'createEventoPersona']);
$router->addRoute('DELETE', '/evento/persona/:idPersona/:idEvento', [$eventoPersonaController, 'deleteById']);

// Ruta de Evento
$router->addRoute('GET', '/evento', [$eventoController, 'listEventos']);
$router->addRoute('GET', '/evento/:id', [$eventoController, 'getById']);
$router->addRoute('PUT', '/evento/:id', [$eventoController, 'update']);
$router->addRoute('DELETE', '/evento/:id', [$eventoController, 'deleteById']);

// Ruta de EventoMiembros
$router->addRoute('GET', '/evento/miembro/:id', [$eventoMiembroController, 'getById']);
$router->addRoute('POST', '/evento/miembro', [$eventoMiembroController, 'createEventoMiembro']);
$router->addRoute('PUT', '/evento/miembro/:idMiembro/:idEvento', [$eventoMiembroController, 'update']);
$router->addRoute('DELETE', '/evento/miembro/:idMiembro/:idEvento', [$eventoMiembroController, 'deleteById']);

// Ruta de Noticias
$router->addRoute('GET', '/noticia', [$noticiaController, 'listAll']);
$router->addRoute('GET', '/noticia/total', [$noticiaController, 'countTotalNoticia']);
$router->addRoute('PUT', '/noticia/:id', [$noticiaController, 'update']);
$router->addRoute('DELETE', '/noticia/:id', [$noticiaController, 'deleteById']);

// Ruta de NoticiaPersonas
$router->addRoute('GET', '/noticia/persona/:id', [$noticiaPersonaController, 'getById']);
$router->addRoute('POST', '/noticia/persona', [$noticiaPersonaController, 'createNoticiaPersona']);
$router->addRoute('DELETE', '/noticia/persona/:idPersona/:idNoticia', [$noticiaPersonaController, 'deleteById']);

// Ruta de MiembrosLogros
$router->addRoute('GET', '/miembros/logros/:id', [$miembrosLogrosController, 'getById']);
$router->addRoute('POST', '/miembros/logros', [$miembrosLogrosController, 'createMiembrosLogros']);
$router->addRoute('DELETE', '/miembros/logros/:idLogro/:idMiembro', [$miembrosLogrosController, 'deleteById']);

// -----------------------
// Rutas para Aportación
// -----------------------

$router->addRoute('GET', '/aportaciones', [$aportacionController, 'getAll']);
$router->addRoute('GET', '/aportaciones/:id', [$aportacionController, 'getById']);
$router->addRoute('POST', '/aportaciones', [$aportacionController, 'create']);
$router->addRoute('PUT', '/aportaciones/:id', [$aportacionController, 'update']);
$router->addRoute('DELETE', '/aportaciones/:id', [$aportacionController, 'delete']);

// -----------------------
// Rutas para Asociado
// -----------------------

$router->addRoute('GET', '/asociados', [$asociadoController, 'getAll']);
$router->addRoute('GET', '/asociados/:id', [$asociadoController, 'getById']);
$router->addRoute('POST', '/asociados', [$asociadoController, 'create']);
$router->addRoute('PUT', '/asociados/:id', [$asociadoController, 'update']);
$router->addRoute('DELETE', '/asociados/:id', [$asociadoController, 'delete']);

// -----------------------
// Rutas para Balance 
// -----------------------
// falta Crear Tabla

$router->addRoute('GET', '/balances', [$balanceController, 'getAll']);
$router->addRoute('GET', '/balances/:id', [$balanceController, 'getById']);
$router->addRoute('POST', '/balances', [$balanceController, 'create']);
$router->addRoute('PUT', '/balances/:id', [$balanceController, 'update']);
$router->addRoute('DELETE', '/balances/:id', [$balanceController, 'delete']);


// -----------------------
// Rutas para Tesorero
// -----------------------

$router->addRoute('POST', '/tesorero', [$tesoreroController, 'create']);
$router->addRoute('GET', '/tesorero', [$tesoreroController, 'getAll']);
// -----------------------
// Rutas para Categoria
// -----------------------

$router->addRoute('GET', '/categoria', [$categoriaController, 'getAll']);
$router->addRoute('POST', '/categoria', [$categoriaController, 'create']);
