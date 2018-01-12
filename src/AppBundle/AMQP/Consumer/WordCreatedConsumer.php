<?php

namespace AppBundle\AMQP\Consumer;

use AppBundle\Entity\OccurrenceDictionary;
use AppBundle\Entity\Word;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class WordCreatedConsumer implements ConsumerInterface
{
    private $naming;
    private $doctrine;

    public function __construct($naming, $doctrine)
    {
        $this->naming = $naming;
        $this->doctrine = $doctrine;
    }

    public function execute(AMQPMessage $msg)
    {
        $msg = json_decode($msg->getBody(), true);

        $word = new Word(null, $msg['word']);

        $occurrenceDictionary = $this->doctrine
            ->getManager()
            ->getRepository('AppBundle:OccurrenceDictionary')
            ->findOneByDictionaryId($msg['dictionary']['id']);

        if ($occurrenceDictionary === null)
        {
            $occurrenceDictionary = new OccurrenceDictionary();
            $occurrenceDictionary->setDictionaryCode($msg['dictionary']['code']);
            $occurrenceDictionary->setDictionaryId($msg['dictionary']['id']);
        }

        $this->naming->processWord($occurrenceDictionary, $word);
        $this->doctrine->getManager()->persist($occurrenceDictionary);
        $this->doctrine->getManager()->flush();
    }
}
