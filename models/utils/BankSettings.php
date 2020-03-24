<?php


namespace app\models\utils;


use yii\base\Model;

/**
 *
 * @property string $fileName
 */
class BankSettings extends Model
{
    public $st;
    public $snt_name;
    public $personalAcc;
    public $bankName;
    public $bik;
    public $correspAcc;
    public $payerInn;
    public $kpp;

    /**
     * @var BankSettings
     */
    private static $bankSettings;

    public static function getInstance(): BankSettings
    {
        if(empty(self::$bankSettings)){
            self::$bankSettings = new BankSettings();
        }
        return self::$bankSettings;
    }

    private function __construct($config = [])
    {
        parent::__construct($config);
        $file = $this->getFileName();
        if (!is_file($file)) {
            // создаю файл
            file_put_contents($file, "\n\n\n\n\n\n\n\n");
        }
        $content = file_get_contents($file);
        $settingsArray = mb_split("\n", $content);
        $this->st = $settingsArray[0];
        $this->snt_name = $settingsArray[1];
        $this->personalAcc = $settingsArray[2];
        $this->bankName = $settingsArray[3];
        $this->bik = $settingsArray[4];
        $this->correspAcc = $settingsArray[5];
        $this->payerInn = $settingsArray[6];
        $this->kpp = $settingsArray[7];
    }

    public function save(): void
    {
        $file = $this->getFileName();
        file_put_contents($file, "$this->st\n$this->snt_name\n$this->personalAcc\n$this->bankName\n$this->bik\n$this->correspAcc\n$this->payerInn\n$this->kpp");
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return dirname($_SERVER['DOCUMENT_ROOT'] . './/') . '/settings/bank_settings';
    }
}