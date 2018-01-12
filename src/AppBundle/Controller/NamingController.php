<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Occurrence;
use AppBundle\Entity\OccurrenceDictionary;
use AppBundle\Entity\Word;
use Dvc\DictionaryConsumerBundle\Entity\Dictionary;
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
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * Class NamingController
 *
 */
class NamingController extends FOSRestController
{
    /**
     * @SWG\Get(
     *     description="Get occurrence letter",
     *     path="/naming/occurrences/{id}",
     *     tags={"occurrence"},
     *     @SWG\Parameter(
     *      in="path",
     *      type="string",
     *      name="id"
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming/occurrences/{id}",
     *     requirements={"id": "[a-zA-Z0-9-]+"},
     *     name="naming_get_table_occurrence"
     * )
     *
     * @Method({"GET"})
     */
    public function getTableOccurrenceAction($id)
    {
        $result = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:OccurrenceDictionary')
            ->findById($id);
        return $this->handleView($this->view($result, Response::HTTP_OK));
    }

    /**
     * @SWG\Get(
     *     description="Get occurrence letter",
     *     path="/naming/occurrences/",
     *     tags={"occurrence"},
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming/occurrences/", name="naming_get_all_table_occurrence")
     *
     * @Method({"GET"})
     */
    public function getAllTableOccurrenceAction()
    {
        $result = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:OccurrenceDictionary')
            ->findAll();
        return $this->handleView($this->view($result, Response::HTTP_OK));
    }

    /**
     * @SWG\Put(
     *     description="Process word into occurrence",
     *     path="/naming/occurrences/{id}/words/",
     *     tags={"occurrence"},
     *     @SWG\Parameter(
     *      in="path",
     *      type="string",
     *      name="id",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *       name="word",
     *       in="body",
     *       required=true,
     *       type="string",
     *       description="word",
     *       @SWG\Schema(
     *          ref="#/definitions/Word"
     *       )
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming/occurrences/{id}/words/"
     *          , requirements={"id": "[a-zA-Z0-9-]+"}
     *          , name="naming_process_a_word_in_occurrence")
     *
     * @Method({"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     * @internal param Word $word
     */
    public function processWordAction($id, Request $request)
    {
        $occurrenceDictionary = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:OccurrenceDictionary')
            ->findOneById($id);

        $word = new Word(null, $request->get('word'));
        $this->get('naming')->processWord($occurrenceDictionary, $word);

        $this->getDoctrine()->getManager()->persist($occurrenceDictionary);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($occurrenceDictionary, Response::HTTP_OK));
    }

    /**
     * @SWG\Delete(
     *     description="Delete word into occurrence",
     *     path="/naming/occurrences/{id}/words/",
     *     tags={"occurrence"},
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @View()
     *
     * @Route("/naming/occurrences/{id}/words/"
     *          , requirements={"id": "[a-zA-Z0-9-]+"}
     *          , name="naming_process_word_in_occurrence")
     *
     * @Method({"DELETE"})
     */
    public function deleteWordAction()
    {

    }

    /**
     * @SWG\Post(
     *     description="Create new occurrence",
     *     path="/naming/occurrence/",
     *     tags={"occurrence"},
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      ),
     *     @SWG\Parameter(
     *      in="body",
     *      type="string",
     *      name="OccurrenceDictionary",
     *      required=true,
     *      @SWG\Schema(
     *         ref="#/definitions/OccurrenceDictionary"
     *      )
     *     )
     * )
     *
     * @View()
     *
     * @Route("/naming/occurrence/", name="naming_create_occurrence")
     *
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function createOccurrenceAction(Request $request)
    {
        $occurrenceDictionary = new OccurrenceDictionary();
        $occurrenceDictionary->setDictionaryCode($request->get('dictionary_code'));

        $serviceDictionary = $this->get('dictionary');
        $dictionary = $serviceDictionary->createDictionary($request->get('dictionary_code'));

        $dictionary = json_decode($dictionary, true);
        $occurrenceDictionary->setDictionaryId($dictionary['id']);

        $this->getDoctrine()->getManager()->persist($occurrenceDictionary);
        $this->getDoctrine()->getManager()->flush();

        return $this->handleView($this->view($occurrenceDictionary, Response::HTTP_OK));
    }

    /**
     * @SWG\Get(
     *     description="Generate a word",
     *     path="/naming/occurrences/{occurrence_id}/",
     *     tags={"naming"},
     *     @SWG\Parameter(
     *      in="path",
     *      type="string",
     *      name="occurrence_id",
     *      required=true
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Test"
     *      )
     * )
     *
     * @Route("/naming/occurrences/{occurence_id}/", name="naming_create_word")
     */
    public function createWordAction($occurence_id)
    {
        $service = $this->get('naming');

        $result = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:OccurrenceDictionary')
            ->findOneById($occurence_id);

        $result = $service->getWord($result);
        return $this->handleView($this->view($result, Response::HTTP_OK));
    }
}
