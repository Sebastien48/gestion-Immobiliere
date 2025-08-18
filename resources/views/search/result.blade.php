@extends('layout')

@section('content')
    <h2 class="text-lg font-bold mb-4">Résultats pour : "{{ $query }}"</h2>
    <div>
        <h3 class="font-semibold">Locataires</h3>
        @forelse($results['locataires'] ?? [] as $loc)
            <p>{{ $loc->nom }} {{ $loc->prenom }}</p>
        @empty
            <p>Aucun locataire trouvé.</p>
        @endforelse
    </div>
    <div class="mt-4">
        <h3 class="font-semibold">Bâtiments</h3>
        @forelse($results['batiments'] ?? [] as $bat)
            <p>{{ $bat->nom }} (Code: {{ $bat->code_batiment }})</p>
        @empty
            <p>Aucun bâtiment trouvé.</p>
        @endforelse
    </div>
    
    <div class="mt-4">
        <h3 class="font-semibold">Bâtiments</h3>
        @forelse($results['batiments'] ?? [] as $bat)
            <p>{{ $bat->nom }} (Code: {{ $bat->code_batiment }})</p>
        @empty
            <p>Aucun bâtiment trouvé.</p>
        @endforelse
    </div>
@endsection