<section class="hero">
    <p class="eyebrow">Desde <?= htmlspecialchars(Config::origen()) ?> · en tiempo real</p>
    <h1>Encuentra tu próximo vuelo<br><span class="neon">al mejor precio</span></h1>
    <p class="lead">Comparamos tarifas hacia los principales destinos del mundo. Elige uno o escribe el código IATA de tu ciudad.</p>

    <form id="form-busqueda" class="buscador" autocomplete="off">
        <div class="campo">
            <label for="destino">Destino</label>
            <input type="text" id="destino" name="destino" maxlength="3"
                   placeholder="Ej. MIA" pattern="[A-Za-z]{3}" required>
        </div>
        <button type="submit" class="btn-buscar" id="btn-buscar">
            <span class="btn-txt">Buscar vuelos</span>
            <span class="btn-load" hidden>Buscando…</span>
        </button>
    </form>

    <div class="chips">
        <span class="chips-label">Populares:</span>
        <button class="chip" data-iata="MIA">Miami</button>
        <button class="chip" data-iata="MAD">Madrid</button>
        <button class="chip" data-iata="BOG">Bogotá</button>
        <button class="chip" data-iata="MEX">México</button>
        <button class="chip" data-iata="JFK">Nueva York</button>
        <button class="chip" data-iata="FCO">Roma</button>
    </div>
</section>

<section class="resultados" id="resultados" aria-live="polite"></section>
