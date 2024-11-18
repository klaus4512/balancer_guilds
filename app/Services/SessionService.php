<?php

namespace App\Services;

use App\Domain\Entities\Player;
use App\Domain\Entities\Session;
use App\Domain\Interfaces\Repositories\GuildRepository;
use App\Domain\Interfaces\Repositories\SessionRepository;
use App\Services\Facades\GuildFacade;

class SessionService
{

    public function __construct(
        private readonly SessionRepository $sessionRepository,
        private readonly GuildRepository $guildRepository
    )
    {
    }

    /**
     * @param Session $session
     * @param Player[] $players
     */
    public function create(Session $session, array $players):void
    {
        $this->sessionRepository->create($session);
        $guilds = GuildFacade::generateGuilds($players, $session->getMaxGuildPlayers(), $session->getId());
        foreach ($guilds as $key => $guild) {
            $guilds[$key] = GuildFacade::calculateAverageRating($guild);
        }
        $guilds = GuildFacade::balanceGuilds($guilds);
        foreach ($guilds as $guild) {
            $this->guildRepository->store($guild);
        }
    }

}
