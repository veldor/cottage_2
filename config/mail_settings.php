<?php
// прочитаю настройки из файла
$file = dirname($_SERVER['DOCUMENT_ROOT'] . './/') . '/settings/mail_settings';
if (!is_file($file)) {
    // создаю файл
    file_put_contents($file, "test\ntest\ntest\ntest\n0\ntest");
}
$content = file_get_contents($file);
$settingsArray = mb_split("\n", $content);

return ['address' => $settingsArray[0], 'login' => $settingsArray[1], 'password' => $settingsArray[2], 'name' => $settingsArray[3], 'test' => $settingsArray[4], 'testMail' => $settingsArray[5]];