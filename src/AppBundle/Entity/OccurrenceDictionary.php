<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Swagger\Annotations as SWG;

/**
 * OccurrenceDictionary
 *
 * @SWG\Definition(
 *     definition="OccurrenceDictionary",
 *     required={"dictionaryCode"},
 *     type="object"
 * )
 */
class OccurrenceDictionary
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     *
     * @SWG\Property(property="dictionary_code", example="DICTIONARY-FR0001")
     */
    private $dictionaryCode;

    /**
     * @var string
     */
    private $dictionaryId;

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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
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

    /**
     * @return string
     */
    public function getDictionaryId(): string
    {
        return $this->dictionaryId;
    }

    /**
     * @param string $dictionaryId
     */
    public function setDictionaryId(string $dictionaryId)
    {
        $this->dictionaryId = $dictionaryId;
    }
}
