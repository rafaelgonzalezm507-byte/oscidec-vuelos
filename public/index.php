<?php
declare(strict_types=1);

require __DIR__ . '/../src/Config.php';
require __DIR__ . '/../src/Logger.php';

if (Config::debug()) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

Logger::registrarVisita();

// Render: capturamos el contenido de la página y lo inyectamos en el layout.
$titulo = 'OSCIDEC · Vuelos al mejor precio';

ob_start();
require __DIR__ . '/../templates/home.php';
$contenido = ob_get_clean();

require __DIR__ . '/../templates/layout.php';
