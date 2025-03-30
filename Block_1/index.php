<?php

/**
* Основы PHP Task_1
* Разобрать заданный массив строк [... String ...].
* Если элемент содержит заданную подстроку $subString,
* кладем в массив A, если не содержит - в массив B.
* Вывести итоговые массивы. Предложить варианты решения.
*/

//$subString = readline();
//
//$baseArray = [
//    'Purple is a color',
//    'a mix of blue and red',
//    'Purple is my teddy-bear',
//    'sitting on my bed',
//    'Purple is a violet',
//    'growing in the spring',
//    'Purple is an amethyst',
//    'sparkling in a ring'
//];
//
//$aArray = [];
//$bArray = [];
//
//foreach ($baseArray as $str) {
//    (str_contains($str, $subString)) ? $aArray[] = $str : $bArray[] = $str;
//}
//
//var_dump($aArray);
//var_dump($bArray);

/**
 * Основы PHP Task_2
 * Реализовать алгоритм сортировки массива.
 */

//$array = [1,2,3,10,7,8,6,4,5];
//
//echo "Before sort: \n";
//var_dump($array);
//
//for ($i = 0; $i < count($array) - 1; $i++) {
//    for ($j = 0; $j < count($array) - $i - 1; $j++) {
//        if ($array[$j] > $array[$j + 1]) {
//            swap($array[$j], $array[$j + 1]);
//        }
//    }
//}
//
//function swap(int &$firstNum, int &$secondNum) : void {
//    $tmp = $firstNum;
//    $firstNum = $secondNum;
//    $secondNum = $tmp;
//}
//
//echo "After sort: \n";
//var_dump($array);

/**
 * Основы PHP Task_3
 * Программист придумал, как по никнейм определить пол собеседника.
 * Вот его метод: если количество различных символов в имени пользователя нечетное,
 * тогда пользователь мужского пола, иначе — женского.
 * Вам дана строка, обозначающая имя пользователя,
 * помогите нашему герою определить по ней пол пользователя по описанному методу.
 * В переменную запишите строку, состоящую из случайных строчных букв латинского алфавита — имя пользователя,
 * случайной длины от 10 до 100 букв.
 * Напишите алгоритм определения пола по заданному правилу.
 * Если пользователь оказался женского пола по методу нашего героя, выведите “Girl!” (без кавычек), иначе, выведите «Boy!».
 */

function createUserName (int $min, int $max) : string {

    $latinAlphabet = 'abcdefghijklmnopqrstuvwxyz';
    $length = rand($min, $max);

    $randomUserName = '';

    for ($i = 0; $i < $length; $i++) {
        $randomUserName .= $latinAlphabet[ rand(0, strlen($latinAlphabet) - 1) ];
    }

    return $randomUserName;
}

$isGirl = 'Girl!';
$isBoy = 'Boy!';

$minLength = 10;
$maxLength = 100;

const UNIQUE_SYMBOLS_MODE = 3;

$userName = createUserName($minLength, $maxLength);
$uniqueSymbolsCount = strlen(count_chars($userName, UNIQUE_SYMBOLS_MODE));

echo "\nUsername: " . $userName .
     "\nUsername all symbols count: " . strlen($userName)  .
     "\nUsername unique symbols count: " . $uniqueSymbolsCount .
     "\n";

$result = ($uniqueSymbolsCount % 2 == 0) ? $isGirl : $isBoy;

echo  $result;




