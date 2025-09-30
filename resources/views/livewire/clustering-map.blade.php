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

//====== INFRAESTRUTURA ==========
const reportesInfraestrutura = @json($clusterReportesInfraestrutura);
const markersInfraestrutura = L.markerClusterGroup();

reportesInfraestrutura.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersInfraestrutura.addLayer(marker);
    }
});

//====== SITUAÇÃO ==========
const reportesSituacao = @json($clusterReportesSituacao);
const markersSituacao = L.markerClusterGroup();

reportesSituacao.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersSituacao.addLayer(marker);
    }
});

//====== SINALIZAÇÃO ==========
const reportesSinalizacao = @json($clusterReportesSinalizacao);
const markersSinalizacao = L.markerClusterGroup();

reportesSinalizacao.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersSinalizacao.addLayer(marker);
    }
});

// === adicionando controle de camadas ===
const overlays = {
    "Infraestrutura": markersInfraestrutura,
    "Situação": markersSituacao,
    "Sinalização": markersSinalizacao
};

L.control.layers(null, overlays, { collapsed: false }).addTo(map);
</script>
