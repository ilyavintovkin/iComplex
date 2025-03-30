<?php

/**
 * Базовый класс вывода текста
 */
class BaseTextOutput
{
    protected string $device;
    protected string $message;

    function __construct(string $message, string $device)
    {
        $this->message = $message;
        $this->device = $device;
    }

    public function textOutput(): void
    {
        echo "Device: $this->device | Message: $this->message" . PHP_EOL;
    }
}
/**
 * Расширенный класс вывода текста на Принтере
 */
class PrinterTextOutput extends BaseTextOutput
{
    protected PrinterStatus $isEnabled;

    function __construct(string $message, string $device, PrinterStatus $isEnabled)
    {
        parent::__construct($message, $device);
        $this->isEnabled = $isEnabled;
    }

    public function textOutput(): void
    {
        echo "Device: $this->device | Message: $this->message | Enabled status: {$this->isEnabled->value}" . PHP_EOL;
    }
}
/**
 * Расширенный класс вывода текста на Телефоне
 */
class PhoneTextOutput extends BaseTextOutput
{
    protected int $missedCallsCounter;

    function __construct(string $message, string $device, int $missedCallsCounter)
    {
        parent::__construct($message, $device);
        $this->missedCallsCounter = $missedCallsCounter;
    }

    public function textOutput(): void
    {
        parent::textOutput();
        echo "Missed calls: $this->missedCallsCounter" . PHP_EOL;
    }
}

/**
 * Состояния принтера
 */
enum PrinterStatus: string
{
    case ON = "Включен";
    case OFF = "Выключен";
}

$base = new BaseTextOutput("some base message", "BASE");
$base->textOutput();

$printer = new PrinterTextOutput("insert paper!", "PRINTER", PrinterStatus::OFF);
$printer->textOutput();

$phone = new PhoneTextOutput("battery runs out!", "PHONE", 23);
$phone->textOutput();
