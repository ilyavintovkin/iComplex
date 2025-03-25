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
//$str_array = [
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
//$a_array = [];
//$b_array = [];
//
//foreach ($str_array as $str) {
//    (str_contains($str, $subString)) ? $a_array[] = $str : $b_array[] = $str;
//}
//
//var_dump($a_array);
//var_dump($b_array);

/**
 * Основы PHP Task_2
 * Реализовать алгоритм сортировки массива.
 */

//$int_array = [1,2,3,10,7,8,6,4,5];
//
//echo "Before sort: \n";
//var_dump($int_array);
//
//for ($i = 0; $i < count($int_array) - 1; $i++) {
//    for ($j = 0; $j < count($int_array) - $i - 1; $j++) {
//        if ($int_array[$j] > $int_array[$j + 1]) {
//            swap($int_array[$j], $int_array[$j + 1]);
//        }
//    }
//}
//
//function swap(int &$first_num, int &$second_num) : void
//{
//    $tmp = $first_num;
//    $first_num = $second_num;
//    $second_num = $tmp;
//}
//
//echo "After sort: \n";
//var_dump($int_array);

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

//function createUserName (int $min, int $max) : string
//{
//    $latinAlphabet = 'abcdefghijklmnopqrstuvwxyz';
//    $length = rand($min, $max);
//
//    $randomUserName = '';
//
//    for ($i = 0; $i < $length; $i++) {
//        $randomUserName .= $latinAlphabet[ rand(0, strlen($latinAlphabet) - 1) ];
//    }
//
//    return $randomUserName;
//}
//
//$isGirl = 'Girl!';
//$isBoy = 'Boy!';
//
//$minLength = 5;
//$maxLength = 7;
//
//$uniqueSymbolsMode = 3;
//
//$userName = createUserName($minLength, $maxLength);
//$uniqueSymbolsCount = strlen(count_chars($userName, $uniqueSymbolsMode));
//
//echo "\nUsername: " . $userName .
//     "\nUsername all symbols count: " . strlen($userName)  .
//     "\nUsername unique symbols count: " . $uniqueSymbolsCount .
//     "\n";
//
//$result = ($uniqueSymbolsCount % 2 == 0) ? $isGirl : $isBoy;
//
//echo  $result;




