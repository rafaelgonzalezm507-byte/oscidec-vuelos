<?php
declare(strict_types=1);

/**
 * Analítica de visitas del lado del servidor (versión limpia de tu script anterior).
 *
 * AVISO LEGAL: registrar IPs es un dato personal. Como estás formalizando OSCIDEC,
 * publica un aviso de privacidad y consentimiento de cookies antes de usarlo en
 * producción. Si no quieres guardar IPs, deja ANONIMIZAR en true (recomendado):
 * guarda solo una versión recortada de la IP, suficiente para métricas.
 */
final class Logger
{
    private const ANONIMIZAR = true;
    private const ARCHIVO    = __DIR__ . '/../logs/accesos.log';

    public static function registrarVisita(): void
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $ip = trim(explode(',', $ip)[0]);

        if (self::ANONIMIZAR) {
            $ip = self::recortarIp($ip);
        }

        $agente = substr($_SERVER['HTTP_USER_AGENT'] ?? 'desconocido', 0, 200);
        $ruta   = $_SERVER['REQUEST_URI'] ?? '/';
        $linea  = sprintf("[%s] %s | %s | %s%s", date('Y-m-d H:i:s'), $ip, $ruta, $agente, PHP_EOL);

        @file_put_contents(self::ARCHIVO, $linea, FILE_APPEND | LOCK_EX);
    }

    /** Recorta el último octeto (IPv4) o los últimos bloques (IPv6) para anonimizar. */
    private static function recortarIp(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $p = explode('.', $ip);
            return "{$p[0]}.{$p[1]}.{$p[2]}.0";
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $p = explode(':', $ip);
            return implode(':', array_slice($p, 0, 3)) . '::';
        }
        return '0.0.0.0';
    }
}
