<?php

require_once "animals/baseAnimal/Animal.php";
require_once "animals/Beast.php";
require_once "animals/Bird.php";
require_once "animals/Fish.php";

require_once "cages/baseCage/Cage.php";
require_once "cages/BeastCage.php";
require_once "cages/BirdCage.php";
require_once "cages/FishCage.php";

require_once "enum/Kingdom.php";

require_once "factories/AnimalFactory.php";

require_once "managers/ZooCages.php";
require_once "managers/ZooKeeper.php";
require_once "managers/ZooManager.php";

use Block_2\Task_2\enum\Kingdom;
use Block_2\Task_2\managers\ZooCages;
use Block_2\Task_2\managers\ZooKeeper;
use Block_2\Task_2\managers\ZooManager;

$zooCages      = new ZooCages();
$zooKeeper     = new ZooKeeper($zooCages);
$zooManager    = new ZooManager($zooKeeper);

$zooManager->getAnimalFromAnimalFactory(Kingdom::BEAST, 4, 1, 0);
$zooManager->getAnimalFromAnimalFactory(Kingdom::BEAST, 4, 1, 2);
$zooManager->getAnimalFromAnimalFactory(Kingdom::FISH, 4, 1, 2);
$zooManager->getAnimalFromAnimalFactory(Kingdom::BIRD, 4, 1, 2);

$allCages = $zooCages->getAllCages();
foreach ($allCages as $cage) {
    foreach ($cage->getAnimals() as $animal) {
        $animal->animalInfo();
    }
}


