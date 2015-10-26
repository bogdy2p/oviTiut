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


class OviappController extends FOSRestController
{

    /**
     * @ApiDoc(
     *    description = "Fetches all produse momentarely",
     *    section="AAA",
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
    public function getProduseAction(Request $request)
    {

        //Instantiate response
        $response = new Response();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            //'Role(DEBUG ONLy)' => $user->getRoles(),
            'Total campaigns for this filter' => count($campaigns_array),
            'Campaigns' => $campaigns_array,
                )
        ));

        return $response;
    }


    /**
     * @ApiDoc(
     *    description = "FetZZZZZZZZchesr this API call.",
     *    section="AAA",
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
     *       ( 0 = All Visible Related Campaigns, 1 = Where User Should Work On, 2 = Campaignstatus (Build,Approved) , 3 = Campaignstatus(Completed,Cancelled) , 4 = Disabled Campaigns (ADMIN Only) "},
     *
     *
     * }
     *
     * )
     * @return array
     * @View()
     */
    public function getTestareAction(Request $request) {


        return "vasile";
    }
}