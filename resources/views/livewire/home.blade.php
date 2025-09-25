<!-- resources/views/marker-form.blade.php -->
<div class="max-w-md mx-auto p-4">
    <h1 class="text-xl font-bold text-center mb-4">Adicionar Marcador</h1>

    <!-- Espaço reservado para o mapa -->
    <div id="map" class="w-full h-64 rounded-md border mb-4">
        <!-- O mapa Leaflet será renderizado aqui -->
    </div>

    <!-- Formulário Livewire -->
    <form wire:submit.prevent="save" class="flex flex-col gap-4">

        <!-- Select 1 -->
        <div>
            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                Categoria
            </label>
            <select id="categoria" wire:model="categoria"
                class="w-full border rounded-md p-2 text-sm">
                <option value="">Selecione...</option>
                <option value="opcao1">Opção 1</option>
                <option value="opcao2">Opção 2</option>
                <option value="opcao3">Opção 3</option>
            </select>
            @error('categoria') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Select 2 -->
        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                Tipo
            </label>
            <select id="tipo" wire:model="tipo"
                class="w-full border rounded-md p-2 text-sm">
                <option value="">Selecione...</option>
                <option value="tipo1">Tipo 1</option>
                <option value="tipo2">Tipo 2</option>
                <option value="tipo3">Tipo 3</option>
            </select>
            @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Botão Submit -->
        <button type="submit"
            class="bg-blue-600 text-white rounded-md py-2 hover:bg-blue-700 transition">
            Salvar
        </button>
    </form>
</div>


  <script>
    const map = L.map('map').setView([-22.891, -48.445], 13); // coordenadas de Botucatu-SP e zoom 13

    // Camada base (tiles do OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    //definição da área do mapa para a cidade de botucatu
    const bounds = L.latLngBounds(
        [-22.95, -48.52], // sudoeste
        [-22.82, -48.36]  // nordeste
    );

    map.setMaxBounds(bounds); //seta no mapa o limite estabelecido 

    map.options.maxBoundsViscosity = 1.0; //puxao elastico de volta ao mapa ao tentar sair da área limitada

    //define apenas 1 marcador
    let currentMarker = null;

    map.on("click", function(e) {
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }

        currentMarker = L.marker(e.latlng).addTo(map);
    });
  </script>

