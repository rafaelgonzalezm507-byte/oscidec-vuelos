<?php
declare(strict_types=1);

/**
 * Configuración central. TODO se lee de variables de entorno.
 * En Coolify: recurso -> pestaña "Environment Variables".
 * Nunca escribas claves aquí ni en ningún archivo del repositorio.
 */
final class Config
{
    public static function token(): string
    {
        return getenv('TRAVELPAYOUTS_TOKEN') ?: '';
    }

    public static function marker(): string
    {
        // Tu ID de afiliado. Sin esto no ganas comisiones.
        return getenv('TRAVELPAYOUTS_MARKER') ?: '';
    }

    /** Ciudad de origen por defecto (código IATA). PTY = Panamá. */
    public static function origen(): string
    {
        return getenv('ORIGEN_DEFECTO') ?: 'PTY';
    }

    public static function moneda(): string
    {
        return getenv('MONEDA') ?: 'usd';
    }

    /** true en local, false en producción. Controla si se muestran errores. */
    public static function debug(): bool
    {
        return filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOL);
    }
}
