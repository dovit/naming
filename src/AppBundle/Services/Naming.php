<?php

namespace AppBundle\Services;

use AppBundle\Entity\Occurrence;
use AppBundle\Entity\OccurrenceDictionary;
use Doctrine\Common\Collections\Criteria;

class Naming
{
    /**
     *
     * @param OccurrenceDictionary $occurrenceDictionary
     * @param string $word
     * @return bool
     */
    public function processWord(OccurrenceDictionary $occurrenceDictionary, string $word)
    {
        $cnt = 0;

        // Search if word already processed
        if ($occurrenceDictionary->getWords()->contains($word))
        {
            return true;
        }

        $occurrenceDictionary->getWords()->add(utf8_encode($word));
        $word = str_split($word);

        while ($cnt < (count($word) - 1))
        {
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq("letter", \IntlChar::ord($word[$cnt])))
                ->andWhere(Criteria::expr()->eq("nextLetter", \IntlChar::ord($word[$cnt + 1])))
            ;
            $occurrence = $occurrenceDictionary->getOccurrences()->matching($criteria);
            if ($occurrence->count() == 0 && isset($word[$cnt + 1]) && !is_null($word[$cnt + 1])) {
                $tmp = new Occurrence();
                $tmp->setLetter(\IntlChar::ord(utf8_encode($word[$cnt])));
                $tmp->setNextLetter(\IntlChar::ord(utf8_encode($word[$cnt + 1])));
                $tmp->setValue(1);
                $occurrenceDictionary->getOccurrences()->add($tmp);
            }
            else
            {
                $occurrence->first()->setValue($occurrence->first()->getValue() + 1);
            }
            $cnt++;
        }
        return true;
    }
}
