<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * OccurrenceDictionary
 */
class OccurrenceDictionary
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $dictionaryCode;

    /**
     * @var ArrayCollection
     */
    private $occurrences;

    /**
     * @var ArrayCollection
     */
    private $words;

    public function __construct()
    {
        $this->occurrences = new ArrayCollection();
        $this->words = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getOccurrences()
    {
        return $this->occurrences;
    }

    /**
     * @param ArrayCollection $occurrences
     */
    public function setOccurrences(ArrayCollection $occurrences)
    {
        $this->occurrences = $occurrences;
    }

    /**
     * @return ArrayCollection
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param ArrayCollection $words
     */
    public function setWords(ArrayCollection $words)
    {
        $this->words = $words;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDictionaryCode(): string
    {
        return $this->dictionaryCode;
    }

    /**
     * @param string $dictionaryCode
     */
    public function setDictionaryCode(string $dictionaryCode)
    {
        $this->dictionaryCode = $dictionaryCode;
    }
}
