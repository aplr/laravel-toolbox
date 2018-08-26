<?php

namespace Aplr\Toolbox\Database\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL VARCHAR to a PHP UUID.
 */
class UuidType extends Type
{
    const TYPE = 'uuid';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array_merge($fieldDeclaration, [
            'fixed' => true
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 36;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return UuidType::TYPE;
    }
}