<?php


namespace app\models\tariffs;


use app\models\handlers\TimeHandler;
use app\models\tables\TariffPower;
use Yii;
use yii\base\Model;

class TariffsFill extends Model
{
    public $power;
    public $membership;
    public $target;
    public $test;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['power', 'membership', 'target'], 'safe'],
            [['power'], 'validatePower', 'skipOnEmpty' => true],
        ];
    }



    public function validatePower($attribute): void
    {
        if (!empty($this->$attribute)) {
            $filled = false;
            $errors = [];
            foreach ($this->$attribute as $key => $value) {
                // разберу каждый из аттрибутов
                foreach ($value as $itemKey => $itemValue) {
                    if(!empty($itemValue)){
                        $filled = true;
                    }
                    if($itemKey === 'month'){
                        if(TariffPower::isFilled($itemValue)){
                            $errors [] = ["{$attribute}[{$key}][{$itemKey}]", 'Тариф на месяц уже заполнен'];
                        }
                    }
                    elseif($itemKey === 'limit' || $itemKey === 'cost' || $itemKey === 'overCost'){
                        // проверю, что значение больше 0
                        if($itemValue < 0){
                            $errors [] = ["{$attribute}[{$key}][{$itemKey}]", 'Значение должно быть больше или равно нулю'];
                        }
                    }
                }
            }
            if($filled){
                foreach ($errors as $error) {
                    $this->addError($error[0], $error[1]);
                }
            }
        }
    }

    /**
     * Сохранение данных по тарифам
     */
    public function save(): void
    {
        $timeHandler = TimeHandler::getInstance();
        if(!empty($this->power)){
            foreach ($this->power as $item) {
                $newPower = new TariffPower(['month' => $item['month'], 'power_limit' => $item['limit'], 'power_cost' => $item['cost'], 'power_over_cost' => $item['overCost']]);
                $newPower->search_timestamp = $timeHandler->getMonthStartTimestamp($item['month']);
                $newPower->pay_up_time = $timeHandler->getPayUpMonth($item['month']);
                Yii::$app->session->addFlash('success', 'Добавлен тариф электроэнергии на ' . $timeHandler->getFullFromShotMonth($item['month']));
                $newPower->save();
            }
        }
    }
}