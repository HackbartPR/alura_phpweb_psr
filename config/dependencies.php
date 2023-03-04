<?php

//Creating a buider container
$builder = new DI\ContainerBuilder();

//Creating a definition of PDO instance
$builder->addDefinitions([
    \PDO::class => function (): \PDO {        
        return \HackbartPR\Config\ConnectionCreator::createConnection();
    },
    League\Plates\Engine::class => function () {
        $path = __DIR__ . '/../view';
        return new \League\Plates\Engine($path);
    }
]);

//Creating a container
$container = $builder->build();

return $container;