<?php

namespace MissionControl\Bundle\OviappBundle\Controller;

use MissionControl\Bundle\CampaignBundle\Model\FileType;
use MissionControl\Bundle\UserBundle\Entity\User;
use MissionControl\Bundle\TaskBundle\Entity\Task;
use MissionControl\Bundle\TaskBundle\Entity\Taskmessage;
use MissionControl\Bundle\TaskBundle\Entity\Taskstatus;
use MissionControl\Bundle\CampaignBundle\Entity\Teammember;
use MissionControl\Bundle\CampaignBundle\Entity\Campaign;
use MissionControl\Bundle\CampaignBundle\Entity\Brand;
use MissionControl\Bundle\CampaignBundle\Entity\Client;
use MissionControl\Bundle\CampaignBundle\Entity\Country;
use MissionControl\Bundle\CampaignBundle\Entity\Product;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\File\File;
use JMS\Serializer\SerializationContext;
use MissionControl\Bundle\OviappBundle\Entity\Produs;
use MissionControl\Bundle\OviappBundle\Entity\Reception;

class OviappController extends FOSRestController
{

    public function timezoneUTC()
    {
        return new \DateTimeZone('UTC');
    }

    /**
     * @ApiDoc(
     *    description = "Fetches all produse momentarely",
     *    section="A_Products",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     400 = "This call is only for administrators.",
     *     403 = "Invalid API KEY",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name" = "_format","requirement" = "json|xml"}
     *    },
     *  parameters={
     *       {"name"="filter",  "dataType"="integer","required"=false,"description"="Default filter is 0
     *       ( , 3 = Campaignstatus(Completed,Cancelled) , 4 = Disabled Campaigns (ADMIN Only) "},
     *
     *
     * }
     *
     * )
     * @return array
     * @View()
     */
    public function getProductsAction(Request $request)
    {

        $user = $this->getUser();

        $produse = $this->getDoctrine()
                ->getRepository('OviappBundle:Produs')->findAll();

        $output_array = array();

        foreach ($produse as $produs) {

            $id = $produs->getId();

            $output_array[$id]['nume']           = $produs->getNume();
            $output_array[$id]['pret']           = $produs->getPretLivrare();
            $output_array[$id]['cantitate']      = $produs->getCantitate();
            $output_array[$id]['unitate_masura'] = $produs->getUnitateMasura();
        }


        //Instantiate response
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Produse' => $output_array,
                )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Fetches One Produs Momentarely",
     *    section="A_Products",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name" = "_format","requirement" = "json|xml"}
     *    },
     *
     * )
     * @return array
     * @View()
     */
    public function getProductAction($product_id)
    {

        $user     = $this->getUser();
        //Instantiate response
        $response = new Response();


        $produs = $this->getDoctrine()
                ->getRepository('OviappBundle:Produs')->findOneById($product_id);

        $output_array = array();

        if ($produs) {
            $id = $produs->getId();

            $output_array[$id]['nume']           = $produs->getNume();
            $output_array[$id]['pret']           = $produs->getPretLivrare();
            $output_array[$id]['cantitate']      = $produs->getCantitate();
            $output_array[$id]['unitate_masura'] = $produs->getUnitateMasura();
        } else {
            $response->setStatusCode(404);
            return $response;
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            //'Role(DEBUG ONLy)' => $user->getRoles(),
            'Produse' => $output_array,
                )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Get all receptions unfiltered.",
     *    section="B_Receptii",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     400 = "This call is only for administrators.",
     *     403 = "Invalid API KEY",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name" = "_format","requirement" = "json|xml"}
     *    },
     *  parameters={
     *       {"name"="filter",  "dataType"="integer","required"=false,"description"="Default filter is 0
     *       ( , 3 = Campaignstatus(Completed,Cancelled) , 4 = Disabled Campaigns (ADMIN Only) "},
     *
     *
     * }
     *
     * )
     * @return array
     * @View()
     */
    public function getReceptionsAction(Request $request)
    {
        $user       = $this->getUser();
        $receptions = $this->getDoctrine()
                ->getRepository('OviappBundle:Reception')->findAll();

        $output_array = array();

        foreach ($receptions as $reception) {

            $id = $reception->getId();

            $output_array[$id]['id']          = $reception->getId();
            $output_array[$id]['client']      = $reception->getClient();
            $output_array[$id]['creata_de']   = $reception->getUser();
            $output_array[$id]['data_creare'] = $reception->getDateCreated();
            $output_array[$id]['produse']     = $reception->getProducts();
        }

        //Instantiate response
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Receptions' => $output_array,
                )
        ));
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Get One Reception by ID",
     *    section="B_Receptii",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name" = "_format","requirement" = "json|xml"}
     *    },
     *
     * )
     * @return array
     * @View()
     */
    public function getReceptionAction($reception_id)
    {

        $user     = $this->getUser();
        //Instantiate response
        $response = new Response();


        $reception = $this->getDoctrine()->getRepository('OviappBundle:Reception')->findOneById($reception_id);

        $output_array = array();

        if ($reception) {
            $id = $reception->getId();

            $output_array[$id]['id']          = $reception->getId();
            $output_array[$id]['client']      = $reception->getClient();
            $output_array[$id]['creata_de']   = $reception->getUser();
            $output_array[$id]['data_creare'] = $reception->getDateCreated();
            $output_array[$id]['produse']     = $reception->getProducts();
        } else {
            $response->setStatusCode(404);
            return $response;
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            //'Role(DEBUG ONLy)' => $user->getRoles(),
            'Receptie' => $output_array,
                )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Creates and saves a new reception.",
     *    section="A_POST_RECEPTION",
     *    statusCodes = {
     *     201 = "Returned when the reception was added to the database",
     *     400 = "Returned when the validation returns false ",
     *     403 = {"Invalid API KEY", "Incorrect combination of request inputs."},
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="_format",               "dataType"="string","requirement"="json|xml","description"="Format"},
     *    },
     *    parameters={
     *       {"name"="client",                  "dataType"="text",  "required"=true, "description"="The reception client"},
     *       {"name"="creator",                "dataType"="string","required"=true,"description"="The reception creator."},
     *       {"name"="produse",                 "dataType"="string","required"=true,"description"="The reception products."},
     * }
     * )
     * return string
     * @View()
     */
    public function postReceptionAction(Request $request)
    {
        $user     = $this->getUser();
        $response = new Response();

        $creationDate = new \DateTime();
        $creationDate->setTimezone(self::timezoneUTC());

        $em = $this->getDoctrine()->getManager();

        $key       = Uuid::uuid4()->toString();
        $token_key = Uuid::uuid4()->toString();

        $client_id  = $request->get('client');
        $creator_id = $request->get('creator');
        $produse_id = $request->get('produse');


        $client = $this->getDoctrine()->getRepository('OviappBundle:Furnizor')->find($client_id);

        if ($client) {

            $reception = new Reception();
            $reception->setUser('$client');
            $reception->setClient($client);
            
            $reception->setProducts('produse_id');
            $reception->setDateCreated('2012-02-02');
            $reception->setDateUpdated('2014-02-02');

            $em->persist($reception);
            $em->flush();

            $response->setStatusCode(201);
            $response->setContent(json_encode(array(
                'success' => true,
                'ReceptionId' => $reception->getId(),
                ))
            );

            return $response;
        }
        $response->setStatusCode(404);
        $response->setContent(json_encode(array(
            'success' => false,
            'message' => 'Client/Furnizor not found for the specific input',
        )));
        return $response;
        }
    }
