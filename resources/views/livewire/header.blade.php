<div class="bg-gray-200 shadow-md top-0 left-0 w-full z-50 border-b border-gray-300 backdrop-blur-sm">
    <div class="container mx-auto flex justify-between items-center py-3 px-6">
        <!-- Logo / Título -->
        <a href="{{ route('Home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('/icon/icon-maphome.png') }}" alt="Home" class="w-8 h-8">
            <span class="text-lg font-semibold text-gray-800 hidden sm:block">Registrar Ocorrência</span>
        </a>
        <!-- Nav Links Desktop -->
        <nav class="hidden md:flex space-x-8 items-center">
            <a href="{{ route('heat.map') }}" class="flex flex-col items-center text-sm text-gray-700 hover:text-gray-900 transition">
                <img src="{{ asset('/icon/icon-heatmap.png') }}" alt="Heatmap" class="w-6 h-6 mb-1 opacity-90 hover:opacity-100 transition">
                <span>Mapa de Calor</span>
            </a>

            <a href="{{ route('clustering.map') }}" class="flex flex-col items-center text-sm text-gray-700 hover:text-gray-900 transition">
                <img src="{{ asset('/icon/icon-cluster.png') }}" alt="Cluster" class="w-6 h-6 mb-1 opacity-90 hover:opacity-100 transition">
                <span>Clusters</span>
            </a>

            <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-sm text-gray-700 hover:text-gray-900 transition">
                <img src="{{ asset('/icon/icon-grafico.png') }}" alt="Dashboard" class="w-6 h-6 mb-1 opacity-90 hover:opacity-100 transition">
                <span>Dashboard</span>
            </a>
        </nav>

        <!-- Botão menu Mobile -->
        <button id="menu-btn" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-200 border-t border-gray-300 shadow-lg">
        <nav class="flex flex-col py-2 space-y-1">
            <a href="{{ route('heat.map') }}" class="flex items-center px-6 py-2 hover:bg-gray-300 text-gray-800">
                <img src="{{ asset('/icon/icon-heatmap.png') }}" class="w-6 h-6 mr-2 opacity-90"> Mapa de Calor
            </a>
            <a href="{{ route('clustering.map') }}" class="flex items-center px-6 py-2 hover:bg-gray-300 text-gray-800">
                <img src="{{ asset('/icon/icon-cluster.png') }}" class="w-6 h-6 mr-2 opacity-90"> Clusters
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-2 hover:bg-gray-300 text-gray-800">
                <img src="{{ asset('/icon/icon-grafico.png') }}" class="w-6 h-6 mr-2 opacity-90"> Dashboard
            </a>
        </nav>
    </div>
</div>

<script>
    // Menu mobile toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

