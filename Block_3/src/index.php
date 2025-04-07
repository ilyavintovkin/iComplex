<?php
enum Age: int {
    case ZERO = 0;
    case TWELVE = 12;
    case THIRTY_FIVE = 35;
    case SIXTY = 60;
}

enum Period: string {
    case CHILDHOOD = "детство";
    case YOUNG_ADULTHOOD = "молодость";
    case OLD_AGE = "старость";
}

function getPeriodByAge(int $age): string {
    return match (true) {
        $age < Age::TWELVE->value => Period::CHILDHOOD->value,
        $age < Age::THIRTY_FIVE->value => Period::YOUNG_ADULTHOOD->value,
        default => Period::OLD_AGE->value,
    };
}

$name = htmlspecialchars($_POST["name"]);
$age = (int)$_POST["age"];

if ($age <= Age::ZERO->value) {
    echo "Возраст должен быть больше нуля.";
    return;
}

$period = getPeriodByAge($age);

echo "Привет, $name! Тебе $age лет, это — $period.";