<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Session;
use App\Domain\Interfaces\Repositories\PlayerRepository;
use App\Domain\Interfaces\Repositories\SessionRepository;
use App\Domain\Interfaces\UuidGenerator;
use App\Http\Requests\SessionPostRequest;
use App\Services\Facades\SessionFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class SessionController extends Controller
{

    public function __construct(
        private readonly UuidGenerator $uuidGenerator,
        private readonly PlayerRepository $playerRepository,
        private readonly SessionRepository $sessionRepository
    )
    {
    }

    public function index(Request $request): Response
    {
        $sessions = $this->sessionRepository->listPaginate($request->page ?? 1);
        return Inertia::render('Session/Index',[
            'sessions' => $sessions,
        ]);
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

        return redirect()->route('session.show', $session->getId())->with('success', 'Partida criada com sucesso!');

    }
    public function show($id): Response
    {
        $session = $this->sessionRepository->findWithGuildsAndPlayers($id);

        return Inertia::render('Session/Show', [
            'session' => $session->toArray(),
        ]);
    }
}
