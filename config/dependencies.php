<?php

//Creating a buider container
$builder = new DI\ContainerBuilder();

//Creating a definition of PDO instance
$builder->addDefinitions([
    \PDO::class => function (): \PDO {        
        return \HackbartPR\Config\ConnectionCreator::createConnection();
    }
]);

//Creating a container
$container = $builder->build();

return $container;