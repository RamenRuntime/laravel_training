@extends('layouts.app')

@section('title', $card->name)

@section('content')
  <p><a href="{{ route('cards.index') }}">← Volver</a></p>

  <h1>{{ $card->name }}</h1>

  <dl>
    <dt>Mana cost</dt>
    <dd>{{ $card->mana_cost ?? '—' }}</dd>

    <dt>CMC</dt>
    <dd>{{ $card->cmc ?? '—' }}</dd>

    <dt>Type line</dt>
    <dd>{{ $card->type_line ?? '—' }}</dd>

    <dt>Colors</dt>
    <dd>
      @php($colors = $card->colors ?? [])
      {{ empty($colors) ? '—' : implode(', ', $colors) }}
    </dd>

    <dt>Oracle text</dt>
    <dd style="white-space: pre-wrap;">{{ $card->oracle_text ?? '—' }}</dd>
  </dl>

  <h2>Legalities</h2>
  @php($legalities = $card->legalities ?? [])
  @if(empty($legalities))
    <p>—</p>
  @else
    <table border="1" cellpadding="6" cellspacing="0">
      <thead>
        <tr>
          <th>Format</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($legalities as $format => $status)
          <tr>
            <td>{{ $format }}</td>
            <td>{{ $status }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <h2>Sets</h2>
  @if($card->sets->isEmpty())
    <p>—</p>
  @else
    <ul>
      @foreach($card->sets as $set)
        <li>
          {{-- Ajusta estos campos según tu modelo Set --}}
          <strong>{{ $set->name ?? ('Set #'.$set->id) }}</strong>
          <small>
            (rarity: {{ $set->pivot->rarity ?? '—' }},
             collector: {{ $set->pivot->collector_number ?? '—' }})
          </small>
        </li>
      @endforeach
    </ul>
  @endif
@endsection
