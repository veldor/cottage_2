<?php


namespace app\models\tables;


use yii\db\ActiveRecord;

/**
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $month [varchar(7)]  Месяц оплаты
 * @property int $power_limit [smallint(5) unsigned]  Льготный лимит электроэнергии
 * @property int $power_cost [int(10) unsigned]  Льготная цена киловатта
 * @property int $power_over_cost [int(10) unsigned]  Цена киловатта
 * @property int $search_timestamp [int(10) unsigned]  Время начала периода
 * @property int $pay_up_time [int(10) unsigned]  Срок оплаты
 */

class TariffPower extends ActiveRecord
{
    public const SCENARIO_FILL = 'fill';

    /**
     * @return array
     */
    public function scenarios() :array
    {
        $myScenarios = [
            self::SCENARIO_FILL => ['month', 'power_limit', 'power_cost', 'power_over_cost', 'pay_up_time']
        ];
        return array_merge($myScenarios, parent::scenarios());
    }

    public static function tableName(): string
    {
        return 'tariffs_power';
    }
    /**
     * Проверка заполнения тарифа на месяц
     * @param string $month <p>Месяц в формате гггг-мм</p>
     * @return int <p>Возвращается 1 если тариф заполнен и 0, если нет</p>
     */
    public static function isFilled(string $month): int
    {
        return self::find()->where(['month' => $month])->count();
    }
}