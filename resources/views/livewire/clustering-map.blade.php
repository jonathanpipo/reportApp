<div>
    <h1>Clustermap</h1>
    <div>
        <div id="clusterMap" wire:ignore class="w-full h-64 rounded-md border mb-4">
            <!-- O mapa Leaflet será renderizado aqui -->
        </div>
    </div>
</div>

<script>
 // ===== CLUSTERMAP =====

const map = L.map('clusterMap').setView([-22.93, -48.44], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

const bounds = L.latLngBounds(
    [-22.95, -48.52], 
    [-22.82, -48.36]
);

map.setMaxBounds(bounds);
map.options.maxBoundsViscosity = 1.0;

//======INFRAESTRUTURA==========
// pega os dados do Livewire (injetados no Blade)
const reportesInfraestrutura = @json($clusterReportesInfraestrutura);

// cria o grupo de clusters
const markersInfraestrutura = L.markerClusterGroup();

reportesInfraestrutura.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersInfraestrutura.addLayer(marker);
    }
});

// adiciona os clusters ao mapa
//markersInfraestrutura.addTo(map);

//======SITUAÇÃO==========
// pega os dados do Livewire (injetados no Blade)
const reportesSituacao = @json($clusterReportesSituacao);

// cria o grupo de clusters
const markersSituacao = L.markerClusterGroup();

reportesSituacao.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersSituacao.addLayer(marker);
    }
});

// adiciona os clusters ao mapa
//markersSituacao.addTo(map);

//======SINALIZAÇÃO==========
// pega os dados do Livewire (injetados no Blade)
const reportesSinalizacao = @json($clusterReportesSinalizacao);

// cria o grupo de clusters
const markersSinalizacao = L.markerClusterGroup();

reportesSinalizacao.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersSinalizacao.addLayer(marker);
    }
});

// adiciona os clusters ao mapa
//markersSinalizacao.addTo(map);
</script>
