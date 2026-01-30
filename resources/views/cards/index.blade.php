@extends('layouts.app')

@section('title', 'Cards')

@section('content')
  <h1>Cards</h1>

  <form method="GET" action="{{ route('cards.index') }}" style="margin-bottom: 1rem;">
    <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por nombre...">
    <button type="submit">Buscar</button>

    @if($q !== '')
      <a href="{{ route('cards.index') }}">Limpiar</a>
    @endif
  </form>

  @if($cards->count() === 0)
    <p>No hay resultados.</p>
  @else
    <ul>
      @foreach ($cards as $card)
        <li>
          <a href="{{ route('cards.show', $card) }}">{{ $card->name }}</a>
          @if(!is_null($card->cmc))
            <small>(CMC: {{ $card->cmc }})</small>
          @endif
        </li>
      @endforeach
    </ul>

    {{ $cards->links() }}
  @endif
@endsection
