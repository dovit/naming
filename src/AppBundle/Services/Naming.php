<?php

namespace AppBundle\Services;

use AppBundle\Entity\Occurrence;
use AppBundle\Entity\OccurrenceDictionary;
use AppBundle\Entity\Word;
use AppBundle\Repository\OccurrenceRepository;
use Doctrine\Common\Collections\Criteria;

class Naming
{
    private $occurrenceRepository;

    public function __construct(occurrenceRepository $repository)
    {
        $this->occurrenceRepository = $repository;
    }

    /**
     * @param OccurrenceDictionary $occurrenceDictionary
     * @param Word $word
     * @return OccurrenceDictionary
     */
    public function processWord(OccurrenceDictionary $occurrenceDictionary, Word $word): OccurrenceDictionary
    {
        $cnt = 0;

        // Search if word already processed
        if ($occurrenceDictionary->getWords()->exists(function ($key, $element) use ($word) {
            return $word->getWord() === $element->getWord();} ))
        {
            return $occurrenceDictionary;
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
        $word->setDictionary($occurrenceDictionary);
        $occurrenceDictionary->getWords()->add($word);
        return $occurrenceDictionary;
    }

    /**
     * Delete a word in occurrence
     */
    public function deleteWord()
    {

    }

    /**
     * Choose next letter
     *
     * @param OccurrenceDictionary $occurrenceDictionary
     * @param $letter
     * @return string
     */
    public function getLetter(OccurrenceDictionary $occurrenceDictionary, $letter)
    {
        $choose = '';

        $occurrences = $this->occurrenceRepository->fetchTopOccurrenceByDictionaryAndLetter(
            $occurrenceDictionary,
            \IntlChar::ord($letter),
            5);

        $key = random_int(0, 4);
        if (isset($occurrences[$key]))
        {
            return \IntlChar::chr($occurrences[$key]->getNextLetter());
        }

        if ($choose === '') {
            return chr(random_int(65,90));
        }
        return $choose;
    }

    /**
     * Generate a word
     *
     * @param OccurrenceDictionary $occurrenceDictionary
     * @param int $lenMinimum
     * @param int $lenMaximum
     * @return string
     */
    public function getWord(OccurrenceDictionary $occurrenceDictionary, int $lenMinimum = 3, int $lenMaximum = 255)
    {
        $len = random_int($lenMinimum, $lenMaximum);
        $word = '';
        $letter = chr(random_int(65,90));

        while (--$len)
        {
            $nextLetter = $this->getLetter($occurrenceDictionary, $letter);
            $word .= $nextLetter;
            $letter = $nextLetter;
        }
        return $word;
    }
}
