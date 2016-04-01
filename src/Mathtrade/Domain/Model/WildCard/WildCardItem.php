<?php


namespace Edysanchez\Mathtrade\Domain\Model\WildCard;


use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItem;

class WildCardItem
{
    private $id;
    private $mathTradeItem;
    private $position;

    public function __construct($id, $mathTradeItem, $position)
    {

        $this->id = $id;
        $this->mathTradeItem = $mathTradeItem;
        $this->position = $position;
    }


    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return MathtradeItem
     */
    public function mathTradeItem()
    {
        return $this->mathTradeItem;
    }

    /**
     * @return mixed
     */
    public function position()
    {
        return $this->position;
    }

}