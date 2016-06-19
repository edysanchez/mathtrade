<?php


namespace Edysanchez\Mathtrade\Infrastructure\Persistence\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    /**
     * @return EntityManager
     */
    public function build($conn)
    {
        var_dump($conn);
        return EntityManager::create(
            $conn,
            Setup::createYAMLMetadataConfiguration(array(__DIR__.'/config'), true)
        );
    }
}