<?php

namespace Block_2\Task_2\cages\baseCage;

require_once __DIR__ . "/../../animals/baseAnimal/Animal.php";
require_once __DIR__ . "/../../enum/Kingdom.php";

use Block_2\Task_2\animals\baseAnimal\Animal;
use Block_2\Task_2\enum\Kingdom;
/**
 * Базовый класс "Клетка"
 */
abstract class Cage {

    protected Kingdom $cageType; // Set в расширенных классах
    private array $animals = [];

    public function addAnimal(Animal $animal): void {
        $this->animals[] = $animal;
    }

    public function getAnimals(): array {
        return $this->animals;
    }

    public function getCageType(): Kingdom {
        return $this->cageType;
    }
    /**
     * Метод ищет animal по передаваемым параметрам
     */
    public function findAnimalByProperties($legs = null, $tails = null, $wings = null) : ?Animal {
        foreach ($this->animals as $animal) {
            if (($legs === null || $animal->getLegs() == $legs) &&
                ($tails === null || $animal->getTails() == $tails) &&
                ($wings === null || $animal->getWings() == $wings)) {
                return $animal;
            }
        }
        return null;
    }
}