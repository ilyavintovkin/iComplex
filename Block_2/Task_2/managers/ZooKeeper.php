<?php

namespace Block_2\Task_2\managers;

require_once "ZooCages.php";
require_once  __DIR__ . "/../animals/baseAnimal/Animal.php";
require_once __DIR__ . "/../enum/Kingdom.php";

use Block_2\Task_2\animals\baseAnimal\Animal;
use Block_2\Task_2\enum\Kingdom;
/**
 *  Класс ZooKeeper может поместить созданное животное в нужную клетку, а также выбрать животное из нужной клетки по набору базовых признаков.
 */
class ZooKeeper
{

    private ZooCages $zooCages;

    public function __construct (ZooCages $zooCages) {
        $this->zooCages = $zooCages;
    }
    /**
     * Помещает животное в соответствующую для его Царства клетку
     */
    public function placeAnimal (Animal $animal) : void
    {
        $cage = $this->zooCages->getCage($animal->getKingdom());
        $cage->addAnimal($animal);
    }
    /**
     * Возвращает ?животное подходящее по передаваемым параметрам
     */
    public function getAnimal(Kingdom $kingdom, int $legs = null, int $tails = null, int $wings = null) : ?Animal
    {
        $cage = $this->zooCages->getCage($kingdom);
        return $cage->findAnimalByProperties($legs, $tails, $wings);
    }
}