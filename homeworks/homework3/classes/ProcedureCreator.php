<?php
use Bitrix\Iblock\Elements\ElementProcsTable;

class ProcedureCreator extends AbstractElementCreator
{
    protected function getEntityClass(): string
    {
        return ElementProcsTable::class;
    }

    protected function validate(array $postData): ?string
    {
        $name = trim((string)($postData['PROC_NAME'] ?? ''));
        return $name === '' ? 'Укажите название процедуры.' : null;
    }

    protected function prepareFields(array $postData): array
    {
        return [
            'NAME' => trim((string)$postData['PROC_NAME']),
            'ACTIVE' => 'Y',
        ];
    }

    protected function getSuccessMessage(int $id): string
    {
        return 'Процедура успешно добавлена (ID: ' . $id . ').';
    }
}
