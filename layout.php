<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'OSCIDEC Viajes') ?></title>
    <meta name="description" content="Busca y compara vuelos al mejor precio con OSCIDEC.">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="grid-bg" aria-hidden="true"></div>

    <header class="site-header">
        <a class="brand" href="/">OSCIDEC<span>·viajes</span></a>
        <nav class="top-nav">
            <a href="/">Buscar</a>
            <a href="https://oscidec.com" target="_blank" rel="noopener">OSCIDEC</a>
        </nav>
    </header>

    <main class="wrap">
        <?= $contenido ?>
    </main>

    <footer class="site-footer">
        <p>© <?= date('Y') ?> OSCIDEC · Precios provistos por Travelpayouts.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/assets/js/app.js"></script>

    <!--
      MONETIZACIÓN OFICIAL:
      Pega aquí el script de "Travelpayouts Drive" que te da tu panel
      (app.travelpayouts.com/dashboard) para tienda.oscidec.com.
      Ese es el script legítimo y aprobado. No pegues scripts de otras
      redes de terceros aquí.
    -->
</body>
</html>
