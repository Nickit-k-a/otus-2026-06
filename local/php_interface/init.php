<?php
use Bitrix\Main\EventManager;

require_once __DIR__ . '/../../vendor/autoload.php';


// вывод данных 
function pr($var, $type = false) {
    echo '<pre style="font-size:10px; border:1px solid #000; background:#FFF; text-align:left; color:#000;">';
    if ($type)
        var_dump($var);
    else
        print_r($var);
    echo '</pre>';
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", function (&$arFields) {
    // 18 — ID вашего инфоблока "Доктор" (видно в URL на прошлом скриншоте)
    if ((int)$arFields["IBLOCK_ID"] === 18 && empty($arFields["CODE"]) && !empty($arFields["NAME"])) {
        $arFields["CODE"] = CUtil::translit($arFields["NAME"], "ru", [
            "replace_space" => "-",
            "replace_other" => "-"
        ]);
    }
});


