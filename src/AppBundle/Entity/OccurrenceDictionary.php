<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

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
}
