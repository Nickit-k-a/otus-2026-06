<?php

abstract class AbstractElementCreator
{
    /**
     * Общий метод запуска (одинаковый для всех).
     * Возвращает текст ошибки или null, если всё прошло успешно.
     */
    public function create(array $postData): ?string
    {
        // 1. Проверяем данные (каждый наследник проверяет по-своему)
        $validationError = $this->validate($postData);
        if ($validationError !== null) {
            return $validationError;
        }

        // 2. Собираем массив полей для сохранения
        $fields = $this->prepareFields($postData);

        // 3. Получаем имя ORM-класса (ElementdocTable или ElementProcsTable) и добавляем запись
        $entityClass = $this->getEntityClass();
        $result = $entityClass::add($fields);

        // 4. Обрабатываем результат
        if ($result->isSuccess()) {
            $id = $result->getId();
            
            // Дополнительные действия после создания (например, запись свойств)
            $this->afterSave($id, $postData);

            setFlashMessage('success', $this->getSuccessMessage($id));
            
            global $APPLICATION;
            LocalRedirect($APPLICATION->GetCurPageParam('', ['CODE']));
        }

        return implode(', ', $result->getErrorMessages());
    }

    // --- «ПУСТЫЕ СЛОТЫ» (их обязаны заполнить классы-наследники) ---

    /**
     * Класс D7-модели (DataManager) конкретного инфоблока.
     *
     * @return class-string
     */
    abstract protected function getEntityClass(): string;
    /**
     * Проверка данных формы перед сохранением.
     *
     * @param array $postData Сырые данные формы
     * @return string|null Текст ошибки или null, если данные валидны
     */
    abstract protected function validate(array $postData): ?string;
    /**
     * Подготовка массива полей для ::add().
     *
     * @param array $postData Сырые данные формы
     * @return array Поля элемента инфоблока
     */
    abstract protected function prepareFields(array $postData): array;
    /**
     * Текст сообщения об успешном добавлении.
     *
     * @param int $id ID созданного элемента
     * @return string
     */
    abstract protected function getSuccessMessage(int $id): string;

    // В доктор классе переопределение на привязку множественных процедур к доктору
    protected function afterSave(int $id, array $postData): void
    {
    }
}
