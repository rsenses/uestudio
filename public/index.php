<?php

date_default_timezone_set('Europe/Madrid');

// Errores en archivo log o en pantalla si estamos en desarrollo
error_reporting(-1);
// Errores en archivo log o en pantalla si estamos en desarrollo
ini_set('ignore_repeated_source', 0);
ini_set('ignore_repeated_errors', 1); // do not log repeating errors
// source of error plays role in determining if errors are different
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../storage/logs/'.date('Y-m-d').'_error.log');

require __DIR__.'/../vendor/autoload.php';

if ($GLOBALS['env']['debug']) {
    ini_set('display_errors', 1); // Mostramos los errores en pantalla
    ini_set('display_startup_errors', 1);
    Flight::set('flight.handle_errors', false);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    Flight::map('notFound', function () {
        $error = new Controllers\NotFoundController();
        $error->indexAction();
        die;
    });
    Flight::map('error', function () {
        $error = new Controllers\NotFoundController();
        $error->indexAction();
        die;
    });
}

$handler = new Expomark\Models\SessionHandler();

$handler->setDbDetails($GLOBALS['env']['db']['host'], $GLOBALS['env']['db']['port'], $GLOBALS['env']['db']['user'], $GLOBALS['env']['db']['pass'], $GLOBALS['env']['db']['database']);
$handler->setDbTable('session');

// Session start
ini_set('session.use_strict_mode', true);
ini_set('session.cache_limiter', 'private');
ini_set('session.gc_maxlifetime', 14400);
session_name($GLOBALS['config']['info']['session_name']);
session_set_save_handler($handler, true);
session_start();

// Language Initial Settings
$locale = array_keys($GLOBALS['config']['locales'])[0];
Flight::set('locale', $locale);
setlocale(LC_TIME, $GLOBALS['config']['locales'][$locale]);
setlocale(LC_ALL, $GLOBALS['config']['locales'][$locale]);

Flight::register('db', 'Expomark\Models\Db', [
    $GLOBALS['env']['db']['driver'],
    $GLOBALS['env']['db']['host'],
    $GLOBALS['env']['db']['port'],
    $GLOBALS['env']['db']['database'],
    $GLOBALS['env']['db']['user'],
    $GLOBALS['env']['db']['pass'],
    true,
]);

Flight::register('eloquent', 'Expomark\Models\Eloquent', [
    $GLOBALS['env']['db']['driver'],
    $GLOBALS['env']['db']['host'],
    $GLOBALS['env']['db']['database'],
    $GLOBALS['env']['db']['user'],
    $GLOBALS['env']['db']['pass'],
]);

$loader = new Symfony\Component\Templating\Loader\FilesystemLoader(__DIR__.'/../src/views/%name%');

Flight::register('view', 'Symfony\Component\Templating\PhpEngine', array(new Symfony\Component\Templating\TemplateNameParser(), $loader), function ($templating) {
});

Flight::view()->set(new Symfony\Component\Templating\Helper\SlotsHelper());

Flight::view()->setEscaper('path', function ($value) {
    return htmlspecialchars($value, ENT_QUOTES);
});

Flight::view()->setEscaper('url', function ($value) {
    return urlencode($value);
});

Flight::view()->addGlobal('data', Joelvardy\Flash::data());
Flight::view()->addGlobal('errors', isset($_SESSION['validationErrors']) ? $_SESSION['validationErrors'] : null);
unset($_SESSION['validationErrors']);

Respect\Validation\Validator::with('Expomark\\Validation\\Rules\\');

Flight::start();
