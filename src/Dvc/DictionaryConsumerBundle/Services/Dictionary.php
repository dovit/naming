<?php

namespace Dvc\DictionaryConsumerBundle\Services;

class Dictionary
{
    public function get()
    {
        $res = [];

        $dictionary = new \Dvc\DictionaryConsumerBundle\Entity\Dictionary();
        $dictionary->setCode('fr');
        $dictionary->setId(1);
        $res[] = $dictionary;
        return $res;
    }
}
