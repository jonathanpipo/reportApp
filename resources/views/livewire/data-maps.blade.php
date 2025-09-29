<div>
    <h1>HeatMap</h1>
    <div id="heatMap" class="w-full h-64 rounded-md border mb-4">
        <!-- O mapa Leaflet será renderizado aqui -->
    </div>
    <h1>Clustermap</h1>
<div>
    {{-- Botões para filtrar categorias --}}
    <div class="mb-2">
        <button wire:click="selecionarCategoria(null)" class="btn btn-sm btn-primary">Todas</button>
        @foreach($categorias as $cat)
            <button wire:click="selecionarCategoria('{{ $cat }}')" class="btn btn-sm btn-secondary">{{ $cat }}</button>
        @endforeach
    </div>
    <div id="clusterMap" class="w-full h-64 rounded-md border mb-4">
        <!-- O mapa Leaflet será renderizado aqui -->
    </div>
</div>

<script>
//HEATMAP
    const heatMap = L.map('heatMap').setView([-22.891, -48.445], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(heatMap);

    const bounds = L.latLngBounds(
        [-22.95, -48.52], 
        [-22.82, -48.36]
    );

    heatMap.setMaxBounds(bounds);
    heatMap.options.maxBoundsViscosity = 1.0;

    // Dados do PHP para JS
    var heatReportes = @json($heatReportes);

    // Transformar em array para heatmap [[lat, lng, intensidade], ...]
    var heatData = heatReportes.map(function(m) {
        return [parseFloat(m.latitude), parseFloat(m.longitude), 10]; // intensidade 1
    });

    // Criar camada de heatmap
    L.heatLayer(heatData, { radius: 25 }).addTo(heatMap);

//CLUSTERMAP
        const map = L.map('clusterMap').setView([-22.93, -48.44], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let markerClusters = L.markerClusterGroup();

            // Função para renderizar os pontos
            function renderMarkers(reportes) {
                markerClusters.clearLayers(); // limpa marcadores antigos

                reportes.forEach(ponto => {
                    const marker = L.marker([ponto.latitude, ponto.longitude]);
                    marker.bindPopup("Categoria: " + ponto.categoria);
                    markerClusters.addLayer(marker);
                });

                map.addLayer(markerClusters);
            }

            // Renderiza inicialmente
            renderMarkers(@json($reportesFiltrados));

            // Atualiza markers quando Livewire envia dados
            Livewire.hook('message.processed', (message, component) => {
                renderMarkers(@this.reportesFiltrados);
            });

</script>