<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка для exeption");
?>
<ul class="list-group">
    <li class="list-group-item">
         <a href="/homeworks/homework2/view_exception.php">Файл лога</a>
    </li>
</ul>
<?
// ошибка для exeption
$result = 1 / 0;
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
