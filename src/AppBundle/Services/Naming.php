<?php

namespace AppBundle\Services;

use AppBundle\Entity\Occurrence;
use AppBundle\Entity\OccurrenceDictionary;
use AppBundle\Entity\Word;
use Doctrine\Common\Collections\Criteria;

class Naming
{
    /**
     * @param OccurrenceDictionary $occurrenceDictionary
     * @param Word $word
     * @return bool
     */
    public function processWord(OccurrenceDictionary $occurrenceDictionary, Word $word): bool
    {
        $cnt = 0;

        // Search if word already processed
        if ($occurrenceDictionary->getWords()->exists(function ($key, $element) use ($word) {
            return $word->getWord() === $element->getWord();} ))
        {
            return true;
        }

        $wordArray = str_split($word->getWord());

        while ($cnt < (count($wordArray) - 1))
        {
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('letter', \IntlChar::ord($wordArray[$cnt])))
                ->andWhere(Criteria::expr()->eq('nextLetter', \IntlChar::ord($wordArray[$cnt + 1])))
            ;
            $occurrence = $occurrenceDictionary->getOccurrences()->matching($criteria);
            if (isset($wordArray[1 + $cnt]) && null !== $wordArray[$cnt + 1] && $occurrence->count() === 0) {
                $tmp = new Occurrence();
                $tmp->setDictionary($occurrenceDictionary);
                $tmp->setLetter(\IntlChar::ord(utf8_encode($wordArray[$cnt])));
                $tmp->setNextLetter(\IntlChar::ord(utf8_encode($wordArray[$cnt + 1])));
                $tmp->setValue(1);
                $occurrenceDictionary->getOccurrences()->add($tmp);
            }
            else
            {
                $occurrence->first()->setValue($occurrence->first()->getValue() + 1);
            }
            $cnt++;
        }
        $occurrenceDictionary->getWords()->add($word);
        return true;
    }

    public function deleteWord()
    {

    }
}
