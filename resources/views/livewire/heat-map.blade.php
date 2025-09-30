<div>
    <h1>HeatMap</h1>
    <div id="heatMap" wire:ignore class="w-full h-64 rounded-md border mb-4">
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
</script>