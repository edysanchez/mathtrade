<?php


namespace Edysanchez\Mathtrade\Domain\Model\WildCard;



class WildCard
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $userId;

    /**
     * @var WildCardItem[]
     */
    private $wildCardItems;
    
    private $id;

    public function __construct($id, $name, $userId, $wildCardItems)
    {
        $this->name = $name;
        $this->userId = $userId;
        $this->wildCardItems = $wildCardItems;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return WildCardItem[]
     */
    public function wildCardItems()
    {
        return $this->wildCardItems;
    }

    /**
     * @return int
     */
    public function userId()
    {
        return $this->userId;
    }


}