<?php

namespace AppBundle\AMQP\Consumer;

use AppBundle\Entity\OccurrenceDictionary;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class DictionaryLoadedConsumer implements ConsumerInterface
{
    private $clientDictionary;
    private $namingService;
    private $doctrine;

    /**
     * DictionaryLoadedConsumer constructor.
     *
     * @param $clientDictionary
     * @param $namingService
     * @param $doctrine
     */
    public function __construct($clientDictionary, $namingService, $doctrine)
    {
        $this->clientDictionary = $clientDictionary;
        $this->namingService = $namingService;
        $this->doctrine = $doctrine;
    }

    /**
     * @param AMQPMessage $msg
     * @return mixed|void
     */
    public function execute(AMQPMessage $msg)
    {
        $data = json_decode($msg->getBody(), true);
        $page = 1;

        $occurrenceDictionary = new OccurrenceDictionary();
        $occurrenceDictionary->setDictionaryCode($data['code']);
        $occurrenceDictionary->setDictionaryId($data['id']);

        $this->doctrine->getManager()->persist($occurrenceDictionary);

        do
        {
            $words = $this->clientDictionary->getWordsByPage($data['id'], $page);
            echo $page.PHP_EOL;
            foreach ($words as $word)
            {
                $occurrenceDictionary = $this->namingService->processWord($occurrenceDictionary, $word);
            }
            ++$page;
        } while (count($word) !== 0);

        $this->doctrine->getManager()->flush();
    }
}
