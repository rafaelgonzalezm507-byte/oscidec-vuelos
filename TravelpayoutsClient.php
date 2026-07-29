<?php
declare(strict_types=1);

/**
 * Cliente de la Data API de Travelpayouts (precios cacheados).
 * Se ejecuta SOLO en el servidor: el token nunca llega al navegador.
 * Docs: https://support.travelpayouts.com/hc/en-us/articles/203956163
 */
final class TravelpayoutsClient
{
    private const BASE = 'https://api.travelpayouts.com';

    /**
     * Devuelve los vuelos más baratos desde un origen hacia un destino.
     * Endpoint: /v1/prices/cheap
     *
     * @return array<int, array<string, mixed>> Lista de vuelos normalizados.
     */
    public function vuelosBaratos(string $origen, string $destino, string $moneda): array
    {
        $origen  = strtoupper(trim($origen));
        $destino = strtoupper(trim($destino));

        $url = self::BASE . '/v1/prices/cheap?' . http_build_query([
            'origin'      => $origen,
            'destination' => $destino,
            'currency'    => $moneda,
        ]);

        $respuesta = $this->get($url);
        if ($respuesta === null || empty($respuesta['success'])) {
            return [];
        }

        $bloque = $respuesta['data'][$destino] ?? [];
        $vuelos = [];

        foreach ($bloque as $item) {
            if (!isset($item['price'])) {
                continue;
            }
            $vuelos[] = [
                'precio'        => (float) $item['price'],
                'aerolinea'     => $item['airline'] ?? '',
                'vuelo'         => $item['flight_number'] ?? '',
                'escalas'       => (int) ($item['transfers'] ?? 0),
                'salida'        => $item['departure_at'] ?? '',
                'regreso'       => $item['return_at'] ?? '',
                'expira'        => $item['expires_at'] ?? '',
                'link_afiliado' => $this->linkAfiliado($origen, $destino, $item),
            ];
        }

        usort($vuelos, fn($a, $b) => $a['precio'] <=> $b['precio']);
        return $vuelos;
    }

    /**
     * Construye el enlace de reserva con tu marker de afiliado.
     * Formato Aviasales: /search/{ORIGEN}{DDMM}{DESTINO}{DDMM}1
     */
    private function linkAfiliado(string $origen, string $destino, array $item): string
    {
        $marker = Config::marker();
        $ida    = $this->ddmm($item['departure_at'] ?? '');
        $vuelta = $this->ddmm($item['return_at'] ?? '');

        if ($ida !== '') {
            $ruta = $origen . $ida . $destino . $vuelta . '1';
            $base = 'https://www.aviasales.com/search/' . $ruta;
        } else {
            $base = 'https://www.aviasales.com/search';
        }

        return $marker !== '' ? $base . '?marker=' . rawurlencode($marker) : $base;
    }

    /** Convierte una fecha ISO (2026-07-15...) al formato DDMM que usa Aviasales. */
    private function ddmm(string $iso): string
    {
        if ($iso === '') {
            return '';
        }
        $ts = strtotime($iso);
        return $ts ? date('dm', $ts) : '';
    }

    /** GET con token en el header X-Access-Token. Devuelve el JSON decodificado o null. */
    private function get(string $url): ?array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 12,
            CURLOPT_HTTPHEADER     => [
                'X-Access-Token: ' . Config::token(),
                'Accept: application/json',
            ],
        ]);

        $cuerpo = curl_exec($ch);
        $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($cuerpo === false || $codigo >= 400) {
            return null;
        }

        $json = json_decode((string) $cuerpo, true);
        return is_array($json) ? $json : null;
    }
}
