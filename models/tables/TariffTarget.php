<?php


namespace app\models\tables;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property int $year [int(4)]  Год оплаты
 * @property int $from_cottage [int(10) unsigned]  Оплата с участка
 * @property int $from_square [int(10) unsigned]  Оплата с сотки
 * @property int $search_timestamp [int(10) unsigned]  Временная метка начала периода
 * @property string $target Цель платежа
 * @property int $pay_up_time [int(10) unsigned]  Срок оплаты
 */

class TariffTarget extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tariffs_target';
    }
}