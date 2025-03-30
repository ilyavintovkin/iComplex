<?php

namespace Block_2\Task_2\animals\baseAnimal;

require_once __DIR__ . "/../../animals/baseAnimal/Animal.php";
require_once __DIR__ . "/../../enum/Kingdom.php";

use Block_2\Task_2\enum\Kingdom;

/**
 * Базовый класс животного
 */
abstract class Animal {

    protected Kingdom $kingdom;
    protected int $legs;
    protected int $tails;
    protected int $wings;

    public function __construct($legs, $tails, $wings) {

        $this->legs = $legs;
        $this->tails = $tails;
        $this->wings = $wings;
    }

    public function getKingdom(): Kingdom {
        return $this->kingdom;
    }

    public function getLegs(): int {
        return $this->legs;
    }

    public function getTails(): int {
        return $this->tails;
    }

    public function getWings(): int {
        return $this->wings;
    }

    /**
     * Выводит информацию о животном.
     */
    public function animalInfo(): void {
        echo "Kingdom    :  {$this->getKingdom()->value}\n";
        echo "Legs count :  {$this->getLegs()}\n";
        echo "Tails count:  {$this->getTails()}\n";
        echo "Wings count:  {$this->getWings()}\n\n";
    }
}