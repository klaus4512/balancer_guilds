<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Player;
use App\Domain\Enums\CharacterClass;
use App\Domain\Interfaces\UuidGenerator;
use App\Http\Requests\PlayerStoreRequest;
use App\Services\Facades\PlayerFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlayerController extends Controller
{
    //
    public function __construct(private UuidGenerator $uuidGenerator)
    {
    }

    public function index(Request $request): Response
    {
        $players = PlayerFacade::index($request->page ?? 1);
        return Inertia::render('Player/Index', [
            'players' => $players
        ]);
    }

    public function create(): Response
    {
        $characterClasses = CharacterClass::toArray();
        return Inertia::render('Player/Create',
            [
                'characterClasses' => $characterClasses
            ]
        );
    }

    public function store(PlayerStoreRequest $request): RedirectResponse
    {
        $player = new Player(
            $this->uuidGenerator->generate(),
            $request->name,
            CharacterClass::getFromValue($request->characterClass),
            $request->level,
        );
        PlayerFacade::store($player);

        return redirect()->route('player.index')->with('success', 'Jogador criado.');
    }

    public function destroy($id): RedirectResponse
    {
        try{
            PlayerFacade::delete($id);
            return redirect()->route('player.index')->with('success', 'Jogador deletado com sucesso!.');
        }catch (\Exception $e){
            return redirect()->route('player.index')->with('error', $e->getMessage());
        }
    }

}
