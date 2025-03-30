<?php

namespace Block_2\Task_2\managers;

require_once "ZooKeeper.php";
require_once __DIR__ . "/../animals/baseAnimal/Animal.php";
require_once __DIR__ . "/../enum/Kingdom.php";
require_once __DIR__ . "/../factories/AnimalFactory.php";

use Block_2\Task_2\animals\baseAnimal\Animal;
use Block_2\Task_2\enum\Kingdom;
use Block_2\Task_2\factories\AnimalFactory;

/**
 * Класс ZooManager получает из фабрики экземпляр животного и отдает его ZooKeeper
 */
class ZooManager {

    private ZooKeeper $zooKeeper;

    public function __construct(ZooKeeper $zooKeeper) {
        $this->zooKeeper = $zooKeeper;
    }

    /**
     * Метод получение экземпляра от Фабрики и его передача смотрителю зоопарка (ZooKeeper). ZooKeeper - помещает экземпляр в подходящую клетку
     */
    public function getAnimalFromAnimalFactory(Kingdom $kingdom, int $legs, int $tails, int $wings) : Animal {
        $animal = AnimalFactory::createAnimal($kingdom, $legs, $tails, $wings);
        $this->zooKeeper->placeAnimal($animal);

        return $animal;
    }
}
