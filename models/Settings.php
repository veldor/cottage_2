<?php


namespace app\models;


use app\models\utils\BankSettings;
use app\models\utils\MailSettings;
use yii\base\Model;

class Settings extends Model
{
    // настройки почты
    public $mailAddress;
    public $mailLogin;
    public $mailPassword;
    public $mailName;
    public $mailIsTest;
    public $mailTestAddress;
    // настройки банка
    public $st;
    public $sntName;
    public $personalAcc;
    public $bankName;
    public $bik;
    public $correspAcc;
    public $payerInn;
    public $kpp;


    public function attributeLabels(): array
    {
        return [
            'st' => 'st',
            'sntName' => 'Название СНТ',
            'mailName' => 'Название СНТ',
            'personalAcc' => 'Расчётный счёт',
            'bankName' => 'Название банка',
            'bik' => 'БИК',
            'correspAcc' => 'Корр.счет',
            'payerInn' => 'ИНН',
            'kpp' => 'КПП',
            'mailAddress' => 'Адрес почты',
            'mailPassword' => 'Пароль',
            'mailLogin' => 'Логин',
            'mailIsTest' => 'Тестовая отправка электронной почты',
            'mailTestAddress' => 'Адрес почты для теста',
        ];
    }

    public function rules(): array
    {
        return [
            [['st', 'personalAcc', 'bankName', 'bik', 'correspAcc', 'payerInn', 'kpp', 'mailAddress', 'mailPassword', 'mailLogin', 'mailName', 'mailIsTest', 'mailTestAddress', 'sntName'], 'required'],
            [['mailAddress', 'mailTestAddress'], 'email'],
        ];
    }

    public function fill(): void
    {
        // заполню форму данными

        // получу текущие настройки почты
        $mailSettings = MailSettings::getInstance();
        $this->mailAddress = $mailSettings->address;
        $this->mailLogin = $mailSettings->login;
        $this->mailPassword = $mailSettings->password;
        $this->mailName = $mailSettings->displayedName;
        $this->mailIsTest = $mailSettings->isTest;
        $this->mailTestAddress = $mailSettings->testMailAddress;

        // получу банковские настройки
        $bankSettings = BankSettings::getInstance();
        $this->st = $bankSettings->st;
        $this->sntName = $bankSettings->snt_name;
        $this->personalAcc = $bankSettings->personalAcc;
        $this->bankName = $bankSettings->bankName;
        $this->bik = $bankSettings->bik;
        $this->correspAcc = $bankSettings->correspAcc;
        $this->payerInn = $bankSettings->payerInn;
        $this->kpp = $bankSettings->kpp;
    }

    public function save(): void
    {
        $mailSettings = MailSettings::getInstance();
        $mailSettings->address = $this->mailAddress;
        $mailSettings->login = $this->mailLogin;
        $mailSettings->password = $this->mailPassword;
        $mailSettings->displayedName = $this->mailName;
        $mailSettings->isTest = $this->mailIsTest;
        $mailSettings->testMailAddress = $this->mailTestAddress;
        $mailSettings->save();

        $bankSettings = BankSettings::getInstance();
        $bankSettings->st = $this->st;
        $bankSettings->snt_name = $this->sntName;
        $bankSettings->personalAcc = $this->personalAcc;
        $bankSettings->bankName = $this->bankName;
        $bankSettings->bik = $this->bik;
        $bankSettings->correspAcc = $this->correspAcc;
        $bankSettings->payerInn = $this->payerInn;
        $bankSettings->kpp = $this->kpp;
        $bankSettings->save();
    }
}