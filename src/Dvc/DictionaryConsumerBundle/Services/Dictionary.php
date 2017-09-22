<?php

namespace Dvc\DictionaryConsumerBundle\Services;

class Dictionary
{
    private $clientGuzzleDictionary;

    public function __construct($clientGuzzleDictionary)
    {
        $this->clientGuzzleDictionary = $clientGuzzleDictionary;
    }

    /**
     * Get words in dictionary
     *
     * @param $dictionary
     * @return mixed
     */
    public function getWords($dictionary)
    {
        $res = [];
        $page = 1;

        do
        {
            $response = $this->getWordsByPage($dictionary, $page);
            $res = array_merge($res, json_decode($response->getBody(), true));
            $cnt = $response->getHeaders()['X-page-count'][0];
            $page++;
        } while ($page < $cnt);

        return $res;
    }

    public function getWordsByPage($dictionary, $page)
    {
        return $this->clientGuzzleDictionary
            ->get('dictionaries/' . $dictionary . '/words/',
                [
                    'headers' => [
                                    'X-page' => $page,
                                    'Authorization' => 'Bearer: +65'
                                ]
                ]);
    }
}
