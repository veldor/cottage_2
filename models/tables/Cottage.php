<?php


namespace app\models\tables;

use yii\db\ActiveRecord;

/**
 * @property int $id [int(10) unsigned]  Глобальный идентификатор
 * @property string $address [varchar(255)]  Номер участка
 * @property bool $is_arrears [tinyint(1)]  Наличие просроченных задолженностей
 * @property bool $is_master [tinyint(1)]  Является ли участок основным
 * @property int $square [int(11)]  Площадь участка
 * @property bool $is_mail [tinyint(1)]  Наличие электронной почты
 * @property bool $is_phone [tinyint(1)]  Наличие телефона
 * @property int $deposit [int(10) unsigned]  Депозит
 * @property string $rights_data [varchar(255)]  Данные о собственности
 * @property string $description Общая информация об участке
 */

class Cottage extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'cottages';
    }

    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_EDIT = 'edit';

    public function scenarios(): array
    {
        return [
            self::SCENARIO_CREATE => ['address', 'square', 'deposit', 'rights_data', 'description'],
            self::SCENARIO_EDIT => ['square', 'membership', 'rights', 'description'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'address' => 'Номер участка',
            'square' => 'Площадь участка',
            'deposit' => 'Депозит участка',
            'rights_data' => 'Сведения о правах владения',
            'description' => 'Сведения об участке',
        ];
    }

    public function rules(): array
    {
        return [
            [['address', 'square'], 'required'],
            ['deposit', 'number']
        ];
    }


    /**
     * @return Cottage[]
     */
    public static function getOrderedCottages(): array
    {
        return self::find()->orderBy('cast(address as unsigned) asc')->all();
    }


}