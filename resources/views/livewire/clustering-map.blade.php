<div class="bg-gradient-to-b from-gray-100 to-gray-200 shadow-inner flex flex-col h-screen">
    <div class="container mx-auto flex items-center justify-between py-4 px-4 ">
        <h1 class="text-2xl font-semibold text-gray-800">Mapa de Agrupamento</h1>
            <button 
                @click="open = true" 
                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold focus:outline-none"
                title="O que é um mapa de calor?"
            >?
            </button>
    </div>

        <!-- Mapa de Cluster -->
        <div id="clusterMap" wire:ignore class="flex-1 rounded-lg border border-gray-300 shadow-sm bg-white"></div>
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
