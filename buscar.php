<?php
declare(strict_types=1);

/**
 * Endpoint seguro. El navegador (jQuery) llama aquí; este archivo habla con
 * Travelpayouts usando el token del servidor y devuelve solo JSON limpio.
 */

require __DIR__ . '/../../src/Config.php';
require __DIR__ . '/../../src/TravelpayoutsClient.php';

header('Content-Type: application/json; charset=utf-8');

$destino = strtoupper(trim($_GET['destino'] ?? ''));

// Validación: solo códigos IATA de 3 letras.
if (!preg_match('/^[A-Z]{3}$/', $destino)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Destino inválido. Usa un código IATA de 3 letras (ej. MIA).']);
    exit;
}

if (Config::token() === '') {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Falta configurar TRAVELPAYOUTS_TOKEN en el servidor.']);
    exit;
}

try {
    $cliente = new TravelpayoutsClient();
    $vuelos  = $cliente->vuelosBaratos(Config::origen(), $destino, Config::moneda());

    echo json_encode([
        'ok'      => true,
        'origen'  => Config::origen(),
        'destino' => $destino,
        'moneda'  => strtoupper(Config::moneda()),
        'total'   => count($vuelos),
        'vuelos'  => $vuelos,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok'    => false,
        'error' => Config::debug() ? $e->getMessage() : 'Error consultando los vuelos.',
    ]);
}
