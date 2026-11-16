<?php

use Bitrix\Seo\Engine\Bitrix;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
// print_r(value: '<pre>');
// print_r(value: 'var_dump($_Server): ');
// print_r(var_dump($_SERVER));
// print_r(value: '<pre>');

// dump($_SERVER);

// \Bitrix\Main\Diag\Debug::dumpToFile($_SERVER, varName: 'SERVER');

// \Bitrix\Main\Diag\Debug::startTimeLabel(name: 'Server1');
// sleep(seconds: 2);
// \Bitrix\Main\Diag\Debug::endTimeLabel(name: 'Server1');
// $TimeLabels = \Bitrix\Main\Diag\Debug::getTimeLabels();

// \Bitrix\Main\Diag\Helper::getBackTrace();

// if (!\Bitrix\Main\Loader::includeModule('iblock')) {
//     return false;
// }

// $IBLOCK_ID = 7; // Фотогалерея пользователей

// // Параметры выборки
// $arEntityDataParams = [
//     'select' => ['ID', 'NAME'],
//     'filter' => ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y'],
//     'limit'  => 5
// ];

// // Включаем трекинг SQL
// $connection = \Bitrix\Main\Application::getConnection();
// $tracker = $connection->startTracker();

// // Выполняем запрос
// $query = \Bitrix\Iblock\ElementTable::getList($arEntityDataParams);
// $result = $query->fetchAll();

// // Отключаем трекер
// $connection->stopTracker();

// // Выводим сам SQL-запрос, время его выполнения и результат выборки
// foreach ($tracker->getQueries() as $trackQuery) {
//     \Bitrix\Main\Diag\Debug::dump($trackQuery->getSql(), 'SQL запрос');
//     \Bitrix\Main\Diag\Debug::dump($trackQuery->getTime(), 'Время выполнения (сек)');
// }

// \Bitrix\Main\Diag\Debug::dump($result, 'Результат выборки');

$hh = 1/0;


require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; 