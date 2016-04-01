<?php


namespace Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\WildCard;


use Doctrine\DBAL\DriverManager;
use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItemRepository;
use Edysanchez\Mathtrade\Domain\Model\WildCard\WildCard;
use Edysanchez\Mathtrade\Domain\Model\WildCard\WildCardItem;
use Edysanchez\Mathtrade\Domain\Model\WildCard\WildCardRepository as DomainWildCardRepository;
use Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\DoctrineClient;

class WildCardRepository implements DomainWildCardRepository
{
    private $connection;
    /**
     * @var DoctrineClient
     */
    private $client;

    /**
     * @var MathtradeItemRepository
     */
    private $mathtradeItemRepository;

    /**
     * DoctrineItemRepository constructor.
     * @param DoctrineClient $client
     * @param MathtradeItemRepository $mathtradeItemRepository
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(DoctrineClient $client, MathtradeItemRepository $mathtradeItemRepository)
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
        $this->mathtradeItemRepository = $mathtradeItemRepository;
    }

    /**
     * @return WildCard[]
     */
    public function findAll()
    {
        $wildCardsQuery = "SELECT id, user_id, name FROM wildcard";
        $wildCardsResultSet = $this->connection->fetchAll($wildCardsQuery);
        $allWildCards = array();
        foreach($wildCardsResultSet as $wildCards) {
            $wildCardItem = $this->getWildCardItems($wildCards['id']);
            $allWildCards[] = new WildCard($wildCards['id'],$wildCards['name'], $wildCards['user_id'], $wildCardItem);
        }
        return $allWildCards;
    }

    /**
     * @param $wildCardId
     * @return WildCardItem[]
     */
    private function getWildCardItems($wildCardId) {
        $wildCardItemsQuery = "SELECT id, item_id, wildcard_id, pos from wildcarditems where wildcard_id = ?";
        $wildCardItemsResultset = $this->connection->fetchAll($wildCardItemsQuery, array($wildCardId));
        $wildCardItems = array();
        foreach ($wildCardItemsResultset as $wildCardItem) {
            $mathtradeItem = $this->mathtradeItemRepository->find($wildCardItem['item_id']);
            $wildCardItems[] = new WildCardItem($wildCardItem['id'], $mathtradeItem, $wildCardItem['pos']);
        }
        return $wildCardItems;
    }
}