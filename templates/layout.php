<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'OSCIDEC Viajes') ?></title>
    <meta name="description" content="Busca y compara vuelos al mejor precio con OSCIDEC.">
    <link rel="stylesheet" href="/assets/css/styles.css">

    <!-- Travelpayouts Drive (monetizacion oficial - marker 757594) -->
    <script nowprocket data-noptimize="1" data-cfasync="false" data-wpfc-render="false" seraph-accel-crit="1" data-no-defer="1" data-cmp-ab="2">
    (function () {
        var script = document.createElement("script");
        script.async = 1;
        script.setAttribute("data-cmp-ab", "2");
        script.src = 'https://emrld.ltd/NTU2MTI4.js?t=556128';
        document.head.appendChild(script);
    })();
    </script>
</head>
<body>
    <!-- Fondo inmersivo: vista desde la ventana del avion con nubes en parallax -->
    <div class="sky" aria-hidden="true">
        <div class="sky-gradient"></div>
        <div class="clouds clouds--back"></div>
        <div class="clouds clouds--mid"></div>
        <div class="clouds clouds--front"></div>
    </div>

    <div class="window-frame" aria-hidden="true">
        <div class="window-glare"></div>
    </div>

    <header class="site-header">
        <a class="brand" href="/">OSCIDEC<span>&middot;viajes</span></a>
        <nav class="top-nav">
            <a href="/">Buscar</a>
            <a href="https://oscidec.com" target="_blank" rel="noopener">OSCIDEC</a>
        </nav>
    </header>

    <main class="wrap">
        <?= $contenido ?>
    </main>

    <footer class="site-footer">
        <p>&copy; <?= date('Y') ?> OSCIDEC &middot; Precios provistos por Travelpayouts.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
