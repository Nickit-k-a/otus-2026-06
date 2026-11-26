<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Работа с API инфоблоков');

use Bitrix\Main\Loader;
use Bitrix\Iblock\Iblock;
Loader::includeModule('iblock');

$iblockId = 5;
$iblockElementId = 1;

// Old API 
// $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
// $arSelect = ['ID', 'NAME', 'PROPERTY_PERSON', 'PROPERTY_PHONE', 'PROPERTY_DOBROTA'];
// $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
// $items = [];
// while($arFields = $res->fetch()){
//     // pr($arFields);
//     $items[] = $arFields;
// }
// pr($items);

 
// создание новой записи в инфоблоке через CIBlockElement
// $arElementProps = [
//     'PERSON' => 'X5',
//     'PHONE'=> '554354',
// ];
// $arIblockFields = [
//     'IBLOCK_ID' => $iblockId,
//     'NAME' => 'New element',
//     'PROPERTY_VALUES' => $arElementProps
// ];
// $objIblockElement = new \CIBlockElement();
// $objIblockElement->Add($arIblockFields);

// $objIblockElement = new \CIBlockElement();
// $newId = $objIblockElement->Add($arIblockFields);

// if (!$newId) {
//     pr($objIblockElement->LAST_ERROR);
// }


// ORM

// ORM с использованием wakeUp
// wakeUp - метод позволяет без повторного обращения в БД создать объект на основе хранящийся в кэш, сессии или переменной информации об элементе инфоблока и работать с ним через ORM  

/* $iblock = Iblock::wakeUp($iblockId);
$element = $iblock->getEntityDataClass()::getByPrimary(  // get props
	$iblockElementId, 
	['select' => ['NAME', 'PERSON']])
->fetchObject();

$name = $element->get('NAME');
echo 'NAME: ';
pr($name);

$model = $element->get('PERSON')->getIblockElementId();
echo 'PERSON: ';
pr($model); */



// ORM с использованием Element{код инфоблока}Table
// getList - метод позволяет сохранить в переменную коллекцию объектов (элементов инфоблока)
/* $elements = \Bitrix\Iblock\Elements\Elementclientss1Table::getList([ // car - cимвольный код API инфоблока
    'select' => [
        'NAME', 
        'PERSON'
    ], // имя свойства 
])->fetchCollection();

foreach ($elements as $element) {
    pr('NAME - '.$element->getName().' PERSON - '.$element->get('PERSON')->getValue()); 
    // pr('NAME - '.$element->getName()); 
    // pr('MODEL - '.$element->getModel()->getValue()); // получение значения свойства MODEL
} */


/* $elements = \Bitrix\Iblock\Elements\Elementclientss1Table::getList([ // car - cимвольный код API инфоблока
    'select' => ['*'], // имя свойства 
])->fetchAll();

foreach ($elements as $element) {
    // pr('NAME - '.$element->getName().' MODEL - '.$element->get('MODEL')->getValue()); 
    // pr('NAME - '.$element->getName()); 
    // pr('MODEL - '.$element->getModel()->getValue()); // получение значения свойства MODEL

    pr($element);
} */



// query - метод позволяет строить более гибкие и сложные запросы для выборки данных данных через ORM
// получение через метод query списка элементов
/* $elements = \Bitrix\Iblock\Elements\Elementclientss1Table::query() // car - cимвольный код API инфоблока
    ->addSelect('NAME')
    ->addSelect('PERSON') // имя свойства 
    ->addSelect('ID')
    ->fetchCollection();

$items = [];

foreach ($elements as $key => $item) {
    pr($item->getName().' '.$item->getPerson()->getValue()); // получение значения свойства MODEL
    $value = $item->getPerson()->getValue();    
    if($value == 'X5'){
            $item->setPerson('Q7 TEST'); // изменение значения свойства MODEL
            $item->save(); // сохранение данных
    }

    $items[]['NAME'] = $item->getName();
    $items[]['PERSON'] = $item->getPerson()->getValue();
}
pr($items); */
// Получить свойства инфоблока
/*$dbIblockProps = \Bitrix\Iblock\PropertyTable::getList(array(
    'select' => array('*'),
    'filter' => array('IBLOCK_ID' =>$iblockId)
));

while ($arIblockProps = $dbIblockProps->fetch()){ 
    pr($arIblockProps);
}
*/

/*// Получить список элементов инфоблока
$dbItems = \Bitrix\Iblock\ElementTable::getList(array(
    'select' => array('ID', 'NAME', 'IBLOCK_ID'),
    'filter' => array('IBLOCK_ID' => $iblockId)
));
$items = [];
while ($arItem = $dbItems->fetch()){  
    $dbProperty = \CIBlockElement::getProperty(
        $arItem['IBLOCK_ID'],
        $arItem['ID']
    );
    while($arProperty = $dbProperty->Fetch()){  
        $arItem['PROPERTIES'][] = $arProperty;
    }
    $items [] = $arItem;
}
pr($items);
*/

// добавление нового элемента в инфоблок Автомобили
\Bitrix\Main\Loader::IncludeModule("iblock");
$result = \Bitrix\Iblock\Elements\Elementclientss1Table::add(array(
   'NAME' => 'Tikikikikikikik',
   'ACTIVE' => 'Y',
)); 

if ($result->isSuccess()) {
    $id = $result->getId();
    CIBlockElement::SetPropertyValuesEx($id, false, array(
        'PERSON' => 'X5X6',        
        'PHONE'=>'4',
    ));
}


// редактирование элемента в инфоблоке Автомобили
/*\Bitrix\Main\Loader::IncludeModule("iblock");
// делаем запрос на изменение поля NAME в записи (BMW X5) с ID 29
$res = \Bitrix\Iblock\Elements\ElementCarTable::update(99, array(
    'NAME' => 'TEST 777', // Ford Fiesta MK5
)); 
*/

// удаление записи из инфоблока Автомобили
/*\Bitrix\Main\Loader::IncludeModule("iblock");
$res = \Bitrix\Iblock\Elements\ElementCarTable::delete(103);
pr($res);*/
