<?php

namespace AppBundle\Serializer\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class WordDictionaryApiToOccurrenceDictionaryNameConverter implements NameConverterInterface
{
    /**
     * Converts a property name to its normalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function normalize($propertyName)
    {
        return $propertyName;
    }

    /**
     * Converts a property name to its denormalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function denormalize($propertyName)
    {
        var_dump($propertyName);

        if ($propertyName === 'id')
        {
            return 'dictionary_id';
        }
        if ($propertyName === 'code')
        {
            return 'dictionary_code';
        }
        return $propertyName;
    }
}
