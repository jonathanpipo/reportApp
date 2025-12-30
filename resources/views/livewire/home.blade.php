<div class="grid h-min-screen grid-rows-[auto_auto]">
    <!-- MAPA -->
    <div id="map" wire:ignore class="w-full h-[60vh]"></div>

    <!-- FORMULÁRIO -->
    <form wire:submit.prevent="createReporte" class="w-full flex flex-col border border-gray-300 bg-white shadow-md">

        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">
                Preencha as informações para registrar sua denúncia
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Informe sua avaliação geral sobre a qualidade da infraestrutura das ruas da cidade, descreva a situação no local selecionado no mapa acima e se necessário digite um comentário.
            </p>
        </div>

        <!-- CAMPOS -->
        <div class="flex flex-col gap-4 p-4">

            <!-- AVALIAÇÃO -->
            <div class="flex flex-col">
                <label for="avaliacao" class="text-base font-medium text-gray-700 mb-1">
                    Avaliação geral das vias da cidade
                </label>
                <select id="avaliacao" wire:model="avaliacao" required
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm 
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="" disabled>Selecione uma opção</option>
                    <option value="Muito ruim">Muito ruim</option>
                    <option value="Ruim">Ruim</option>
                    <option value="Regular">Regular</option>
                    <option value="Bom">Bom</option>
                    <option value="Muito bom">Muito bom</option>
                </select>
                @error('avaliacao')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- OCORRÊNCIA -->
            <div class="flex flex-col">
                <label for="categoria" class="text-base font-medium text-gray-700 mb-1">
                    Ocorrência do local selecionado
                </label>
                <select id="categoria" wire:model="categoria_id" required
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm">
                    <option value="" disabled>Selecione uma opção</option>

                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">
                            {{ $cat->descricao }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- COMENTÁRIO -->
            <div class="flex flex-col">
                <label for="comentario" class="text-base font-medium text-gray-700 mb-1">
                    Comentário breve sobre o local selecionado
                </label>
                <textarea id="comentario" wire:model="comentario" maxlength="200"
                    placeholder="Descreva brevemente o problema..."
                    class="w-full rounded-lg border border-gray-300 p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"></textarea>
                <div class="text-right text-xs text-gray-500 mt-1">
                    Máximo de 200 caracteres
                </div>
                @error('comentario')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- BOTÃO -->
        <div class="p-4 border-b border-gray-200 bg-gray-50 rounded-b-2xl">
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 
                       text-white text-lg font-bold rounded-lg shadow-md 
                       hover:from-blue-600 hover:to-blue-800 
                       focus:outline-none focus:ring-2 focus:ring-blue-400 
                       transition-all duration-200 drop-shadow-md">
                Enviar denúncia
            </button>
        </div>
            @if (session('success'))
            <div 
                id="alert-sucesso"
                class="w-full bg-green-600 text-white text-center py-3 font-semibold shadow-md animate-fade"
            >
                {{ session('success') }}
            </div>
            @endif
    </form>
</div>

<script>
const map = L.map('map', { 
    attributionControl: false,
    minZoom: 12,  // Zoom mínimo
    maxZoom: 18   // Zoom máximo
}).setView([-22.891, -48.445], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(map);

//Limites do mapa
const bounds = L.latLngBounds(
    [-23.00, -48.52],
    [-22.82, -48.36]
);
map.setMaxBounds(bounds);
map.options.maxBoundsViscosity = 1.0;

//Marcador atual
let currentMarker = null;

//Função para add/att marcador
function setMarker(latlng, popupText = null) {
    if (currentMarker) map.removeLayer(currentMarker);

    currentMarker = L.marker(latlng).addTo(map);
    if (popupText) currentMarker.bindPopup(popupText).openPopup();

    @this.set('latitude', latlng.lat);
    @this.set('longitude', latlng.lng);
}

//Geocoder
L.Control.geocoder({
    defaultMarkGeocode: false,
    geocoder: L.Control.Geocoder.nominatim({
        geocodingQueryParams: {
            countrycodes: 'br',
            viewbox: "-48.52,-22.95,-48.36,-22.82",
            bounded: 1
        }
    })
}).on('markgeocode', function(e) {
    setMarker(e.geocode.center, e.geocode.name);
    map.setView(e.geocode.center, 15);
}).addTo(map);

//Interação com o mapa
map.on("click", function(e) {
    setMarker(e.latlng);
});

//Controle de localização
const locateControl = L.control({ position: 'topleft' });
locateControl.onAdd = function() {
    const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
    const button = L.DomUtil.create('a', '', container);
    button.innerHTML = '📍';
    button.href = '#';
    button.title = "Minha localização";

    L.DomEvent.on(button, 'click', function(e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
        map.locate({ setView: true, maxZoom: 16 });
    });

    return container;
};
locateControl.addTo(map);

map.on('locationfound', e => setMarker(e.latlng, "Você está aqui!"));
map.on('locationerror', () => alert("Não foi possível obter sua localização."));


</script>