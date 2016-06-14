<?php

namespace Edysanchez\Mathtrade\Infrastructure\Persistence\XmlApi\Game;

use Edysanchez\Mathtrade\Domain\Model\Game\BoardGameGeekSearchableRepository;
use Edysanchez\Mathtrade\Domain\Model\Game\Game;
use Edysanchez\Mathtrade\Infrastructure\Persistence\XmlApi\BoardGameGeekXmlApiService;


class BoardGameGeekRepository implements BoardGameGeekSearchableRepository
{

    /**
     * @var BoardGameGeekXmlApiService
     */
    private $boardGameGeekXmlApiService;

    public function __construct(BoardGameGeekXmlApiService $boardGameGeekXmlApiService)
    {

        $this->boardGameGeekXmlApiService = $boardGameGeekXmlApiService;
    }

    /**
    * @param $username
    * @return Game []
    */
    public function findTradeableByUsername($username)
    {

        $data = $this->boardGameGeekXmlApiService->findTradeableByUsername($username);
        $games = array();

        foreach ($data as $gameNode) {

            $game = $this->makeGame($gameNode);

            $games[] = $game;
        }

        return $games;
    }


    /**
     * @param $gameNode
     * @return Game
     */
    protected function makeGame($gameNode)
    {
        $id = uniqid();
        $game = new Game((int)$id, (string)$gameNode->name);
        $game->setThumbnail((string)$gameNode->thumbnail);
        $game->setDescription((string)$gameNode->conditiontext);
        $attributes = $gameNode->attributes();
        $game->setBoardGameGeekId((int)$attributes['objectid']);
        $game->setCollectionId((int)$attributes['collid']);
        return $game;
    }


}
