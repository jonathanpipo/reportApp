<div class="bg-gradient-to-b from-gray-100 to-gray-200 shadow-inner flex flex-col h-screen">
    <div class="container mx-auto flex-col items-center justify-between py-4 px-4">
        <h1 class="text-2xl font-semibold text-gray-700">Mapa de Calor</h1>
        <p class="text-sm text-gray-600 mt-1">
            Um mapa de calor é uma representação visual de dados em que cores indicam a intensidade ou frequência de determinado fenômeno.
            Normalmente, cores quentes como vermelho e laranja representam áreas de maior concentração ou ocorrência, enquanto cores frias 
            como azul e verde indicam menor intensidade, facilitando a identificação rápida de padrões e regiões críticas.
        </p>
    </div>

    <!-- MAPA -->
    <div id="heatMap" wire:ignore class="flex-1 border border-gray-300 shadow-sm bg-white"></div>
</div>

<script>
const heatMap = L.map('heatMap', { 
    attributionControl: false,
    minZoom: 12,
    maxZoom: 18
}).setView([-22.891, -48.445], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(heatMap);

const bounds = L.latLngBounds([-23.05, -48.52], [-22.82, -48.36]);
heatMap.setMaxBounds(bounds);
heatMap.options.maxBoundsViscosity = 1.0;

// Dados vindos do backend
const camadas = {
    "Asfalto danificado": @json($heatReportesAsfaltoDanificado),
    "Sinalização deficiente": @json($heatReportesSinalizacaoDeficiente),
    "Direção perigosa": @json($heatReportesDirecaoPerigosa),
    "Congestionamento recorrente": @json($heatReporteCongestionamentoRecorrente),
    "Drenagem de água": @json($heatReportesDrenagemAgua),
    "Todos": @json($allHeatReportes)
};

// Criar layers de heatmap para cada conjunto de dados
const heatLayers = {};
for (const [nome, dados] of Object.entries(camadas)) {
    heatLayers[nome] = L.heatLayer(
        dados.map(m => [parseFloat(m.latitude), parseFloat(m.longitude), 10]),
        { 
            radius: 25,   // tamanho do ponto de calor
            blur: 30,     // suavidade da transição entre pontos
            maxZoom: 18   // zoom máximo para o efeito do blur
        }
    );
}

// Adiciona a primeira camada por padrão
let camadaAtual = heatLayers["Todos"];
camadaAtual.addTo(heatMap);

// Criar controle customizado com radio buttons
const ControleCamadas = L.Control.extend({
    onAdd: function(map) {
        const div = L.DomUtil.create('div', 'leaflet-bar p-2 bg-white rounded shadow');
        div.style.backgroundColor = 'white';
        div.style.padding = '10px';
        div.style.borderRadius = '8px';
        
        for (const nome of Object.keys(heatLayers)) {
            const label = document.createElement('label');
            label.style.display = 'block';
            label.style.cursor = 'pointer';
            label.style.marginBottom = '4px';

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'heatLayer';
            radio.value = nome;
            if (nome === 'Todos') radio.checked = true;

            radio.onchange = function() {
                if (camadaAtual) map.removeLayer(camadaAtual);
                camadaAtual = heatLayers[this.value];
                camadaAtual.addTo(map);
            };

            label.appendChild(radio);
            label.appendChild(document.createTextNode(` ${nome}`));
            div.appendChild(label);
        }

        return div;
    }
});

heatMap.addControl(new ControleCamadas({ position: 'topright' }));
</script>
