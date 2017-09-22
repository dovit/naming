<?php

namespace AppBundle\AMQP\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class WordCreatedConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        $msg = json_decode($msg->getBody(), true);

        var_dump($msg);
    }
}
