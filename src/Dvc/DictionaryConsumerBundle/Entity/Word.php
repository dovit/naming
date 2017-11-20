<?php

namespace Dvc\DictionaryConsumerBundle\Entity;

/**
 * Word.
 */
class Word
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $word;

    protected $dictionary;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set word.
     *
     * @param string $word
     *
     * @return Word
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word.
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @return mixed
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * @param mixed $dictionary
     */
    public function setDictionary($dictionary)
    {
        $this->dictionary = $dictionary;
    }
}
