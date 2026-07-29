# OSCIDEC · Viajes

Buscador de vuelos afiliado a Travelpayouts. PHP + jQuery, contenedorizado para Coolify/Traefik.

El token de Travelpayouts vive **solo en el servidor**. El navegador nunca lo ve:
llama a `/api/buscar.php`, y ese archivo consulta la API y devuelve JSON limpio.

## Estructura

```
oscidec-vuelos/
├── Dockerfile              → imagen PHP 8.3 + Apache (docroot = public/)
├── .env.example           → variables a copiar en Coolify
├── public/                → única carpeta expuesta a internet
│   ├── index.php          → página principal
│   ├── api/buscar.php     → endpoint seguro (token del servidor)
│   └── assets/            → css (cyberpunk) + js (jQuery)
├── src/                   → lógica privada (nunca accesible por URL)
│   ├── Config.php         → lee variables de entorno
│   ├── TravelpayoutsClient.php
│   └── Logger.php         → analítica de visitas anonimizada
├── templates/             → layout + home
└── logs/                  → registro de visitas (ignorado por git)
```

## Requisitos previos

- Cuenta de Travelpayouts con tu **token** y tu **marker** (panel: app.travelpayouts.com).

## Desplegar en Coolify (paso a paso)

1. Sube este proyecto a un repositorio Git (GitHub/GitLab).
2. En Coolify: **New Resource → Application → Dockerfile**, apuntando a tu repo.
3. En la pestaña **Environment Variables**, pega las de `.env.example` con tus valores reales.
4. En **Domains**, pon `https://tienda.oscidec.com` (Coolify + Traefik resuelven el HTTPS).
5. **Deploy**.

## Probar en local (opcional)

```
docker build -t oscidec-vuelos .
docker run --rm -p 8080:80 \
  -e TRAVELPAYOUTS_TOKEN=tu_token \
  -e TRAVELPAYOUTS_MARKER=tu_marker \
  -e APP_DEBUG=true \
  oscidec-vuelos
```

Abre http://localhost:8080

## Monetización

En `templates/layout.php` hay un espacio marcado para pegar el script oficial de
**Travelpayouts Drive** que te da tu panel. Ese es el único script de terceros
que debe ir ahí.
