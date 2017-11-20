<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Occurrence
 *
 * @ORM\Table(name="occurrence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OccurrenceRepository")
 */
class Occurrence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="letter", type="integer")
     */
    private $letter;

    /**
     * @var int
     *
     * @ORM\Column(name="next_letter", type="integer")
     */
    private $nextLetter;

    /**
     * @var OccurrenceDictionary
     *
     * @ORM\ManyToOne(targetEntity="OccurrenceDictionary", inversedBy="occurrences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dictionary;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return Occurrence
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getLetter(): int
    {
        return $this->letter;
    }

    /**
     * @param int $letter
     */
    public function setLetter(int $letter)
    {
        $this->letter = $letter;
    }

    /**
     * @return int
     */
    public function getNextLetter(): int
    {
        return $this->nextLetter;
    }

    /**
     * @param int $nextLetter
     */
    public function setNextLetter(int $nextLetter)
    {
        $this->nextLetter = $nextLetter;
    }

    /**
     * @return OccurrenceDictionary
     */
    public function getDictionary(): OccurrenceDictionary
    {
        return $this->dictionary;
    }

    /**
     * @param OccurrenceDictionary $dictionary
     */
    public function setDictionary(OccurrenceDictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }
}
