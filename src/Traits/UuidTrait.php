<?php

namespace Aplr\Toolbox\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public static function bootUuidTrait()
    {
        self::creating(function ($model) {
            $keyName = $model->getKeyName();

            if (!isset($model->{$keyName}) || empty($model->{$keyName})) {
                $model->{$keyName} = Uuid::uuid4()->toString();
            }
        });
    }
}
