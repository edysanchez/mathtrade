<?php

namespace Edysanchez\Mathtrade\Domain\Model\MathtradeItem;

interface MathtradeItemRepository
{

    /**
     * @return MathtradeItem[]
     */
    public function findAll();
    
    /**
     * @return MathtradeItem
     */
    public function find($id);
}
