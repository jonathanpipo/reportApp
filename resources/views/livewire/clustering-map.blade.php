<div class="bg-gradient-to-b from-gray-100 to-gray-200 shadow-inner flex flex-col h-screen">
    <div class="container mx-auto flex-col items-center justify-between py-4 px-4 ">
        <h1 class="text-2xl font-semibold text-gray-700">Mapa de Agrupamento</h1>
        <p class="text-sm text-gray-600 mt-1">
            Um mapa de agrupamento, ou mapa de cluster, é uma representação visual que organiza pontos de dados próximos 
            ou relacionados em grupos chamados clusters, com base em características comuns, como localização geográfica ou valores semelhantes.
        </p>
    </div>

    <!-- Mapa de Cluster -->
    <div id="clusterMap" wire:ignore class="flex-1 rounded-lg border-gray-300 shadow-sm bg-white"></div>
</div>

<script>
    // ===== CONFIGURAÇÃO DO MAPA =====
    const map = L.map('clusterMap', { 
        attributionControl: false,
        minZoom: 12,
        maxZoom: 18
    }).setView([-22.891, -48.445], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(map);

    const bounds = L.latLngBounds([-23.00, -48.52], [-22.82, -48.36]);
    map.setMaxBounds(bounds);
    map.options.maxBoundsViscosity = 1.0;

    // ===== FUNÇÃO PARA CRIAR MARKERS =====
function criarCluster(reportes, cor) {
    const cluster = L.markerClusterGroup({
        maxClusterRadius: 200,
        // Função para customizar os clusters
        iconCreateFunction: function (cluster) {
            return L.divIcon({
                html: `<div style="
                    background-color: ${cor};
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    font-weight: bold;
                ">${cluster.getChildCount()}</div>`,
                className: 'custom-cluster-icon',
                iconSize: L.point(50, 50)
            });
        }
    });

    reportes.forEach(r => {
        if (r.latitude && r.longitude) {
            const marker = L.circleMarker([r.latitude, r.longitude], {
                radius: 8,
                fillColor: cor,
                color: '#000',
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8
            }).bindPopup(`<b>Categoria:</b> ${r.categoria}`);
            
            cluster.addLayer(marker);
        }
    });

    return cluster;
}

        // ===== CORES PARA CADA CAMADA =====
    const cores = {
        "Asfalto danificado": '#e74c3c',         // vermelho
        "Sinalização deficiente": '#f1c40f',     // amarelo
        "Direção perigosa": '#3498db',           // azul
        "Congestionamento recorrente": '#9b59b6',// roxo
        "Drenagem de água": '#1abc9c'            // verde água
    };

    // ===== LISTA DE RELATÓRIOS =====
    const camadas = {
        "Asfalto danificado": @json($clusterReportesAsfaltoDanificado),
        "Sinalização deficiente": @json($clusterReportesSinalizacaoDeficiente),
        "Direção perigosa": @json($clusterReportesDirecaoPerigosa),
        "Congestionamento recorrente": @json($clusterReporteCongestionamentoRecorrente),
        "Drenagem de água": @json($clusterReportesDrenagemAgua)
    };

    // ===== CRIANDO MARKERS PARA CADA CAMADA =====
const overlays = {};
for (const [nome, reportes] of Object.entries(camadas)) {
    overlays[nome] = criarCluster(reportes, cores[nome]);
}

// ===== ADICIONANDO CONTROLE DE CAMADAS COM COR NOS LABELS =====
const layerControl = L.control.layers(null, null, { collapsed: false }).addTo(map);

for (const [nome, cluster] of Object.entries(overlays)) {
    const label = `<span style="
        display: inline-flex;
        align-items: center;
        width: 12px;
        height: 12px;
        background-color: ${cores[nome]};
        border-radius: 50%;
        margin-right: 6px;
    "></span>${nome}`;
    
    layerControl.addOverlay(cluster, label);
}
</script>
