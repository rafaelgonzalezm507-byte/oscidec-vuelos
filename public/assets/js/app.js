/* global jQuery */
(function ($) {
    'use strict';

    var $form = $('#form-busqueda');
    var $input = $('#destino');
    var $btn = $('#btn-buscar');
    var $resultados = $('#resultados');

    function setCargando(cargando) {
        $btn.prop('disabled', cargando);
        $btn.find('.btn-txt').prop('hidden', cargando);
        $btn.find('.btn-load').prop('hidden', !cargando);
    }

    function estado(texto, esError) {
        $resultados.html(
            $('<div>').addClass('estado' + (esError ? ' error' : '')).text(texto)
        );
    }

    function fmtFecha(iso) {
        if (!iso) { return ''; }
        var d = new Date(iso);
        if (isNaN(d)) { return ''; }
        return d.toLocaleDateString('es-PA', { day: '2-digit', month: 'short' });
    }

    function tarjeta(v, moneda, destino) {
        var escalas = v.escalas === 0 ? 'Directo' : v.escalas + ' escala(s)';
        var fechas = v.salida ? (fmtFecha(v.salida) + (v.regreso ? ' → ' + fmtFecha(v.regreso) : '')) : 'Fechas flexibles';

        return $(
            '<article class="card">' +
                '<div class="info">' +
                    '<h3>PTY → ' + destino + '</h3>' +
                    '<p>' + escalas + ' · ' + fechas + (v.aerolinea ? ' · ' + v.aerolinea : '') + '</p>' +
                '</div>' +
                '<div class="precio">' +
                    '<span class="desde">Desde</span>' +
                    '<span class="monto">$' + Math.round(v.precio).toLocaleString('es-PA') + '</span>' +
                    '<span class="desde">' + moneda + '</span>' +
                '</div>' +
                '<a class="cta" target="_blank" rel="noopener nofollow" href="' + v.link_afiliado + '">Ver oferta</a>' +
            '</article>'
        );
    }

    function buscar(destino) {
        destino = (destino || '').toUpperCase().trim();
        if (!/^[A-Z]{3}$/.test(destino)) {
            estado('Escribe un código IATA válido de 3 letras (ej. MIA).', true);
            return;
        }

        setCargando(true);
        estado('Consultando las mejores tarifas hacia ' + destino + '…', false);

        $.getJSON('/api/buscar.php', { destino: destino })
            .done(function (data) {
                if (!data.ok) {
                    estado(data.error || 'No se pudo completar la búsqueda.', true);
                    return;
                }
                if (!data.total) {
                    estado('Sin tarifas en caché para ' + destino + ' ahora mismo. Prueba otro destino.', false);
                    return;
                }
                $resultados.empty();
                data.vuelos.forEach(function (v) {
                    $resultados.append(tarjeta(v, data.moneda, data.destino));
                });
            })
            .fail(function () {
                estado('Error de conexión con el servidor. Intenta de nuevo.', true);
            })
            .always(function () {
                setCargando(false);
            });
    }

    $form.on('submit', function (e) {
        e.preventDefault();
        buscar($input.val());
    });

    $('.chip').on('click', function () {
        var iata = $(this).data('iata');
        $input.val(iata);
        buscar(iata);
    });
})(jQuery);
