<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Session;
use App\Domain\Interfaces\Repositories\PlayerRepository;
use App\Domain\Interfaces\UuidGenerator;
use App\Http\Requests\SessionPostRequest;
use App\Services\Facades\SessionFacade;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class SessionController extends Controller
{

    public function __construct(private readonly UuidGenerator $uuidGenerator, private readonly PlayerRepository $playerRepository)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Session/Index');
    }

    public function create(): Response
    {
        $players = $this->playerRepository->all();
        return Inertia::render('Session/Create', [
            'players' => $players,
        ]);
    }

    public function store(SessionPostRequest $request): RedirectResponse
    {
        $session = new Session(
            $this->uuidGenerator->generate(),
            $request->name,
            $request->maxGuildPlayers
        );

        $players = [];
        foreach ($request->players as $playerId) {
            $players[] = $this->playerRepository->find($playerId);
        }

        try{
            SessionFacade::create($session, $players);
        }catch (\Exception $e){
            return redirect()->route('session.index')->with('error', $e->getMessage());
        }

        return redirect()->route('session.index')->with('success', 'Partida criada com sucesso!');

    }
}
