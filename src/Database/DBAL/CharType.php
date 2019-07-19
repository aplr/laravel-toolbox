<?php

namespace Aplr\Toolbox\Database\DBAL;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL CHAR to a PHP string.
 */
class CharType extends Type
{
    const TYPE = 'char';
    
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
        return $platform->getCharMaxLength();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return CharType::TYPE;
    }
}
