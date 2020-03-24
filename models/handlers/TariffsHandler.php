<?php


namespace app\models\handlers;


use app\exceptions\MyException;
use app\models\tables\TariffMembership;
use app\models\tables\TariffPower;
use yii\base\Model;

class TariffsHandler extends Model
{

    /**
     * Проверка заполненности тарифов
     * @return bool
     * @throws MyException
     */
    public static function isTariffsFilled(): bool
    {
        // проверю заполненность тарифов
        return (TariffPower::isFilled(TimeHandler::getInstance()->getCurrentMonth()) && TariffMembership::isFilled(TimeHandler::getInstance()->getCurrentQuarter()));
    }
}