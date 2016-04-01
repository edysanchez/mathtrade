<?php


namespace Edysanchez\Mathtrade\Application\Service\ExportMathtradeData;


use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItemRepository;
use Edysanchez\Mathtrade\Domain\Model\WildCard\WildCardRepository;

class ExportMathtradeDataUseCase
{

    /**
     * @var MathtradeItemRepository
     */
    private $itemsRepository;

    /**
     * @var WildCardRepository
     */
    private $wildCardRepository;

    public function __construct(MathtradeItemRepository $itemsRepository, WildCardRepository $wildCardRepository)
    {
        $this->itemsRepository = $itemsRepository;
        $this->wildCardRepository = $wildCardRepository;
    }

    public function execute()
    {
        $items = $this->itemsRepository->findAll() ;
        $data = array();
        $data['games'] = array();
        $data['wildCards'] = array();

        foreach($items as $item) {
            $data['games'][] = $item->game();
        }

        $wildCards = $this->wildCardRepository->findAll();

        $data = $this->plainWildCards($wildCards, $data);
        return new ExportMathtradeDataResponse($data);
    }

    /**
     * @param $wildCards
     * @param $data
     * @return mixed
     */
    protected function plainWildCards($wildCards, $data)
    {
        foreach ($wildCards as $wildCard) {
            $plainWildCard = array();
            $plainWildCard['id'] = $wildCard->id();
            $plainWildCard['user_id'] = $wildCard->userId();
            $plainWildCard['name'] = $wildCard->name();
            $plainWildCard['wildCardItems'] = array();

            foreach ($wildCard->wildCardItems() as $wildCardItem) {
                $plainWildCardItem = array();
                $plainWildCardItem['id'] = $wildCardItem->id();
                $plainWildCardItem['mathtradeItem']['id'] = $wildCardItem->mathTradeItem()->id();
                $plainWildCardItem['mathtradeItem']['game'] = $wildCardItem->mathTradeItem()->game();
                $plainWildCardItem['position'] = $wildCardItem->position();
                $plainWildCard['wildCardItems'][] = $plainWildCardItem;

            }
            $data['wildCards'][] = $plainWildCard;
        }
        return $data;
    }
}
