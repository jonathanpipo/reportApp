<!-- resources/views/marker-form.blade.php -->
<div class="max-w-md mx-auto p-4">
    <h1 class="text-xl font-bold text-center mb-4">Adicionar Marcador</h1>

    <!-- Espaço reservado para o mapa -->
    <div id="map" wire:ignore class="w-full h-64 rounded-md border mb-4">
        <!-- O mapa Leaflet será renderizado aqui -->
    </div>

    <!-- Formulário Livewire -->
    <form wire:submit.prevent="createReporte" class="flex flex-col gap-4">

        <!-- Select 1 -->
        <div>
            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                Categoria
            </label>
            <select id="categoria" wire:model="categoria"
                class="w-full border rounded-md p-2 text-sm">
                <option value="">Selecione...</option>
                <option value="Infraestrutura">Infraestrutura</option>
                <option value="Sinalização">Sinalização</option>
                <option value="Situação">Situação</option>
            </select>
            @error('categoria') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Select 2 -->
        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                Tipo
            </label>
            <select id="tipo" wire:model="subcategoria"
                class="w-full border rounded-md p-2 text-sm">
                <option value="">Selecione...</option>
                <option value="tipo1">Alta</option>
                <option value="tipo2">Média</option>
                <option value="tipo3">Baixa</option>
            </select>
            @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Botão Submit -->
        <button type="submit"
            class="bg-blue-600 text-white rounded-md py-2 hover:bg-blue-700 transition">
            Salvar
        </button>
    </form>
</div>


<script>
    const map = L.map('map').setView([-22.891, -48.445], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const bounds = L.latLngBounds(
        [-22.95, -48.52],
        [-22.82, -48.36]
    );

    map.setMaxBounds(bounds);
    map.options.maxBoundsViscosity = 1.0;

    let currentMarker = null;

    // Geocoder
    const geocoder = L.Control.geocoder({
        defaultMarkGeocode: false,
        geocoder: L.Control.Geocoder.nominatim({
            geocodingQueryParams: {
                countrycodes: 'br',
                viewbox: "-48.52,-22.95,-48.36,-22.82",
                bounded: 1
            }
        })
    })
    .on('markgeocode', function(e) {
        if (currentMarker) map.removeLayer(currentMarker);

        currentMarker = L.marker(e.geocode.center).addTo(map)
            .bindPopup(e.geocode.name)
            .openPopup();

        map.setView(e.geocode.center, 15);

        @this.set('latitude', e.geocode.center.lat);
        @this.set('longitude', e.geocode.center.lng);
    })
    .addTo(map);

    // Clique no mapa adiciona marcador
    map.on("click", function(e) {
        if (currentMarker) map.removeLayer(currentMarker);

        currentMarker = L.marker(e.latlng).addTo(map);

        @this.set('latitude', e.latlng.lat);
        @this.set('longitude', e.latlng.lng);
    });

    // Botão nativo de "minha localização"
    const locateControl = L.control({position: 'topleft'});
    locateControl.onAdd = function(map) {
        const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');

        const button = L.DomUtil.create('a', '', container);
        button.innerHTML = '📍';
        button.href = '#';
        button.title = "Minha localização";

        L.DomEvent.on(button, 'click', function(e) {
            L.DomEvent.stopPropagation(e);
            L.DomEvent.preventDefault(e);

            map.locate({setView: true, maxZoom: 16});
        });

        return container;
    };
    locateControl.addTo(map);

    // Quando localização encontrada
    map.on('locationfound', function(e) {
        if (currentMarker) map.removeLayer(currentMarker);

        currentMarker = L.marker(e.latlng).addTo(map)
            .bindPopup("Você está aqui!")
            .openPopup();

        @this.set('latitude', e.latlng.lat);
        @this.set('longitude', e.latlng.lng);
    });

    // Se não conseguir localizar
    map.on('locationerror', function(e) {
        alert("Não foi possível obter sua localização.");
    });
</script>




