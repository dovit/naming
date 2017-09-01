<?php

namespace Dvc\DictionaryConsumerBundle\Services;

class Dictionary
{
    private $clientGuzzleDictionary;

    public function __construct($clientGuzzleDictionary)
    {
        $this->clientGuzzleDictionary = $clientGuzzleDictionary;
    }

    public function getWords($dictionary)
    {
        return $this->clientGuzzleDictionary
                        ->get('dictionaries/' . $dictionary . '/words/')
                        ->getBody();
    }
}
