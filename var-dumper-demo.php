<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION 
 * */

$APPLICATION->SetTitle('Демо Var_dumper');

dump([
'32' => '22',
'35' => [
    '321' => [
        '321' => 'ddds'
        ],
    ],
]);








require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';