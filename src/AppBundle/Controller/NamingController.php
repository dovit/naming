<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Occurrence;
use AppBundle\Entity\OccurrenceDictionary;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\HttpCacheBundle\Http\SymfonyResponseTagger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Doctrine\Common\Collections\Criteria;

/**
 *
 * Class NamingController
 *
 */
class NamingController extends FOSRestController
{
    /**
     * @SWG\Get(
     *     description="Generate a word",
     *     path="/naming/{dictionary}/",
     *     tags={"naming"},
     *     @SWG\Parameter(
     *       name="dictionary",
     *       in="path",
     *       required=true,
     *       type="integer",
     *       description="dictionary id"
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming/{dictionary}/", name="naming")
     *
     * @Method({"GET"})
     *
     */
    public function getAction()
    {
        return $this->handleView($this->view(['test' => 2], Response::HTTP_OK));
    }

    /**
     * @SWG\Get(
     *     description="Get list of dictionary",
     *     path="/naming",
     *     tags={"naming"},
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming", name="naming")
     *
     * @Method({"GET"})
     *
     */
    public function getDictionaryAction()
    {
        return $this->handleView($this->view(['test' => 2], Response::HTTP_OK));
    }

    /**
     * @SWG\Post(
     *     description="Generate stats",
     *     path="/naming",
     *     tags={"naming"},
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming", name="naming_generate_occurrence")
     *
     * @Method({"POST"})
     */
    public function generateTableOccurrenceAction()
    {
        $words = ['test', 'table', 'tableau', 'test'];

        $occurrenceDictionary = new OccurrenceDictionary();
        $occurrenceDictionary->setDictionary(1);

        foreach ($words as $word)
        {
            $this->get('naming')->processWord($occurrenceDictionary, $word);
        }

        return $this->handleView($this->view($occurrenceDictionary, Response::HTTP_OK));
    }
}
