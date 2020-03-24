<?php


namespace app\models\tables;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $quarter [varchar(6)]  Квартал оплаты
 * @property int $from_cottage [int(10) unsigned]  Оплата с участка
 * @property int $from_square [int(10) unsigned]  Оплата с сотки
 * @property int $search_timestamp [int(10) unsigned]  Временная метка начала периода
 * @property int $pay_up_time [int(10) unsigned]  Срок оплаты
 */

class TariffMembership extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tariffs_membership';
    }

    /**
     * Проверка заполнения тарифа на квартал
     * @param string $quarter <p>Квартал в формате гггг-к</p>
     * @return int|string <p>Возвращается 1 если тариф заполнен и 0, если нет</p>
     */
    public static function isFilled(string $quarter)
    {
        return self::find()->where(['quarter' => $quarter])->count();
    }
}