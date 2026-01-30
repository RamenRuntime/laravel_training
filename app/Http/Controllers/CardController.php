<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $cards = Card::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            // Carga relación para evitar N+1 si la muestras en lista:
            // ->with('sets')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('cards.index', compact('cards', 'q'));   
    }

    public function show(Card $card)
    {
        $card->load(['sets']);

        return view('cards.show', ['card' => $card]);
    }
}
