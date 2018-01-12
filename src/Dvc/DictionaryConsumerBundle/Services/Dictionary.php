<?php

namespace Dvc\DictionaryConsumerBundle\Services;

use AppBundle\Entity\Word;
use Dvc\DictionaryConsumerBundle\Entity\Dictionary as DictionaryEntity;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
            $res = array_merge($response, $res);
            $cnt = count($response);
            $page++;
        } while ($cnt > 0);

        return $res;
    }

    /**
     * List of word by dictionary
     *
     * @param $dictionary
     * @param $page
     * @return mixed
     */
    public function getWordsByPage($dictionary, $page)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer(), new ArrayDenormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $data = $this->clientGuzzleDictionary
            ->get('dictionaries/' . $dictionary . '/words/',
                [
                    'headers' => [
                        'X-page' => $page,
                        'Authorization' => 'Bearer: +65'
                    ]
                ]);

        return $serializer->deserialize(
            (string)$data->getBody(),
            Word::class.'[]',
            'json',
            ['allow_extra_attributes' => true]
        );
    }

    /**
     * List of dictionaries
     *
     * @return mixed
     */
    public function getDictionaries()
    {
        return $this->clientGuzzleDictionary
            ->get('api/dictionaries/',
                [
                    'headers' => [
                        'Authorization' => 'Bearer: +65'
                    ]
                ]);
    }

    /**
     * Create a dictionary
     *
     * @param $code
     * @return mixed
     */
    public function createDictionary($code)
    {
        return $this->clientGuzzleDictionary
            ->post('api/dictionaries/',
                [
                    'headers' => [
                        'Authorization' => 'Bearer: +65'
                    ],
                    'json' => [
                        'code' => $code
                    ]
                ])
            ->getBody();
    }
}
