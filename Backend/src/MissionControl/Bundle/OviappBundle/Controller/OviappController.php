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
use MissionControl\Bundle\OviappBundle\Entity\Furnizor;

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

            $output_array[$id]['id']             = $produs->getId();
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

            $output_array['id']          = $reception->getId();
            $output_array['client']      = $reception->getClient()->getName();
            $output_array['creata_de']   = $reception->getUser();
            $output_array['data_creare'] = $reception->getDateCreated();
            $output_array['produse']     = $reception->getProducts();
        } else {
            $response->setStatusCode(404);
            return $response;
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            //'Role(DEBUG ONLy)' => $user->getRoles(),
            'Reception' => $output_array,
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
     *       {"name"="furnizor_existent",                  "dataType"="text",  "required"=true, "description"="The id of a existing furnizor"},
     *       {"name"="furnizor_nou",                  "dataType"="text",  "required"=true, "description"="The name of a new furnizor"},
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

        $id_furnizor_existent = $request->get('furnizor_existent');
        $string_furnizor_nou  = $request->get('furnizor_nou');

        if ($id_furnizor_existent || $string_furnizor_nou) {
//
//            print_r($id_furnizor_existent);
//            print_r(" <br> ");
//            print_r($string_furnizor_nou);
        } else {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'status' => 'failed',
                'message' => "One of the furnizor fields must be set!",
            )));
            return $response;
        }


        $creator_id = $request->get('creator');
        $produse_id = $request->get('produse');


        $furnizor_existent = $this->getDoctrine()->getRepository('OviappBundle:Furnizor')->find($id_furnizor_existent);

        if ($furnizor_existent) {
            $reception = new Reception();
            $reception->setUser('$client');
            $reception->setClient($furnizor_existent);
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
        } else {

            $furnizor_nou = new Furnizor();
            $furnizor_nou->setName($string_furnizor_nou);
            $furnizor_nou->setAdress('null');
            $furnizor_nou->setPhone('null');
            $em->persist($furnizor_nou);


            $reception = new Reception();
            $reception->setUser('date_user_aici');
            $reception->setClient($furnizor_nou);
            $reception->setProducts('produse_id');
            $reception->setDateCreated('2016-02-02');
            $reception->setDateUpdated('2015-02-02');

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
            'message' => 'Client/Furnizor Input Error',
        )));
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Get all furnizori array data",
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
    public function getFurnizorsAction(Request $request)
    {

        $user = $this->getUser();

        $furnizori = $this->getDoctrine()
                ->getRepository('OviappBundle:Furnizor')->findAll();

        $output_array = array();

        foreach ($furnizori as $furnizor) {

            $id = $furnizor->getId();

            $output_array[$id]['id']     = $furnizor->getId();
            $output_array[$id]['name']   = $furnizor->getName();
            $output_array[$id]['adress'] = $furnizor->getAdress();
            $output_array[$id]['phone']  = $furnizor->getPhone();
        }


        //Instantiate response
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Furnizori' => $output_array,
                )
        ));

        return $response;
    }
}