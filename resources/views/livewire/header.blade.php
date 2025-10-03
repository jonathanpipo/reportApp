<div class="bg-gradient-to-b from-gray-50 via-gray-100 to-gray-200 text-gray-800 top-0 left-0 w-full shadow-md z-50">
    <div class="container mx-auto flex justify-between items-center py-3 px-4">
        <nav class="space-x-4 flex w-full space-x-4 items-center justify-between mx-auto">
            <a href="{{ route('Home') }}" class="hover:text-gray-300 flex flex-1 justify-center"><img src="{{ asset('/icon/icon-maphome.png') }}" alt="Home"></a>
            <a href="{{ route('heat.map') }}" class="hover:text-gray-300 flex flex-1 justify-center"><img src="{{ asset('/icon/icon-heatmap.png') }}" alt="Heatmap"></a>
            <a href="{{ route('clustering.map') }}" class="hover:text-gray-300 flex flex-1 justify-center"><img src="{{ asset('/icon/icon-cluster.png') }}" alt="Clustermap"></a>
            <a href="{{ route('dashboard') }}" class="hover:text-gray-300 flex flex-1 justify-center"><img src="{{ asset('/icon/icon-grafico.png') }}" alt="Dashboard"></a>
        </nav>
    </div>
</div>
