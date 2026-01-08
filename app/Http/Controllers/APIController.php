<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\CardSet;
use App\Models\Card;
use App\Models\Set;


class APIController extends Controller
{

   public function listCards(Request $request) {
      
       $query = Card::query()->with('sets:id,set,set_name');


       //http://127.0.0.1:8000/api/cards?name=Brainstorm
       if ($request->filled('name')) {
           $query->where('name', 'like', '%'.$request->string('name').'%');
       }


       //http://127.0.0.1:8000/api/cards?mana_cost={U}
       if ($request->filled('mana_cost')) {
           $query->where('mana_cost', $request->string('mana_cost'));
       }


       //http://127.0.0.1:8000/api/cards?cmc=1
       if ($request->filled('cmc')) {
           $query->where('cmc', (int) $request->input('cmc'));
       }


       //http://127.0.0.1:8000/api/cards?type_line=Instant
       if ($request->filled('type_line')) {
           $query->where('type_line', 'like', '%'.$request->string('type_line').'%');
       }


       //http://127.0.0.1:8000/api/cards?type_line=Instant
       if ($request->filled('color')) {
           $query->whereJsonContains('colors', $request->string('color'));
       }


       $cards = $query->orderBy('name')->paginate(20);


       return response()->json($cards);
   }


   public function searchCard(int $id) {  //  http://127.0.0.1:8000/api/cards/1
      
       $card = Card::query()->with('sets:id,set,set_name')->find($id);


       if (!$card) {
           return response()->json(['message' => 'Card not found'], 404);
       }


       return response()->json($card);
   }






   public function importCard(Request $request) { //http://127.0.0.1:8000/api/cards/import?name="Lightning Bolt"
  
      
       $validated = $request->validate([
           'name' => ['required', 'string', 'max:150'],
       ]);


       // GET API Scryfall
       $scryfallJson = $this->getScryfall($validated['name']);


       // Selecciona Key:Value para Cards, Sets y CardSets
       [$cardData, $setData, $cardsetsData] = $this->modificarJSON($scryfallJson);




       $card = Card::query()->firstOrCreate(
           ['name' => $cardData['name']],
           $cardData
       );


       $set = Set::query()->firstOrCreate(
           ['set' => $setData['set']],
           $setData
       );


       $cardSet = CardSet::query()->firstOrCreate(
           [
               'card_id' => $card->id,
               'set_id'  => $set->id,
           ],
           $cardsetsData
       );


       $createdNow = $card->wasRecentlyCreated || $set->wasRecentlyCreated || $cardSet->wasRecentlyCreated;


       return response()->json([
           'ok' => true,
           'message' => $createdNow ? 'Creado' : 'Ya estaba creado',
           'created_now' => $createdNow,
           'card' => $card,
           'set' => $set,
           'card_set' => $cardSet,
       ], 201);
   }


   public function updateCard(Request $request, int $id) {   //http://127.0.0.1:8000/api/cards/1?name=Light
       $card = Card::query()->find($id);


       if (!$card) {
           return response()->json(['message' => 'Card not found'], 404);
       }


       $validated = $request->validate([
           'name'        => ['sometimes', 'string', 'max:150'],
           'mana_cost'   => ['sometimes', 'nullable', 'string', 'max:30'],
           'cmc'         => ['sometimes', 'nullable', 'integer', 'min:0'],
           'type_line'   => ['sometimes', 'nullable', 'string', 'max:150'],
           'colors'      => ['sometimes', 'nullable', 'array'],
           'oracle_text' => ['sometimes', 'nullable', 'string'],
           'legalities'  => ['sometimes', 'nullable', 'array'],
       ]);


       $card->fill($validated);
       $card->save();


       return response()->json([
           'ok' => true,
           'card' => $card,
       ]);
   }


   public function deleteCard(int $id) {  //  http://127.0.0.1:8000/api/cards/1
      
       $card = Card::query()->find($id);


       if (!$card) {
           return response()->json(['message' => 'Card not found'], 404);
       }


       $card->delete();


       return response()->json([
           'ok' => true,
           'message' => 'Card deleted',
       ]);
   }


   private function getScryfall(string $exactName): array {


       /** @var Response $response */
       $response = Http::timeout(15)
           ->acceptJson()
           ->get('https://api.scryfall.com/cards/named', [
               'exact' => $exactName,
           ]);


       if ($response->failed()) {
           abort(response()->json([
               'ok' => false,
               'message' => 'Error llamando a Scryfall',
               'status' => $response->status(),
               'body' => $response->body(),
           ], 502));
       }


       return $response->json();
   }


   private function modificarJSON(array $json): array {
      
       $cardData = [
           'name'        => $json['name'] ?? null,
           'mana_cost'   => $json['mana_cost'] ?? null,
           'cmc'         => isset($json['cmc']) ? (int) $json['cmc'] : null,
           'type_line'   => $json['type_line'] ?? null,
           'colors'      => $json['colors'] ?? null,
           'oracle_text' => $json['oracle_text'] ?? null,
           'legalities'  => $json['legalities'] ?? null,
       ];


       $setData = [
           'set'      => $json['set'] ?? null,
           'set_name' => $json['set_name'] ?? null,
       ];


       $cardSetData = [
           'rarity'           => $json['rarity'] ?? null,
           'collector_number' => $json['collector_number'] ?? null,
       ];


       return [$cardData, $setData, $cardSetData];
   }


}
