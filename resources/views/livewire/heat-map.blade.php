<div class="bg-gradient-to-b from-gray-100 to-gray-200 shadow-inner flex flex-col h-screen">
    <div class="container mx-auto flex items-center justify-between py-4 px-4">
            <h1 class="text-2xl font-semibold text-gray-800">Mapa de Calor</h1>
            <!-- Botão de ajuda -->
            <button 
                @click="open = true" 
                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold focus:outline-none"
                title="O que é um mapa de calor?"
            >
                ?
            </button>
    </div>

    <!-- Mapa -->
    <div id="heatMap" wire:ignore class="flex-1 rounded-lg border border-gray-300 shadow-sm bg-white">
        <!-- O mapa Leaflet será renderizado aqui -->
    </div>

    <!-- Modal explicativo -->
    <div x-data="{ open: false }">
        <div 
            x-show="open" 
            class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
        >
            <div 
                x-show="open" 
                x-transition 
                class="bg-white rounded-xl shadow-lg p-6 max-w-md w-full"
            >
                <h2 class="text-xl font-semibold mb-4 text-gray-800">O que é um Mapa de Calor?</h2>
                <p class="text-gray-700 mb-4">
                    Um mapa de calor é uma representação visual de dados onde os valores são
                    representados por cores. Ele é útil para identificar áreas de maior ou menor 
                    concentração de eventos ou informações geográficas.
                </p>
                <div class="flex justify-end">
                    <button 
                        @click="open = false" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>
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
</script>