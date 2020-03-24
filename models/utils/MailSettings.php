<?php


namespace app\models\utils;


use yii\base\Model;

/**
 *
 * @property string $fileName
 */
class MailSettings extends Model
{
    private static $mailSettings;

    public $address;
    public $login;
    public $password;
    public $displayedName;
    public $isTest;
    public $testMailAddress;

    public static function getInstance(): MailSettings
    {
        if(empty(self::$mailSettings)){
            self::$mailSettings = new MailSettings();
        }
        return self::$mailSettings;
    }

    private function __construct($config = [])
    {
        parent::__construct($config);
        $file = $this->getFileName();
        if (!is_file($file)) {
            // создаю файл
            file_put_contents($file, "test\ntest\ntest\ntest\n0\ntest");
        }
        $content = file_get_contents($file);
        $settingsArray = mb_split("\n", $content);
        $this->address = $settingsArray[0];
        $this->login = $settingsArray[1];
        $this->password = $settingsArray[2];
        $this->displayedName = $settingsArray[3];
        $this->isTest = (bool)$settingsArray[4];
        $this->testMailAddress = $settingsArray[5];
    }

    public function save(): void
    {
        $file = $this->getFileName();
        file_put_contents($file, "$this->address\n$this->login\n$this->password\n$this->displayedName\n" . (bool)$this->isTest . "\n$this->testMailAddress");
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return dirname($_SERVER['DOCUMENT_ROOT'] . './/') . '/settings/mail_settings';
    }
}