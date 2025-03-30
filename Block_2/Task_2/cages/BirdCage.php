<?php

namespace Block_2\Task_2\cages;

require_once 'baseCage/Cage.php';
require_once  __DIR__ . '/../enum/Kingdom.php';

use Block_2\Task_2\cages\baseCage\Cage;
use Block_2\Task_2\enum\Kingdom;
/**
 * Расширенный класс "Клетка" для царства "Птицы"
 */
class BirdCage extends Cage {

    protected Kingdom $cageType = Kingdom::BIRD;
}