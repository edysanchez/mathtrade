<?php

namespace Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\MathtradeItem;

use Edysanchez\Mathtrade\Domain\Model;
use BadMethodCallException;
use Doctrine\DBAL\DriverManager;
use Edysanchez\Mathtrade\Domain\Model\Game\GameRepository;
use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItem;
use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItemRepository as BaseMathtradeItemRepository;
use Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\DoctrineClient;

class MathtradeItemRepository implements BaseMathtradeItemRepository
{
    private $connection;
    /**
     * @var DoctrineClient
     */
    private $client;
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * DoctrineItemRepository constructor.
     * @param DoctrineClient $client
     * @param GameRepository $gameRepository
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(DoctrineClient $client, GameRepository $gameRepository)
    {
        $connectionParams = array(
            'dbname' => $client->dbName(),
            'user' => $client->userName(),
            'password' => $client->password(),
            'host' => $client->host(),
            'driver' => $client->driver(),
        );
        $this->connection = DriverManager::getConnection($connectionParams);
        $this->client = $client;
        $this->gameRepository = $gameRepository;
    }

    public function findAll()
    {
        $mathtradeItemSql = "SELECT id,item_id,created FROM items_mt";
        $mathtradeItemsResultSet = $this->connection->fetchAll($mathtradeItemSql);
        $mathtradeItems = array();
        foreach ($mathtradeItemsResultSet as $mathtradeItemResult) {

            $games = array();
            $games[] = $this->gameRepository->find(intval($mathtradeItemResult['item_id']));

            $mathtradeItem = new MathtradeItem(
                utf8_encode($mathtradeItemResult['id']),
                $games
            );
            array_push($mathtradeItems, $mathtradeItem);
        }
        return $mathtradeItems;
    }
    public function find($id)
    {
        $mathtradeItemSql = "SELECT id,item_id,created FROM items_mt where id= ? ";
        $mathtradeItemsResultSet = $this->connection->fetchAll($mathtradeItemSql,array($id));
        $game = $this->gameRepository->find(intval($mathtradeItemsResultSet[0]['item_id']));

        $mathtradeItem = new MathtradeItem(
            utf8_encode($mathtradeItemsResultSet[0]['id']),
            $game
        );
        return $mathtradeItem;
    }
}
