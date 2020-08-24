<?php
namespace app\components;

use app\exceptions\base\NotFoundPropertyExceptions;
use app\faker\AbstractFakeModel;

class FakeRelations
{

    /**
     * Заполняет $mainModels связанными данными.
     *
     * @param array $mainModels
     * @param array $relatedModels
     * @param array $modelKeys [ mainModelKey => relationModelKey]
     * @param string|null $relationName
     * @return array $models Обновленная версия $mainModel
     * @throws NotFoundPropertyExceptions Если нет свойтсва в классе
     */
    public function setRelation(array $mainModels, array $relatedModels, array $modelKeys, ?string $relationName = null): array
    {
        /** @var AbstractFakeModel $mainModel */
        foreach ($mainModels as $mainModel) {
            $relatedIndex = random_int(0, (count($relatedModels) - 1));
            $relatedModel = $relatedModels[$relatedIndex];
            foreach ($modelKeys as $mainModelKey => $relatedModelKey) {
                if (!property_exists($mainModel, $mainModelKey) || $mainModelKey === '') {
                    throw new NotFoundPropertyExceptions($mainModelKey, $mainModel::className());
                }
                if (!property_exists($relatedModel, $relatedModelKey) || $relatedModelKey === 'null') {
                    throw new NotFoundPropertyExceptions($relatedModelKey, $relatedModel::className());
                }
                $mainModel->$mainModelKey = $relatedModel->$relatedModelKey;
                if (!is_null($relationName)) {
                    $mainModel->addRelation($relationName, $relatedModel);
                }
            }
        }

        return $mainModels;
    }

    public function mergeWith(array $mainModels, array $relatedModels): array
    {
        // /** @var AbstractFakeModel $mainModels */
        for ($i=0; $i<count($mainModels); $i++) {
            $mainModels[$i]->setAttributes($relatedModels[$i]->getAttributes());
        }

        return $mainModels;
    }
}
