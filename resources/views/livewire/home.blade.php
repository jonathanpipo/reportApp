<div class="grid h-screen grid-rows-[auto_13rem]">
    <!--CONTAINER ONDE O MAPA SERÁ RENDERIZADO-->
    <div id="map" wire:ignore class="w-full"></div>
    <form wire:submit.prevent="createReporte" class="w-full flex h-auto border border-gray-300 bg-white shadow-md">

    <!--SELECTS-->
    <div class="w-2/3 flex flex-col gap-4 p-4">
        <div class="flex flex-col">
            <label for="categoria" class="text-base font-medium text-gray-700 mb-1">
                Situação crítica
            </label>
            <select id="categoria" wire:model="categoria" 
                class="w-full rounded-lg border border-gray-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Selecione uma opção</option>
                <option value="Asfalto danificad">Asfalto danificado</option>
                <option value="Sinalização deficiente">Sinalização deficiente</option>
                <option value="Direção perigosa">Direção perigosa</option>
                <option value="Congestionamento recorrente">Congestionamento recorrente</option>
                <option value="Drenagem de água">Drenagem de água</option>
            </select>
            @error('categoria') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="avaliacaoInfraestrutura" class="text-base font-medium text-gray-700 mb-1">
                Infraestrutura das vias
            </label>
            <select id="subcategoria" wire:model="avaliacaoInfraestrutura" 
                class="w-full rounded-lg border border-gray-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Selecione uma opção</option>
                <option value="tipo1">Muito ruim</option>
                <option value="tipo2">Ruim</option>
                <option value="tipo3">Regular</option>
                <option value="tipo4">Bom</option>
                <option value="tipo5">Muito bom</option>
            </select>
            @error('subcategoria') 
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
            @enderror
        </div>
    </div>

    <!--BOTÃO-->
<div class="w-1/3 flex items-center justify-center p-4 bg-gray-50 rounded-r-2xl">
    <button type="submit"
        class="w-full h-full py-3 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 
               text-white text-lg font-bold rounded-lg shadow-md 
               hover:from-blue-600 hover:to-blue-800 
               focus:outline-none focus:ring-2 focus:ring-blue-400 
               transition-all duration-200
               drop-shadow-md">
        Reportar
    </button>
</div>
</form>

</div>


<script>
const map = L.map('map', {
    attributionControl: false // remove o "Leaflet" e OSM
}).setView([-22.891, -48.445], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '' // remove atribuição
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




