<?

use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
$APPLICATION->SetTitle("ДЗ #3: Связывание моделей");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

?>
    <h1 class="mb-3"><? $APPLICATION->ShowTitle() ?></h1>

    <h4 class="mb-3">Пояснительная записка</h4>
    <div style="color: red;font-style: italic;">
        Созданы списки докторов и процедур. Добавлена функция в init.php для автоматической генерации символьноого кода докторов, штатный способ инфоблока не заработал.
        <br>Произведена привязка элементов списка процедур к докторам. 
        <br>Создана страница с выводом списка докторов через D7 ORM.
        <br>Был реализован абстрактный класс, который включил в себя создание докторов и процедур c использованием D7 ORM с пост запросами для улучшения структуры кода(общая структура).
    </div>
    <br>
    <br>
    <hr>



    <div class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white">
        Файлы проекта
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item list-group-item-action">
            <a href="/services/lists/18/view/0/"
               class="d-flex justify-content-between align-items-center">
                <span>Список врачей</span>
                <span class="badge bg-primary">Ссылка на просмотр</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action">
            <a href="/services/lists/17/view/0/"
               class="d-flex justify-content-between align-items-center">
                <span>Список процедур</span>
                <span class="badge bg-success">Ссылка на просмотр</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action">
            <a href="/homeworks/homework3/docs.php"
               class="d-flex justify-content-between align-items-center">
                <span>Врачи и процедуры</span>
                <span class="badge bg-secondary">Ссылка на просмотр</span>
            </a>
        </li>

        <li class="list-group-item bg-light text-muted small fw-semibold">
            Просмотр кода основных файлов ДЗ (связь таблиц, ORM и абстрактный класс)
        </li>

        <li class="list-group-item list-group-item-action">
            <a href="/bitrix/admin/fileman_file_view.php?path=%2Fhomeworks%2Fhomework3%2Fdocs.php&amp;site=s1&amp;lang=ru"
               class="d-flex justify-content-between align-items-center">
                <span>docs.php &mdash; страница врачей и процедур</span>
                <span class="badge bg-warning text-dark">файл для просмотра</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action">
            <a href="/bitrix/admin/fileman_file_view.php?path=%2Fhomeworks%2Fhomework3%2Fclasses%2FAbstractElementCreator.php&amp;site=s1&amp;lang=ru"
               class="d-flex justify-content-between align-items-center">
                <span>AbstractElementCreator.php &mdash; абстрактный класс</span>
                <span class="badge bg-info text-dark">файл для просмотра кода</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action">
            <a href="/bitrix/admin/fileman_file_view.php?path=%2Fhomeworks%2Fhomework3%2Fclasses%2FDoctorCreator.php&amp;site=s1&amp;lang=ru"
               class="d-flex justify-content-between align-items-center">
                <span>DoctorCreator.php &mdash; создание доктора (наследник)</span>
                <span class="badge bg-info text-dark">файл для просмотра кода</span>
            </a>
        </li>
        <li class="list-group-item list-group-item-action">
            <a href="/bitrix/admin/fileman_file_view.php?path=%2Fhomeworks%2Fhomework3%2Fclasses%2FProcedureCreator.php&amp;site=s1&amp;lang=ru"
               class="d-flex justify-content-between align-items-center">
                <span>ProcedureCreator.php &mdash; создание процедуры (наследник)</span>
                <span class="badge bg-info text-dark">файл для просмотра кода</span>
            </a>
        </li>
    </ul>
</div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>