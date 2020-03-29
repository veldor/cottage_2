<?php


namespace app\models\handlers;


use app\exceptions\MyException;
use DateTime;

class TimeHandler
{
    private static $instance;

    /**
     * @var int
     */
    private $currentTime;

    public static function getInstance(): TimeHandler
    {
        if(empty(self::$instance)){
            self::$instance = new TimeHandler();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->currentTime = time();
    }

    /**
     * Возвращает временную метку в формате гггг-мм
     * @return string <p>Например, 2020-11</p>
     */
    public function getCurrentMonth(): string
    {
        return $this->getMonthFromTimestamp($this->currentTime);
    }

    /**
     * Получаю месяц из временной метки
     * @inheritDoc получу месяц из временной метки
     * @param int $timestamp
     * @return string
     */
    public function getMonthFromTimestamp(int $timestamp): string
    {
        return strftime('%Y-%m', $timestamp);
    }

    /**
     * Получение текущего квартала
     * @return string Квартал, в формате гггг-к
     * @throws MyException Если передано неверное значение месяца
     */
    public function getCurrentQuarter(): string
    {
        return $this->getQuarterFromTimestamp($this->currentTime);
    }


    /**
     * Получение квартала из временной метки
     * @param int $timestamp Временная метка
     * @return string Квартал, в формате гггг-к
     * @throws MyException Если передано неверное значение месяца
     */
    public function getQuarterFromTimestamp(int $timestamp): string
    {
        return $this->getSingleYear($timestamp) . '-' . $this->getQuarterFromMonth((int) $this->getSingleMonth($timestamp));
    }

    /**
     * Получение квартала из номера месяца
     * @param int $month Порядковый номер месяца, от 1 до 12
     * @return int Порядковый номер квартала, от 1 до 4
     * @throws MyException Если передано неверное значение месяца
     */
    public function getQuarterFromMonth(int $month): int
    {
        switch ($month) {
            case 1:
            case 2:
            case 3:
                return 1;
            case 4:
            case 5:
            case 6:
                return 2;
            case 7:
            case 8:
            case 9:
                return 3;
            case 10:
            case 11:
            case 12:
                return 4;
        }
        // передано неверное значение месяца, вызову исключение
        throw new MyException('Неверное значение месяца: ' . $month);
    }

    /**
     * Получение номера месяца из временной метки
     * @param int $timestamp Временная метка
     * @return string Порядковый номер месяца, от 1 до 12
     */
    public function getSingleMonth($timestamp): string
    {
        return strftime('%m', $timestamp);
    }
    /**
     * Получение года из временной метки
     * @param int $timestamp Временная метка
     * @return string Год в фомате гггг
     */
    public function getSingleYear($timestamp): string
    {
        return strftime('%Y', $timestamp);
    }

    /**
     * Получение срока оплаты электроэнергии
     * @param $month <p>месяц в формате yyyy-mm</p>
     * @return int <p>временная метка</p>
     */
    public function getPayUpMonth($month): int
    {
        $date = DateTime::createFromFormat('Y-m-j H-i-s', "{$month}-10 12-00-00");
        $date->modify('+1 month');
        return $date->getTimestamp();
    }

    /**
     * Получение временной метки начала месяца
     * @param $month <p>месяц в формате yyyy-mm</p>
     * @return int <p>временная метка</p>
     */
    public function getMonthStartTimestamp($month): int
    {
        // получу отметку времения 2 числа первого месяца данного года - второго, чтобы исключить поправку на часовой пояс
        $match = null;
        preg_match('/^(\d{4})\W*(\d{2})$/', $month, $match);
        return strtotime("2-$match[2]-$match[1]");
    }

    /**
     * @param $shortMonth
     * @return string
     */
    public function getFullFromShotMonth($shortMonth): string
    {
        return $this->utf8_strftime('%B %Y', DateTime::createFromFormat('Y-m-d', $shortMonth . '-10')->getTimestamp());
    }

    /**
     * @param $format
     * @param null $timestamp
     * @return false|string
     */
    private function utf8_strftime($format, $timestamp = null){
        return  iconv('windows-1251', 'utf-8',strftime($format, $timestamp));
    }
}