<?
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("ДЗ #1: Создание и настройка проекта в VScode");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');


?>
<h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

<h4 class="mb-3">Пояснительная записка</h4>
    <div style="background-color: #fdf2f2; border-left: 4px solid #de350b; color: #de350b; padding: 15px; margin-bottom: 20px; font-family: sans-serif; border-radius: 4px;">
    <strong>Выполненные работы:</strong> Настройка проекта в VS Code, создание <code>.gitignore</code> и конфигурация <code>composer.json</code>. Проведено тестовое использование var-dumper и разработан класс-помощник для поиска данных инфоблоков. Зафиксированы первые коммиты в репозитории.
</div>

<div style="font-family: sans-serif; display: flex; flex-direction: column; gap: 10px;">
    <div>
        📌 <a href="https://github.com/Nickit-k-a/otus-2026-06" style="color: #0052cc; text-decoration: none; font-weight: 500;">Ссылка на GitHub</a>
    </div>   
    <div>
        🔍 <a href="https://ci114459.tw1.ru/var-dumper-demo.php" style="color: #0052cc; text-decoration: none; font-weight: 500;">Ссылка на Var-Dumper</a>
    </div>   
    <div>
        ⚙️ <a href="https://ci114459.tw1.ru/bitrix/admin/fileman_file_view.php?path=%2Fvar-dumper-demo.php&site=s1&lang=ru" style="color: #0052cc; text-decoration: none; font-weight: 500;">Ссылка на код из административной части</a>
    </div>
    <div>
        📄 <a href="https://ci114459.tw1.ru/iblock-helper-demo.php" style="color: #0052cc; text-decoration: none; font-weight: 500;">Ссылка на страницу с хелпером</a>
    </div>   
    <div>
        ⚙️ <a href="https://ci114459.tw1.ru/bitrix/admin/fileman_file_view.php?lang=ru&site=s1&path=%2Fvar-dumper-demo.php" style="color: #0052cc; text-decoration: none; font-weight: 500;">Ссылка на код из административной части</a>
    </div>
</div>


<br>
<br>
<hr>




<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>