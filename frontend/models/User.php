<?php

namespace frontend\models;

use frontend\models\query\CategoryQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users".
 *
 * @property UserCategory[] $userCategories +
 * @property Category[] $categories +
 * @property UserFavorite[] $userFavorites +
 * @property City $city +
 * @property UserProfile $profile +
 * @property string $lastLogin +
 * @property-read bool $isCustomer `true` Если пользвоатель заказчик +
 * @property-read bool $isPerformer `true` Если пользователь исполнитель +
 * @property-read bool $isOnline `true `Если последняя активыность была менее 30 минут
 */
class User extends \common\models\User
{

    /**
     * Query class for table [[categories]]
     *
     * @return CategoryQuery
     */
    public function getCategories(): CategoryQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->via('userCategories');
    }

    /** @return ActiveQuery */
    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(UserCategory::class,  ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UserFavorite::class, ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile(): \yii\db\ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['id' => 'profile_id']);
    }

    /**
     * Является ли пользователь Заказчиком
     * 
     * @return bool
     */
    public function getIsCustomer(): bool
    {
        return empty($this->userCategories);
    }

    /**
     * Является ли пользователь Исполнителем
     *
     * @return bool
     */
    public function getIsPerformer(): bool
    {
        return count($this->userCategories) > 0;
    }

    /** 
     * @return string|null Дата последного входа в систему
     */
    public function getLastLogin(): ?string
    {
        return $this->last_logined_at;
    }

    public function setPassword(string $value)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($value);
    }
}
