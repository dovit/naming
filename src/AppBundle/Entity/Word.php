<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Swagger\Annotations as SWG;

/**
 * Word.
 *
 * @SWG\Definition(
 *     definition="Word",
 *     required={"word"},
 *     type="object",
 *     @SWG\Property(property="word", example="Mot")
 * )
 */
class Word extends \Dvc\DictionaryConsumerBundle\Entity\Word
{
}
