<?php

namespace app\Repository;

use App\Dto\DtoModelText;

class RepositoryGptModel
{
    public function getByCode(string $code): bool|DtoModelText
    {
        /** @var DtoModelText[] $modelList */
        $modelList = app()->get('ai.models');

        foreach ($modelList as $model) {
            if ($model->code == $code) {
                return $model;
            }
        }
        return false;
    }

    public function getActive(): bool|array
    {
        /** @var DtoModelText[] $modelList */
        $modelList = app()->get('ai.models');

        foreach ($modelList as $model) {
            if ($model->active) {
                $result[] = $model;
            }
        }
        return $result ?? [];
    }
}
