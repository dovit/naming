<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class OccurrenceDictionary
{
    /**
     * @var int
     *
     * @ORM\Column(name="dictionary", type="integer")
     */
    private $dictionary;

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
     * @return int
     */
    public function getDictionary(): int
    {
        return $this->dictionary;
    }

    /**
     * @param int $dictionary
     */
    public function setDictionary(int $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * @return ArrayCollection
     */
    public function getOccurrences(): ArrayCollection
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
    public function getWords(): ArrayCollection
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
}
