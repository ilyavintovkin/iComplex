<?php

namespace Block_2\Task_2\managers;

require_once __DIR__ . "/../cages/baseCage/Cage.php";
require_once __DIR__ . "/../animals/Beast.php";
require_once __DIR__ . "/../animals/Bird.php";
require_once __DIR__ . "/../animals/Fish.php";
require_once __DIR__ . "/../enum/Kingdom.php";

use Block_2\Task_2\cages\baseCage\Cage;
use Block_2\Task_2\cages\BeastCage;
use Block_2\Task_2\cages\BirdCage;
use Block_2\Task_2\cages\FishCage;
use Block_2\Task_2\enum\Kingdom;
/**
 * Класс ZooCages содержит в себе все клетки, имеет методы получения или создания нужной клетки для царства.
 */
class ZooCages {

    private array $cages = [];
    /**
     * Получение Клетки для нужного царства
     */
    public function getCage(Kingdom $animalType): Cage {
        foreach ($this->cages as $cage) {
            if ($cage->getCageType() === $animalType) {
                return $cage;
            }
        }

        $cage = $this->createCage($animalType);
        $this->cages[] = $cage;
        return $cage;
    }
    /**
     * Создает Клетку для нужного царства
     */
    public function createCage(Kingdom $animalType): Cage {
        return match ($animalType) {
            Kingdom::BEAST => new BeastCage(),
            Kingdom::BIRD  => new BirdCage(),
            Kingdom::FISH  => new FishCage(),
        };
    }

    public function getAllCages(): array {
        return $this->cages;
    }
}