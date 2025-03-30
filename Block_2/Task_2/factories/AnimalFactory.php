<?php

namespace Block_2\Task_2\factories;

require_once __DIR__ . "/../animals/baseAnimal/Animal.php";
require_once __DIR__ . "/../animals/Beast.php";
require_once __DIR__ . "/../animals/Bird.php";
require_once __DIR__ . "/../animals/Fish.php";
require_once __DIR__ . "/../enum/Kingdom.php";

use Block_2\Task_2\animals\baseAnimal\Animal;
use Block_2\Task_2\animals\Beast;
use Block_2\Task_2\animals\Bird;
use Block_2\Task_2\animals\Fish;
use Block_2\Task_2\enum\Kingdom;
/**
 * AnimalFactory создает экземпляры с набором свойств (Царство - звери, рыбы, птицы, количество лап, хвостов, крыльев).
 */
class AnimalFactory {

    /**
     * Создает экземпляр с набором свойств
     */
    public static function createAnimal($kingdom, $legs, $tails, $wings) : Animal {
        return match ($kingdom) {
            Kingdom::BEAST => new Beast($legs, $tails, $wings),
            Kingdom::BIRD  => new Fish($legs, $tails, $wings),
            Kingdom::FISH  => new Bird($legs, $tails, $wings)
        };
    }
}