<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Добавление в лог");

\App\Debug\Log::addLog(
    message: 'Открыта страница writelog.php',
    clear: false,
    fileName: 'log_custom',
    timeVersion: false
);
?>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="/homeworks/homework2/view_log.php">Файл лога</a>,
            в лог добавлено 'Открыта страница writelog.php'
        </li>
    </ul>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>