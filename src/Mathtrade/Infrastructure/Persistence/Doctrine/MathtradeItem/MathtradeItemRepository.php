<?php

namespace Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\MathtradeItem;

use Doctrine\ORM\EntityRepository;
use Edysanchez\Mathtrade\Domain\Model;
use BadMethodCallException;
use Doctrine\DBAL\DriverManager;
use Edysanchez\Mathtrade\Domain\Model\Game\GameRepository;
use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItem;
use Edysanchez\Mathtrade\Domain\Model\MathtradeItem\MathtradeItemRepository as BaseMathtradeItemRepository;
use Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine\DoctrineClient;

class MathtradeItemRepository Extends EntityRepository implements BaseMathtradeItemRepository
{


}
