<?php

namespace Block_2\Task_2\animals;

require_once 'baseAnimal/Animal.php';
require_once  __DIR__ . '/../enum/Kingdom.php';

use Block_2\Task_2\animals\baseAnimal\Animal;
use Block_2\Task_2\enum\Kingdom;
/**
 * Расширенный класс "Животное" для царства Птицы
 */
class Bird extends Animal {

    protected Kingdom $kingdom = Kingdom::BIRD;
}