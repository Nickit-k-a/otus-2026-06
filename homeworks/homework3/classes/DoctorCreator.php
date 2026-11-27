<?php
use Bitrix\Iblock\Elements\ElementdocTable;

class DoctorCreator extends AbstractElementCreator
{
    protected function getEntityClass(): string
    {
        return ElementdocTable::class;
    }

    protected function validate(array $postData): ?string
    {
        $name = trim((string)($postData['DOCTOR_NAME'] ?? ''));
        return $name === '' ? 'Укажите ФИО доктора.' : null;
    }

    protected function prepareFields(array $postData): array
    {
        $name = trim((string)$postData['DOCTOR_NAME']);
        $code = \CUtil::translit($name, 'ru', [
            'replace_space' => '-',
            'replace_other' => '-',
        ]);

        return [
            'NAME' => $name,
            'CODE' => $code,
            'ACTIVE' => 'Y',
        ];
    }

    protected function afterSave(int $id, array $postData): void
    {
        $procIds = array_filter((array)($postData['PROCS'] ?? []));
        if (!empty($procIds)) {
            \CIBlockElement::SetPropertyValuesEx($id, false, [
                'PROCS' => $procIds,
            ]);
        }
    }

    protected function getSuccessMessage(int $id): string
    {
        return 'Доктор успешно добавлен (ID: ' . $id . ').';
    }
}
