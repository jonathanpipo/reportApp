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

//====== Asfalto danificado ==========
const reportesAsfaltoDanificado = @json($clusterReportesAsfaltoDanificado);
const markersAsfaltoDanificado = L.markerClusterGroup();

reportesAsfaltoDanificado.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersAsfaltoDanificado.addLayer(marker);
    }
});

//====== Sinalização deficiente ==========
const reportesSinalizacaoDeficiente = @json($clusterReportesSinalizacaoDeficiente);
const markersSinalizacaoDeficiente = L.markerClusterGroup();

reportesSinalizacaoDeficiente.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersSinalizacaoDeficiente.addLayer(marker);
    }
});

//====== Direção perigosa ==========
const reportesDirecaoPerigosa = @json($clusterReportesDirecaoPerigosa);
const markersDirecaoPerigosa = L.markerClusterGroup();

reportesDirecaoPerigosa.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersDirecaoPerigosa.addLayer(marker);
    }
});

//====== Congestionamento recorrente ==========
const reportesCongestionamentoRecorrente = @json($clusterReporteCongestionamentoRecorrente);
const markersCongestionamentoRecorrente = L.markerClusterGroup();

reportesCongestionamentoRecorrente.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersCongestionamentoRecorrente.addLayer(marker);
    }
});

//====== Drenagem de água ==========
const reportesDrenagemAgua = @json($clusterReportesDrenagemAgua);
const markersDrenagemAgua = L.markerClusterGroup();

reportesDrenagemAgua.forEach(r => {
    if (r.latitude && r.longitude) {
        const marker = L.marker([r.latitude, r.longitude])
            .bindPopup(`<b>Categoria:</b> ${r.categoria}`);
        markersDrenagemAgua.addLayer(marker);
    }
});

// === adicionando controle de camadas ===
const overlays = {
    "Asfalto danificado": markersAsfaltoDanificado,
    "Sinalização deficiente": markersSinalizacaoDeficiente,
    "Direção perigosa": markersDirecaoPerigosa,
    "Congestionamento recorrente": markersCongestionamentoRecorrente,
    "Drenagem de água": markersDrenagemAgua
};

L.control.layers(null, overlays, { collapsed: false }).addTo(map);
</script>
