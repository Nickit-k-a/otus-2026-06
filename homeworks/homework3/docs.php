<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Iblock\Elements\ElementdocTable;
use Bitrix\Iblock\Elements\ElementProcsTable;

Loader::includeModule('iblock');

/**
 * Подключаем абстрактный класс создания элемента инфоблока и его
 * наследников. Для одного скрипта домашки проще явный require_once,
 * чем настраивать PSR-4 автозагрузку под полноценный модуль.
 * Порядок важен: AbstractElementCreator должен быть подключён раньше
 * классов, которые его расширяют.
 */
require_once __DIR__ . '/classes/AbstractElementCreator.php';
require_once __DIR__ . '/classes/DoctorCreator.php';
require_once __DIR__ . '/classes/ProcedureCreator.php';

/**
 * Подключаем стили страницы отдельным файлом (без инлайн-стилей в разметке).
 * Вызывать SetAdditionalCSS нужно до вывода <head>, поэтому до header.php
 * этот вызов не влияет: подключаем его прямо тут, движок допишет тег
 * в уже открытый <head> при рендере следующего шаблона/компонента.
 * Если тег не появляется (зависит от шаблона), используйте вариант
 * с обычным <link> ниже, в начале тела страницы.
 */
$APPLICATION->SetAdditionalCSS('/homeworks/homework3/docs.css');

$APPLICATION->SetTitle('Доктора');

$request = Application::getInstance()->getContext()->getRequest();

/**
 * Достаёт и сразу удаляет одноразовое сообщение из сессии.
 * Нужно для паттерна Post-Redirect-Get: результат операции
 * сохраняется в сессию перед редиректом и показывается один раз
 * после перехода на чистый GET-адрес.
 *
 * @return array{type: string, text: string}|null
 */
function getFlashMessage(): ?array
{
    if (!empty($_SESSION['DOCS_FLASH'])) {
        $flash = $_SESSION['DOCS_FLASH'];
        unset($_SESSION['DOCS_FLASH']);
        return $flash;
    }

    return null;
}

/**
 * Кладёт одноразовое сообщение в сессию для показа после редиректа.
 * Используется как самой страницей, так и AbstractElementCreator::create()
 * (это глобальная функция, поэтому доступна из любого подключённого файла).
 *
 * @param string $type success|error
 * @param string $text Текст сообщения
 * @return void
 */
function setFlashMessage(string $type, string $text): void
{
    $_SESSION['DOCS_FLASH'] = [
        'type' => $type,
        'text' => $text,
    ];
}

$formErrors = [];

// 1. Обработка отправки обеих форм (только POST + проверка CSRF-токена)
if ($request->isPost() && check_bitrix_sessid()) {
    $action = (string)$request->getPost('ACTION');
    $postData = $request->getPostList()->toArray();

    // Добавление доктора — вся логика (валидация, подготовка полей,
    // сохранение, привязка процедур, флеш-сообщение, редирект) теперь
    // внутри DoctorCreator::create(), унаследованного от
    // AbstractElementCreator. Сюда возвращается только текст ошибки,
    // если что-то пошло не так, либо null при успехе (но при успехе
    // create() сам делает редирект и выполнение сюда не дойдёт).
    if ($action === 'ADD_DOCTOR') {
        $error = (new DoctorCreator())->create($postData);
        if ($error !== null) {
            $formErrors['doctor'] = $error;
        }
    }

    // Добавление процедуры — та же абстракция, другой наследник.
    if ($action === 'ADD_PROC') {
        $error = (new ProcedureCreator())->create($postData);
        if ($error !== null) {
            $formErrors['proc'] = $error;
        }
    }
}

$flash = getFlashMessage();

// Проверяем, передан ли символьный код врача в URL (?CODE=...)
$doctorCode = trim((string)$request->get('CODE'));

if ($doctorCode !== ''):
    // ==========================================
    // РЕЖИМ 1: ДЕТАЛЬНАЯ СТРАНИЦА ВРАЧА
    // ==========================================
    $doctor = ElementdocTable::getList([
        'select' => [
            'ID',
            'NAME',
            'CODE',
            'PROCS.ELEMENT.NAME',
        ],
        'filter' => [
            '=ACTIVE' => 'Y',
            '=CODE' => $doctorCode,
        ],
    ])->fetchObject();
?>
    <div class="docs-back-link">
        <a href="/homeworks/homework3/docs.php">&larr; Вернуться к списку врачей</a>
    </div>

    <?php if ($doctor): ?>
        <?php $APPLICATION->SetTitle($doctor->getName()); ?>
        <h2 class="docs-doctor-name"><?= htmlspecialcharsbx($doctor->getName()) ?></h2>

        <h3>Процедуры, которые проводит врач:</h3>
        <?php
        $docProcs = $doctor->getProcs();
        if ($docProcs && count($docProcs) > 0):
        ?>
            <ul class="docs-proc-list">
                <?php foreach ($docProcs as $propValue): ?>
                    <?php if ($propValue->getElement()): ?>
                        <li><?= htmlspecialcharsbx($propValue->getElement()->getName()) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="docs-muted">У этого врача пока не указаны процедуры.</p>
        <?php endif; ?>
    <?php else: ?>
        <?php $APPLICATION->SetTitle('Врач не найден'); ?>
        <p class="docs-error-text">Врач с таким символьным кодом не найден.</p>
    <?php endif; ?>

<?php else:
    // ==========================================
    // РЕЖИМ 2: ОБЩИЙ СПИСОК ВРАЧЕЙ И КНОПКИ
    // ==========================================
    $procedures = ElementProcsTable::getList([
        'select' => ['ID', 'NAME'],
        'filter' => ['=ACTIVE' => 'Y'],
    ])->fetchAll();

    $doctors = ElementdocTable::getList([
        'select' => ['ID', 'NAME', 'CODE'],
        'filter' => ['=ACTIVE' => 'Y'],
    ])->fetchCollection();
?>
    <?php if ($flash): ?>
        <p class="docs-message docs-message--<?= htmlspecialcharsbx($flash['type']) ?>">
            <?= htmlspecialcharsbx($flash['text']) ?>
        </p>
    <?php endif; ?>

    <!-- Кнопки открытия окон -->
    <div class="docs-actions">
        <button type="button" class="docs-btn" onclick="document.getElementById('add-doctor-modal').showModal()">
            + Добавить доктора
        </button>

        <button type="button" class="docs-btn" onclick="document.getElementById('add-proc-modal').showModal()">
            + Добавить процедуру
        </button>
    </div>

    <!-- Простой список врачей со ссылками на их символьный код -->
    <h3>Список врачей:</h3>
    <ul class="docs-doctor-list">
        <?php foreach ($doctors as $doctor): ?>
            <li>
                <a href="?CODE=<?= htmlspecialcharsbx($doctor->getCode()) ?>">
                    <?= htmlspecialcharsbx($doctor->getName()) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Модальное окно: Новый доктор -->
    <dialog id="add-doctor-modal" class="docs-modal">
        <form method="POST">
            <?= bitrix_sessid_post() ?>
            <input type="hidden" name="ACTION" value="ADD_DOCTOR">
            <h2 class="docs-modal-title">Новый доктор</h2>

            <?php if (!empty($formErrors['doctor'])): ?>
                <p class="docs-error-text"><?= htmlspecialcharsbx($formErrors['doctor']) ?></p>
            <?php endif; ?>

            <div class="docs-field">
                <label class="docs-label">ФИО доктора:</label>
                <input type="text" name="DOCTOR_NAME" required placeholder="Например: Иванов Иван Иванович" class="docs-input">
            </div>

            <div class="docs-field docs-field--last">
                <label class="docs-label">Процедуры (удерживайте Ctrl для выбора нескольких):</label>
                <select name="PROCS[]" multiple size="10" class="docs-select">
                    <?php foreach ($procedures as $proc): ?>
                        <option value="<?= (int)$proc['ID'] ?>">
                            <?= htmlspecialcharsbx($proc['NAME']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="docs-modal-footer">
                <button type="button" class="docs-btn docs-btn--secondary" onclick="document.getElementById('add-doctor-modal').close()">
                    Отмена
                </button>
                <button type="submit" class="docs-btn docs-btn--primary">
                    Сохранить
                </button>
            </div>
        </form>
    </dialog>

    <!-- Модальное окно: Новая процедура -->
    <dialog id="add-proc-modal" class="docs-modal docs-modal--small">
        <form method="POST">
            <?= bitrix_sessid_post() ?>
            <input type="hidden" name="ACTION" value="ADD_PROC">
            <h2 class="docs-modal-title">Новая процедура</h2>

            <?php if (!empty($formErrors['proc'])): ?>
                <p class="docs-error-text"><?= htmlspecialcharsbx($formErrors['proc']) ?></p>
            <?php endif; ?>

            <div class="docs-field docs-field--last">
                <label class="docs-label">Название процедуры:</label>
                <input type="text" name="PROC_NAME" required placeholder="Например: УЗИ брюшной полости" class="docs-input">
            </div>

            <div class="docs-modal-footer">
                <button type="button" class="docs-btn docs-btn--secondary" onclick="document.getElementById('add-proc-modal').close()">
                    Отмена
                </button>
                <button type="submit" class="docs-btn docs-btn--primary">
                    Сохранить
                </button>
            </div>
        </form>
    </dialog>
<?php endif; ?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>