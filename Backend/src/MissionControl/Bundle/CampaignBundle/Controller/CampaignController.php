<?php

namespace MissionControl\Bundle\CampaignBundle\Controller;

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

class CampaignController extends FOSRestController {

    public function timezoneUTC() {
        return new \DateTimeZone('UTC');
    }

    /**
     * @ApiDoc(
     *    description = "ZZZFetches all campaigns that the user is permitted to view. The content on My Dashboard requires filter=1 for this API call.",
     *    section="Z_DISABLED",
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
    public function getCampaignsAction(Request $request) {

//        //Instantiate response
//        $response = new Response();
//        $all_campaigns_ids_array = array();
//        //Validate the user
//        $user = $this->getUser();
//        $current_date_object = new \DateTime();
//        $filters = $request->get('filter') ? $request->get('filter') : 0;
//
//
//        $array_of_campaign_ids = array();
////
//        switch ($filters) {
//            case 0:
//                //
//                ////RETURN ALL THE CAMPAIGNS WHERE ALLOWED TO SEE. //If user is admin , he can see EVERY VISIBLE CAMPAIGN.
//                //
//                if ($user->hasRole('ROLE_ADMINISTRATOR')) {
//
//                    //If the user is administrator , fetch all the campaign id's availlable in the database
//                    $campaigns = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//                    foreach ($campaigns as $campaign) {
//                        $array_of_campaign_ids[] = $campaign->getId();
//                    }
//                } elseif ($user->hasRole('ROLE_CONTRIBUTOR')) {
//                    $campaign_ids = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAllVisible();
//                    foreach ($campaign_ids as $campaign_id) {
//                        $array_of_campaign_ids[] = $campaign_id;
//                    }
//                } elseif ($user->hasRole('ROLE_VIEWER')) {
////           THIS IS THE CASE WHEN THE USER IS ONLY VIEWER
//                    $array_of_campaign_ids = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAllVisibleCampaignsForAViewer();
//                } else {
//                    die('This errror will never happen.');
//                }
//                break;
//
//            case 1:
//                //
//                //RETURN ALL THE CAMPAIGNS WHERE USER NEEDS TO WORK ON.
//                //Requirements:
//                //-return all campaigns in BUILD || APPROVED status && Where the user is a team member of that campaign.
//
//                $campaigns_where_user_is_reviewer = array();
//                $campaigns_where_user_is_teammember = array();
//                $displayable_campaigns = array();
//                $teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findByMember($user);
//
//                if ($teammembers) {
//
//                    foreach ($teammembers as $teammember_entry) {
//
//                        $campaigns_where_user_is_teammember[] = $teammember_entry->getCampaign();
//                    }
//
//                    //print_r($campaigns_where_user_is_teammember);
////                    die('dead @ line 120');
//                    foreach ($campaigns_where_user_is_teammember as $campaign_where_teammember) {
//                        if ($campaign_where_teammember->getNotVisible() == false) {
//                            if (($campaign_where_teammember->getCampaignstatus()->getName() == "Build") || ($campaign_where_teammember->getCampaignstatus()->getName() == "Approved")) {
//                                $displayable_campaigns[] = $campaign_where_teammember->getId();
//                            }
//                        }
//                    }
////                    print_r($displayable_campaigns);
////                    die('dead @ line 130');
////                    foreach ($teammembers as $teammember) {
////                        if ($teammember->getIsReviewer()) {
////                            $campaigns_where_user_is_reviewer[] = $teammember->getCampaign();
////                        }
////                    }
////                    $campaign_ids_where_user_is_reviewer = array();
////                    foreach ($campaigns_where_user_is_reviewer as $campaign_where_user_is_reviewer) {
////                        if ($campaign_where_user_is_reviewer->getNotVisible() == false) {
////
////                            $tasks_of_this_campaign = $campaign_where_user_is_reviewer->getTasks();
////                            foreach ($tasks_of_this_campaign as $task) {
////                                if ($task->getTaskstatus()->getName() == "Submitted") {
////                                    $campaign_ids_where_user_is_reviewer[] = $campaign_where_user_is_reviewer->getId();
////                                }
////                            }
////                        }
////                    }
////                    $tasks_where_the_user_is_owner = $this->getDoctrine()->getRepository('TaskBundle:Task')->findByOwner($user);
////                    $campaign_ids_where_user_is_taskowner = array();
////
////                    foreach ($tasks_where_the_user_is_owner as $task_where_user_is_owner) {
////                        if ($task_where_user_is_owner->getCampaign()->getNotVisible() == false) {
////                            $campaign_ids_where_user_is_taskowner[] = $task_where_user_is_owner->getCampaign()->getId();
////                        }
////                    }
////                    //print_r($campaign_ids_where_user_is_taskowner);
////                    //Merge the two arrays and select unique values
////                    $campaigns_where_reviewer_or_taskowner = array();
////                    foreach ($campaign_ids_where_user_is_taskowner as $cidwuio) {
////                        $campaigns_where_reviewer_or_taskowner[] = $cidwuio;
////                    }
////                    foreach ($campaign_ids_where_user_is_reviewer as $cidwuir) {
////                        $campaigns_where_reviewer_or_taskowner[] = $cidwuir;
////                    }
////                    $unique_campaign_ids_for_this_filter = array_unique($campaigns_where_reviewer_or_taskowner);
////                    // print_r($unique_campaign_ids_for_this_filter);
////                    $unique_campaign_ids_after_second_filter = array();
////                    foreach ($unique_campaign_ids_for_this_filter as $campaign_id) {
////                        $grabbed_campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaign_id);
////                        if (($grabbed_campaign->getCampaignstatus()->getName() == "Build") || ($grabbed_campaign->getCampaignstatus()->getName() == "Approved")) {
////                            $unique_campaign_ids_after_second_filter[] = $grabbed_campaign->getId();
////                        }
////                    }
//                    //Return the final array
//                    $unique_campaign_ids_after_second_filter = $displayable_campaigns;
//
//                    $count = count($unique_campaign_ids_after_second_filter);
//                    $campaigns_to_display = $unique_campaign_ids_after_second_filter;
//                    $array_of_campaign_ids = $campaigns_to_display;
//                } else {
//                    $array_of_campaign_ids = null;
//                }
//
//
//
//
//
//                break;
//            case 2:
//                //
//                //THIS WILL ONLY DISPLAY THE VISIBLE CAMPAIGNS WHICH ARE IN OPEN STATE (BUILD/APPROVED)
//                //
//                if ($user->hasRole('ROLE_ADMINISTRATOR')) {
//                    $campaigns = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//                    foreach ($campaigns as $campaign) {
//                        $campaign_ids[] = $campaign->getId();
//                    }
//                } else {
//
//                    $campaignids = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//                    foreach ($campaignids as $campaignid) {
//                        $campaign_ids[] = $campaignid;
//                    }
//                }
//                $array_of_campaign_ids = array();
//
//                foreach ($campaign_ids as $campaign_id) {
//                    $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaign_id);
//                    if (($campaign->getCampaignstatus()->getName() == "Build") || ($campaign->getCampaignstatus()->getName() == "Approved")) {
//                        $array_of_campaign_ids[] = $campaign_id;
//                    }
//                }
//                $count = count($array_of_campaign_ids);
//                // print_r("Case 2");
//                break;
//            case 3:
//                //
//                //THIS WILL ONLY DISPLAY THE VISIBLE CAMPAIGNS WHICH ARE IN CLOSED STATE
//                //
//                $campaign_ids = array();
//
//                if ($user->hasRole('ROLE_ADMINISTRATOR')) {
//                    $campaigns = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//                    foreach ($campaigns as $campaign) {
//                        $campaign_ids[] = $campaign->getId();
//                    }
//                } else {
//                    $campaignids = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//                    foreach ($campaignids as $campaignid) {
//                        $campaign_ids[] = $campaignid;
//                    }
//                }
//                $array_of_campaign_ids = array();
//                foreach ($campaign_ids as $campaign_id) {
//                    $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaign_id);
//                    if (($campaign->getCampaignstatus()->getName() == "Complete") || ($campaign->getCampaignstatus()->getName() == "Cancelled")) {
//                        $array_of_campaign_ids[] = $campaign_id;
//                    }
//                }
//                $count = count($array_of_campaign_ids);
//                // print_r("Case 3");
//                break;
//
//            case 4:
//                //
//                //ALL INVISIBLE CAMPAIGNS (ONLY DISPLAYABLE TO ADMINS)
//                //
//                if ($user->hasRole('ROLE_ADMINISTRATOR')) {
//                    $campaigns = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAllDisabled();
//                    if ($campaigns) {
//                        foreach ($campaigns as $campaign) {
//                            $campaign_ids[] = $campaign['id'];
//                        }
//                    } else {
//                        $response->setStatusCode(200);
//                        $response->setContent(json_encode(array(
//                            'success' => true,
//                            'message' => 'There are no disabled campaigns.',
//                                        )
//                        ));
//                        return $response;
//                    }
//                } else {
//                    $response->setStatusCode(400);
//                    $response->setContent(json_encode(array(
//                        'success' => false,
//                        'message' => 'This call is only for administrators.',
//                                    )
//                    ));
//                    return $response;
//                }
//
//                $array_of_campaign_ids = $campaign_ids;
//                $count = count($array_of_campaign_ids);
//                // print_r("Case 4");
//                break;
//
//            default:
//                //Return response for not availlable filter.
//
//                $response->setStatusCode(200);
//                $response->setContent(json_encode(array(
//                    'success' => false,
//                    'message' => 'There is no such filter.',
//                                )
//                ));
//                return $response;
//                break;
//        }
//
//        if (count($array_of_campaign_ids) == 0) {
//            $response->setStatusCode(200);
//            $response->setContent(json_encode(array(
//                'Total campaigns for this filter' => 0,
//                'Campaigns' => [],
//                            )
//            ));
//            return $response;
//        }
//
//        // print_r($array_of_campaign_ids);
//        // die();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////// For each campaign fetched , validate the user is allowed to see the data about it.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $campaign_ids = array();
//        foreach ($array_of_campaign_ids as $campaign_id) {
//            $campaign_ids[] = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaign_id);
//        }
//        $campaigns_array = array();
//
//        foreach ($campaign_ids as $campaign) {
//
//            //Call Validation Function
//            $validated_to_display = self::validate_user_is_able_to_view_this_campaign($user, $campaign);
//
//            if ($validated_to_display) {
//                //Calculate campaign urgency:
//                $deliverabledate = $campaign->getClientdeliverabledate()->getTimestamp();
//                $current_date = $current_date_object->getTimestamp();
//                $urgency = floor(($deliverabledate / (60 * 60 * 24)) - ($current_date / (60 * 60 * 24)));
//
//                $tasks = $campaign->getTasks();
//
//                $campaigns_array[] = array(
//                    'CampaignID' => $campaign->getId(),
//                    'CampaignName' => $campaign->getName(),
//                    'ClientName' => $campaign->getClient()->getName(),
//                    'Country' => $campaign->getCountry()->getName(),
//                    'Brand' => $campaign->getBrand()->getName(),
//                    'Product' => $campaign->getProduct()->getName(),
//                    'Productline' => $campaign->getProductline()->getName(),
//                    'Division' => $campaign->getDivision()->getName(),
//                    'Completeness' => $campaign->getCompleteness(),
//                    'Urgency' => $urgency,
//                    'CampaignStatus' => $campaign->getCampaignstatus() ? $campaign->getCampaignstatus()->getName() : null,
//                    'CompletionDate' => date('Y-m-d', $campaign->getCompletionDate()->getTimestamp()),
//                    'CampaignLastModifiedDate' => date('Y-m-d H:i:s', $campaign->getUpdatedAt()->getTimestamp()),
//                    'ClientDeliverabledate' => date('Y-m-d', $campaign->getClientDeliverabledate()->getTimestamp()),
//                    'PresentedToClient' => $campaign->getClientpresentation(),
//                    'Token' => $campaign->getToken(),
//                    'Screentype' => $campaign->getScreenType(),
//                    'Brief_outline' => $campaign->getBriefOutline() ? $campaign->getBriefOutline() : null,
//                    'MMO_brandshare' => $campaign->getMmoBrandshare() ? $campaign->getMmoBrandshare() : null,
//                    'MMO_penetration' => $campaign->getMmoPenetration() ? $campaign->getMmoPenetration() : null,
//                    'MMO_salesgrowth' => $campaign->getMmoSalesgrowth() ? $campaign->getMmoSalesgrowth() : null,
//                    'MMO_othermetric' => $campaign->getMmoOthermetric() ? $campaign->getMmoOthermetric() : null,
//                    'MCO_brandhealth_bhc' => $campaign->getMcoBrandhealthBhc() ? $campaign->getMcoBrandhealthBhc() : null,
//                    'MCO_awareness_increase' => $campaign->getMcoAwarenessincrease() ? $campaign->getMcoAwarenessincrease() : null,
//                    'MCO_brandhealth_performance' => $campaign->getMcoBrandhealthPerformance() ? $campaign->getMcoBrandhealthPerformance() : null,
//                    'not_visible' => $campaign->getNotvisible() ? true : false,
//                    'Campaign_Start_Date' => $campaign->getStartDate() ? date('Y-m-d', $campaign->getStartDate()->getTimestamp()) : null,
//                    'Share_Voice' => $campaign->getSharevoice() ? $campaign->getSharevoice() : null,
//                    'Market_Share' => $campaign->getMarketshare() ? $campaign->getMarketshare() : null,
//                    'Mac' => $campaign->getMac() ? $campaign->getMac() : null,
//                    'Campaign_Class_Id' => $campaign->getCampaignclass() ? $campaign->getCampaignclass()->getId() : null,
//                    'Campaign_Class' => $campaign->getCampaignclass() ? $campaign->getCampaignclass()->getName() : null,
//                );
//            } // End of campaigns foreach().
//            //This is for debugging , to display what campaigns are not validated
////            else {
////                $campaigns_array[] = array('Not_validated' => $campaign->getId() . ' named ==== ' . $campaign->getName());
////            }
//        }
//        $response->setStatusCode(200);
//        $response->setContent(json_encode(array(
//            //'Role(DEBUG ONLy)' => $user->getRoles(),
//            'Total campaigns for this filter' => count($campaigns_array),
//            'Campaigns' => $campaigns_array,
//                        )
//        ));

        return $response;
    }

// End of GET information for user campaigns method().

    /**
     * @ApiDoc(
     *    description = "Fetches the existing high level attributes of a campaign (i.e. client, country, division, etc.)",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Campaign does not exist.",
     *         "Not allowed to view this campaign."
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignAction($campaignId) {
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneBy(['id' => $campaignId, 'not_visible' => false]);


        if (!$campaign) {

            // Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

        $validated_that_user_is_able_to_view_this_campaign = self::validate_user_is_able_to_view_this_campaign($user, $campaign);
        if (!$validated_that_user_is_able_to_view_this_campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Not allowed to view this campaign.'
                    ))
            );
            return $response;
        }


        $tasks = $this->getDoctrine()->getRepository('TaskBundle:Task')->findByCampaign($campaignId);
        //Calculate campaign urgency
        $current_date_object = new \DateTime();
        $deliverabledate = $campaign->getClientdeliverabledate()->getTimestamp();
        $current_date = $current_date_object->getTimestamp();
        $urgency = floor(($deliverabledate / (60 * 60 * 24)) - ($current_date / (60 * 60 * 24)));



        //FROM LIGHTDATA ASSIGNED TO THIS CAMPAIGN
        $lightdata_id = $campaign->getLightdata();
        //at first we suppose there is no lightdata.
        $lightdata = null;
        if ($lightdata_id != null) {
            $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($lightdata_id);
        }

        //if lightdata exists for this campaign , fetch the values needed from it. Else , set all the values needed from it to null.
        if ($lightdata) {

            $campaign_start_date_timestamp = $lightdata->getSetup()->getStartdate()->getTimestamp();
            $campaign_start_date = date('Y-m-d', $campaign_start_date_timestamp);
            $campaign_nb_periods = $lightdata->getSetup()->getNbperiods();
            /////////////////////////

            $calculated_end_date_timestamp = $campaign_start_date_timestamp + ($campaign_nb_periods * 7 * 24 * 60 * 60);
            /////////////////////////
            $campaign_end_date = date('Y-m-d', $calculated_end_date_timestamp);
            $campaign_survey = $lightdata->getSetup()->getSurvey()->getName();
            $campaign_target = $lightdata->getSetup()->getTarget()->getName();
            $campaign_budget = $lightdata->getSetup()->getBudget();
            $campaign_currency = $lightdata->getSetup()->getBudgetCurrency();
        } else {
            $campaign_start_date = null;
            $campaign_end_date = null;
            $campaign_survey = null;
            $campaign_target = null;
            $campaign_budget = null;
            $campaign_currency = null;
        }

        $region = $campaign->getCountry()->getRegion()->getName();

        $campaignFields = $this->campaignFieldsToArrayAction($campaign->getId());
        $campaign_data_array = $campaignFields + array(
            'CampaignID' => $campaign->getId(),
            'CampaignName' => $campaign->getName(),
            'ClientName' => $campaign->getClient()->getName(),
            'Country' => $campaign->getCountry()->getName(),
            'Region' => $region,
            'Brand' => $campaign->getBrand()->getName(),
            'Product' => $campaign->getProduct()->getName(),
            'Productline' => $campaign->getProductline()->getName(),
            'Division' => $campaign->getDivision()->getName(),
            'Completeness' => $campaign->getCompleteness(),
            'Urgency' => $urgency,
            'Campaign_Start_Date' => $campaign->getStartDate() ? date('Y-m-d', $campaign->getStartDate()->getTimestamp()) : null,
            'Campaign_End_Date' => $campaign_end_date,
            'Survey' => $campaign_survey,
            'Target' => $campaign_target,
            'Budget' => $campaign_budget,
            'Currency' => $campaign_currency,
            'CampaignStatus' => $campaign->getCampaignstatus() ? $campaign->getCampaignstatus()->getName() : null,
            'CompletionDate' => date('Y-m-d', $campaign->getCompletionDate()->getTimestamp()),
            'CampaignLastModifiedDate' => date('Y-m-d H:i:s', $campaign->getUpdatedAt()->getTimestamp()),
            'ClientDeliverabledate' => date('Y-m-d', $campaign->getClientDeliverabledate()->getTimestamp()),
            'PresentedToClient' => $campaign->getClientpresentation(),
            'Token' => $campaign->getToken(),
            'Screentype' => $campaign->getScreenType(),
            'Brief_outline' => $campaign->getBriefOutline() ? $campaign->getBriefOutline() : null,
            'MMO_brandshare' => $campaign->getMmoBrandshare() ? $campaign->getMmoBrandshare() : null,
            'MMO_penetration' => $campaign->getMmoPenetration() ? $campaign->getMmoPenetration() : null,
            'MMO_salesgrowth' => $campaign->getMmoSalesgrowth() ? $campaign->getMmoSalesgrowth() : null,
            'MMO_othermetric' => $campaign->getMmoOthermetric() ? $campaign->getMmoOthermetric() : null,
            'MCO_brandhealth_bhc' => $campaign->getMcoBrandhealthBhc() ? $campaign->getMcoBrandhealthBhc() : null,
            'MCO_awareness_increase' => $campaign->getMcoAwarenessincrease() ? $campaign->getMcoAwarenessincrease() : null,
            'MCO_brandhealth_performance' => $campaign->getMcoBrandhealthPerformance() ? $campaign->getMcoBrandhealthPerformance() : null,
            'not_visible' => $campaign->getNotvisible() ? true : false,
            'Share_Voice' => $campaign->getSharevoice() ? $campaign->getSharevoice() : null,
            'Market_Share' => $campaign->getMarketshare() ? $campaign->getMarketshare() : null,
            'Mac' => $campaign->getMac() ? $campaign->getMac() : null,
            'Campaign_Class_Id' => $campaign->getCampaignclass() ? $campaign->getCampaignclass()->getId() : null,
            'Campaign_Class' => $campaign->getCampaignclass() ? $campaign->getCampaignclass()->getName() : null,
        );

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Campaign' => $campaign_data_array
                        )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns the details of the task - owner, last time it was edited, last person to edit, etc.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned When the task was not found in database",
     *         "Returned When the task does not belong to the specified campaign",
     *         "Returned when the user does not have access to the task"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="taskId",     "dataType"="integer","requirement"="true", "description"="The task unique id"     },
     *       {"name"="campaignId", "dataType"="integer","requirement"="true", "description"="The campaign unique id" },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignsTaskAction($campaignId, $taskId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
//IF NO CAMPAIGN , THROW ERROR.
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid campaign id.'
            )));
            return $response;
        }
        $task = $this->getDoctrine()->getRepository('TaskBundle:Task')->find($taskId);
        if (!$task) {
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid task id.'
                    ))
            );
            return $response;
        }
//Grab all the tasks for this campaign
        $all_tasks_for_this_campaign = $this->getDoctrine()->getRepository('TaskBundle:Task')->findByCampaign($campaign);
// if TASK DOES NOT BELONG TO THIS CAMPAIGN , THROW ERROR
        if (!in_array($task, $all_tasks_for_this_campaign)) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid campaign and task combination.'
            )));
            return $response;
        }


// If matrix file exists, retrieve information for it:
        $matrixFile = $campaign->getMatrixfileUuid() ?
                $this->getDoctrine()->getRepository('FileBundle:File')->find($campaign->getMatrixfileUuid()) :
                null;


        $return_array = array(
            'TaskID' => $task->getId(),
            'TaskName' => $task->getTaskname()->getName(),
            'TaskOwnerUserID' => $task->getOwner() ? $task->getOwner()->getId() : null,
            'TaskOwnerFirstName' => $task->getOwner() ? $task->getOwner()->getFirstname() : null,
            'TaskOwnerLastName' => $task->getOwner() ? $task->getOwner()->getLastname() : null,
            'TaskOwnerTitle' => $task->getOwner() ? $task->getOwner()->getTitle() : null,
            'TaskOwnerOffice' => $task->getOwner() ? $task->getOwner()->getOffice() : null,
            'TaskOwnerEmailAddress' => $task->getOwner() ? $task->getOwner()->getEmail() : null,
            'TaskOwnerPhone' => $task->getOwner() ? $task->getOwner()->getPhone() : null,
            'TaskOwnerProfilePictureLocation' => $task->getOwner() ? $task->getOwner()->getProfilepicture() : null,
            'LatestTaskStatus' => $task->getTaskstatus()->getName(),
            'LatestTaskMessage' => $task->getTaskmessage() ? $task->getTaskmessage()->getMessage() : null,
            'LatestTaskStatusDate' => $task->getTaskstatusdate() ? date('Y-m-dTH:i:s', $task->getTaskstatusdate()->getTimestamp()) : null,
            'MatrixFileVersion' => $matrixFile ? $matrixFile->getVersion() : null,
            'MatrixVersionDate' => $matrixFile ? date('Y-m-dTH:i:s', $matrixFile->getUpdatedAt()->getTimestamp()) : null,
            'MatrixVersionBy' => ( $matrixFile and $matrixFile->getUser() ) ? $matrixFile->getUser()->getFirstName() . ' ' . $matrixFile->getUser()->getLastname() : null
        );

        $response->setStatusCode(200);
        $response->setContent(json_encode($return_array));
        return $response;
    }

// End of retrieve task information method().

    /**
     * @ApiDoc(
     *    description = "Returns campaign tasks information.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignTasksAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        $tasks = $this->getDoctrine()->getRepository('TaskBundle:Task')->findByCampaign($campaign);
// If matrix file exists, retrieve information for it:
        $matrixFile = $campaign->getMatrixfileUuid() ?
                $this->getDoctrine()->getRepository('FileBundle:File')->find($campaign->getMatrixfileUuid()) :
                null;

        if (!$campaign) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

        foreach ($tasks as $task) {

            $return_array[] = array(
                'TaskID' => $task->getId(),
                'TaskName' => $task->getTaskname()->getName(),
                'TaskOwnerUserID' => $task->getOwner() ? $task->getOwner()->getId() : null,
                'TaskOwnerFirstName' => $task->getOwner() ? $task->getOwner()->getFirstname() : null,
                'TaskOwnerLastName' => $task->getOwner() ? $task->getOwner()->getLastname() : null,
                'TaskOwnerTitle' => $task->getOwner() ? $task->getOwner()->getTitle() : null,
                'TaskOwnerOffice' => $task->getOwner() ? $task->getOwner()->getOffice() : null,
                'TaskOwnerEmailAddress' => $task->getOwner() ? $task->getOwner()->getEmail() : null,
                'TaskOwnerPhone' => $task->getOwner() ? $task->getOwner()->getPhone() : null,
                'TaskOwnerProfilePictureLocation' => $task->getOwner() ? $task->getOwner()->getProfilepicture() : null,
                'LatestTaskStatus' => $task->getTaskstatus()->getName(),
                'LatestTaskMessage' => $task->getTaskmessage() ? $task->getTaskmessage()->getMessage() : null,
                'LatestTaskStatusDate' => $task->getTaskstatusdate() ? date('Y-m-dTH:i:s', $task->getTaskstatusdate()->getTimestamp()) : null,
                'MatrixFileVersion' => $matrixFile ? $matrixFile->getVersion() : null,
                'MatrixVersionDate' => $matrixFile ? date('Y-m-dTH:i:s', $matrixFile->getUpdatedAt()->getTimestamp()) : null,
                'MatrixVersionBy' => ( $matrixFile and $matrixFile->getUser() ) ? $matrixFile->getUser()->getFirstName() . ' ' . $matrixFile->getUser()->getLastname() : null
            );
        } // End of tasks foreach() loop.

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Tasks' => $return_array
                        )
        ));

        return $response;
    }

// End of GET information for all tasks of a campaign method().

    /**
     * @ApiDoc(
     *    description = "Creates and saves a new campaign.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     201 = "Returned when the campaign was added to the database",
     *     400 = "Returned when the validation returns false ",
     *     403 = {"Invalid API KEY", "Incorrect combination of request inputs."},
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="_format",               "dataType"="string","requirement"="json|xml","description"="Format"},
     *    },
     *    parameters={
     *       {"name"="name",                  "dataType"="text",  "required"=true, "description"="The campaign name"},
     *       {"name"="client",                "dataType"="string","required"=true,"description"="The campaign client."},
     *       {"name"="brand",                 "dataType"="string","required"=true,"description"="The campaign brand."},
     *       {"name"="product",               "dataType"="string","required"=true,"description"="The campaign product."},
     *       {"name"="division",              "dataType"="string","required"=true,"description"="The campaign division."},
     *       {"name"="productline",           "dataType"="string","required"=true,"description"="The campaign productline."},
     *       {"name"="country",               "dataType"="string","required"=true,"description"="The campaign country."},
     *       {"name"="completion_date",       "dataType"="string","required"=true,"description"="The campaign completion date."},
     *       {"name"="client_deliverabledate","dataType"="string","required"=true,"description"="The campaign deliverable date."},
     * }
     * )
     * return string
     * @View()
     */
    public function postCampaignAction(Request $request) {
        $user = $this->getUser();

        $creationDate = new \DateTime();
        $creationDate->setTimezone(self::timezoneUTC());

        $em = $this->getDoctrine()->getManager();
        $key = Uuid::uuid4()->toString();
        $token_key = Uuid::uuid4()->toString();
        $client_id = $request->get('client');
        $country_id = $request->get('country');
        $brand_id = $request->get('brand');
        $product_id = $request->get('product');
        $productline_id = $request->get('productline');
        $division_id = $request->get('division');
        $response = new Response();



        //Disallow VIEWERS TO POST CAMPAIGNS
        if ($user->hasRole('ROLE_VIEWER')) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => "Viewers are not allowed to create campaigns"
            )));
            return $response;
        }




/////////////////////////////////////////////////////////////////////////////////////
// Checks to verify object's existence into the database.
/////////////////////////////////////////////////////////////////////////////////////
        $client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneById($client_id);
        if (!$client) {

            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field client.')));
            return $response;
        }
        $division = $this->getDoctrine()->getRepository('CampaignBundle:Division')->findOneById($division_id);
        if (!$division) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field division.')));
            return $response;
        }
        $brand = $this->getDoctrine()->getRepository('CampaignBundle:Brand')->findOneById($brand_id);
        if (!$brand) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field brand.')));
            return $response;
        }
        $productline = $this->getDoctrine()->getRepository('CampaignBundle:Productline')->findOneById($productline_id);
        if (!$productline) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field productline.')));
            return $response;
        }
        $product = $this->getDoctrine()->getRepository('CampaignBundle:Product')->findOneById($product_id);
        if (!$product) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field product.')));
            return $response;
        }
        $country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneById($country_id);
        if (!$country) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Invalid ID provided for field country .')));
            return $response;
        }


        //AFTER VALIDATING INPUT , FOR A CONTRIBUTOR , VALIDATE THE ACCESS TOO



        if ($user->hasRole('ROLE_CONTRIBUTOR')) {

            $post_can_continue = self::validate_the_put_and_post_for_contributor($client, $country, $user);

            if (!$post_can_continue) {
                //print_r($user->getUsername());
                $response->setStatusCode(200);
                $response->setContent(json_encode(array(
                    'success' => false,
                    'message' => "You do not have permissions to create a campaign for the specified client and country values"
                )));
                return $response;
            }
        }


//DISABLED VALIDATION HERE // THE CLIENT WANTS TO BE ABLE TO CREATE DUPLICATE CAMPAIGNS IN SELECT CASES , SO THEY WILL BE RESPONSIBLE FOR MONITORING THE DUPLICATES MANUALLY        
//        ///VERIFY THAT THERE IN'T ALREADY A CAMPAIGN CREATED BY THIS USER , USING THE SPECIFIED NAME.
//
//        $campaing_already_exists_for_creator_name_combo = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneBy([
//            'user' => $user,
//            'name' => $request->get('name')]);
//
//
//        if ($campaing_already_exists_for_creator_name_combo) {
//            $response->setStatusCode(403);
//            $response->setContent(json_encode(array('success' => false, 'message' => 'You already have a campaign that uses that campaign name. Please choose another one!')));
//            return $response;
//        }
//        /// End of newly added validation.
////////
/////////////////////////////////////////////////////////////////////////////////////
// END Checks to verify object's existence into the database.
////////////////////////////////////////////////////////////////////////////////////
////RELATIONAL CHECKS
////RELATIONAL CHECKS
////////////////////////////////////////////////////
// Client should have the respective division
// Division should have the respective brand
// Brand should have the respective productline
// Productline should have the respective product
//////////////////////////////////////////////////////////////////
//////////////////////
//Validate that the division specified belongs to the client specified.
//////////////////////
        if (!($division->getClient()->getId() == $client->getId())) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Division does not belong to this Client.')));
            return $response;
        }
//////////////////////
//Validate that the brand specified belongs to the division specified.
//////////////////////
        if (!($brand->getDivision()->getId() == $division->getId())) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Brand does not belong to this Division.')));
            return $response;
        }
//////////////////////
//Validate that the productline specified belongs to the brand specified.
//////////////////////
        if (!($productline->getBrand()->getId() == $brand->getId())) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Productline does not belong to this Brand.')));
            return $response;
        }
////////////////////////
//Validate that the product specified belongs to the productline specified.
//////////////////////
        if (!($product->getProductline()->getId() == $productline->getId())) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Product does not belong to this Productline.')));
            return $response;
        }

//////////////////////////////
//END RELATIONAL CHECKS
//////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
/////////////////////END OF CHECKS
////////////////////////////////////////////////////////////////////////////////////

        if (empty($request->get('completion_date'))) {
            $response->setStatusCode(400);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The completion_date field is required !'
            )));

            return $response;
        }
        if (empty($request->get('client_deliverabledate'))) {
            $response->setStatusCode(400);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The client_deliverabledate field is required !'
            )));

            return $response;
        }


        $completion_date_input = $request->get('completion_date');
// Inputs completion and deliverable dates:
        if ($completion_date_input) {
            $completion_date = new \DateTime($request->get('completion_date'));
            $completion_date->setTimezone(self::timezoneUTC());
        }

        $deliverable_date_input = $request->get('client_deliverabledate');

        if ($deliverable_date_input) {
            $deliverable_date = new \DateTime($request->get('client_deliverabledate'));
            $deliverable_date->setTimezone(self::timezoneUTC());
        }



//VALIDATE THAT THE COMPLETION DATE IS LATER THAN THE CLIENT_DELIVERABLEDATE
        if ($completion_date && $deliverable_date) {
            $seconds_in_one_day = 60 * 60 * 24;
            $ts_completion = $completion_date->getTimestamp();
            $ts_deliverable = $deliverable_date->getTimestamp();
            $difference = $ts_completion - $ts_deliverable;
            if ($difference < $seconds_in_one_day) {
                $response->setStatusCode(400);
                $response->setContent(json_encode(array(
                    'success' => false,
                    'message' => 'The Completion Date must be later than the Client Deliverable Date. (1 day minimum)'
                )));

                return $response;
            }
        }
//ERROR MESSAGE : The Completion Date must be later than the Client Deliverable Date.


        $campaign_status = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->find(1);

// Populate the Campaign object with data from the Request:
        $campaign = new Campaign();
        $campaign->setId($key);
        $campaign->setUser($user);
//$campaign->setBriefOutline('This is the campaigns bief outline text. hardcoded.');
        $campaign->setClientPresentation(false);
        $campaign->setCompleteness(0);
        $campaign->setName($request->get('name'));
        $campaign->setClient($client);
        $campaign->setBrand($brand);
        $campaign->setProduct($product);
        $campaign->setProductline($productline);
        $campaign->setDivision($division);
        $campaign->setCountry($country);
        $campaign->setCampaignstatus($campaign_status);
        $campaign->setCompletionDate($completion_date);
        $campaign->setClientDeliverabledate($deliverable_date);
        $campaign->setToken($token_key);
        $campaign->setNotVisible(false);
        $campaign->setScreentype('10000');

// Set time for when the file was created:

        $campaign->setCreatedAt($creationDate);
        $campaign->setUpdatedAt($creationDate);


// Get validator service to check for errors:
        $validator = $this->get('validator');
        $errors = $validator->validate($campaign);

// Create and prepare the Response object to be sent back to client:
        $response = new Response();

        if (count($errors) > 0) {

// Return $errors in JSON format:
            $view = $this->view($errors, 400);
            return $this->handleView($view);
        }

// If no errors were found, instantiate entity_manager to begin.

        $em->persist($campaign);
/////////////////////////////////////////////////////
//Add the user who created the campaign to the campaign's team.
/////////////////////////////////////////////////////

        $add_as_teammember = new Teammember();
        $add_as_teammember->setCampaign($campaign);
        $add_as_teammember->setMember($user);
        $add_as_teammember->setIsReviewer(false);
        $em->persist($add_as_teammember);


//////////////////////////////////////////////////////
///        
/////////////////////////////////////////////////////
//Create the set of tasks for this campaign
/////////////////////////////////////////////////////

        $campaign_unique_id = $campaign->getId();

        $task_types = $this->getDoctrine()->getRepository('TaskBundle:Taskname')->findAll();

        $default_task_status = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->find(1);

        foreach ($task_types as $tasktype) {

            $new_task = new Task();
            $new_task->setCampaign($campaign);
            $new_task->setTaskname($tasktype);
            $new_task->setOwner($user);
            $new_task->setTaskmessage(NULL);
            $new_task->setMatrixfileversion(0);
            $new_task->setTaskstatus($default_task_status);
            $new_task->setPhase($tasktype->getPhaseid());
            $new_task->setCreatedAt($creationDate);
            $new_task->setCreatedby($user);
            $new_task->setUpdatedAt($creationDate);
            $em->persist($new_task);
        }

//////////////////////////////////////////////////////
///

        $em->flush();

        $response->setStatusCode(201);
        $response->setContent(json_encode(array(
            'success' => true,
            'campaignID' => $campaign->getId(),
                ))
        );

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Saves high level attributes of an existing campaign (i.e. client, country, division, etc.)",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     201 = "Returned when the campaign was updated.",
     *     400 = {
     *      "Returned when the validation returns false.",
     *     },
     *     403 = {"Invalid API KEY",
     *            "Returned when the user does not have access to update the campaign."  
     *     },
     *     404 = "No campaign exists for that ID.",
     *     500 = "Header x-wsse does not exist."
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign's unique identifier",
     *           "requirement" = "True"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    },
     * parameters={
     *       {"name"="name",                  "dataType"="text",    "required"=true,"description"="The campaign's new name"         },
     *       {"name"="client",                "dataType"="integer", "required"=true,"description"="The campaign client id."         },
     *       {"name"="brand",                 "dataType"="integer", "required"=true,"description"="The campaign brand id."          },
     *       {"name"="product",               "dataType"="integer", "required"=true,"description"="The campaign product id."        },
     *       {"name"="division",              "dataType"="integer", "required"=true,"description"="The campaign division id."       },
     *       {"name"="productline",           "dataType"="integer", "required"=true,"description"="The campaign productline id."    },
     *       {"name"="country",               "dataType"="integer", "required"=true,"description"="The campaign country id."        },
     *       {"name"="completion_date",       "dataType"="date",    "required"=true,"description"="The campaign completion date."   },
     *       {"name"="client_deliverabledate","dataType"="date",    "required"=true,"description"="The campaign deliverable date."  },
     *      {"name"="campaign_status",        "dataType"="integer", "required"=true,"description"="Campaign status (1 to 4)"        },
     *      {"name"="already_presented",      "dataType"="boolean", "required"=true,"description"="Boolean (1 = true , 0 = false)"  },
     *      {"name"="share_voice",            "dataType"="decimal", "required"=false,"description"="Decimal value , not required"  },
     *      {"name"="market_share",           "dataType"="decimal", "required"=false,"description"="Decimal value , not required"  },
     *      {"name"="mac",                    "dataType"="integer", "required"=false,"description"="Integer value , not required"  },
     *      {"name"="campaign_class_id",      "dataType"="integer", "required"=false,"description"="Integer value , not required (1 to 3 if needed)"  },
     * }
     * )
     * @return array
     * @View()
     */
    public function putCampaignAction($campaignId, Request $request) {
        //Fetch the current user that is trying to call the PUT Campaign
        $user = $this->getUser();
        $current_user_making_the_put = $user;
        //Instantiate a response for later usage.
        $response = new Response();
        //Get the date the of the update/ put
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());

        // Return response error if the campaignId is empty
        if ($campaignId == NULL) {
            $response->setStatusCode(400);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Missing campaignId.'
            )));
            return $response;
        }

        // Check if the campaign exists for the specified campaign ID
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

        if (!$campaign) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'No campaign exists for that id'
                    ))
            );
            return $response;
        }



        //$campaign = $campaign_exists;
        // Throw error if the current user is not an administrator or contributor.
        if ($user->hasRole('ROLE_VIEWER')) {
            $response = new Response();
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This authenticated user does not have access to update this campaign . (only admins || contribs)'
                    ))
            );
            return $response;
        }

        $input_validated = TRUE;
        $required_fields = array(
            'name',
            'client',
            'brand',
            'product',
            'productline',
            'division',
            'country',
            'already_presented',
            'completion_date',
            'client_deliverabledate',
            'campaign_status'
        );

        $specialerrors = array();
        foreach ($required_fields as $field) {
            if ($request->get($field) == NULL) {
                $input_validated = FALSE;
                $specialerrors[] = $field;
            }
        }



//Check the input information has been set
        if ($input_validated) {

            $client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneById($request->get('client'));
            $brand = $this->getDoctrine()->getRepository('CampaignBundle:Brand')->findOneById($request->get('brand'));
            $product = $this->getDoctrine()->getRepository('CampaignBundle:Product')->findOneById($request->get('product'));
            $productline = $this->getDoctrine()->getRepository('CampaignBundle:Productline')->findOneById($request->get('productline'));
            $country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneById($request->get('country'));
            $division = $this->getDoctrine()->getRepository('CampaignBundle:Division')->findOneById($request->get('division'));
            $campaignstatus = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->findOneById($request->get('campaign_status'));


            /// VALIDATION THAT THE CONTRIBUTOR USER IS ABLE TO CHANGE THE CAMPAIGN
            // CLIENT OR COUNTRY
            // No validation needed if user is administrator because they can see anything.
            if ($client && $country) {
                if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                    //ACTUAL VALIDATION START   
                    // Logic :
                    // Only allow the put to take place if the user that makes the call , has an entry into contro_user_access that matches 
                    // the permissions to view.

                    $put_can_continue = self::validate_the_put_and_post_for_contributor($client, $country, $user);

                    if (!$put_can_continue) {
                        //print_r($user->getUsername());
                        $response->setStatusCode(403);
                        $response->setContent(json_encode(array(
                            'success' => false,
                            'message' => "You do not have permissions to set the client and country to these values"
                        )));
                        return $response;
                    }
                }
            } else {
                $response->setStatusCode(404);
                $response->setContent(json_encode(array(
                    'success' => false,
                    'message' => 'Could not find a country for the id specified / Could not find a client for the id specified.'
                )));
                return $response;
            }

            //END OF NEW VALIDATION

            $campaign->setName($request->get('name'));

            //New NOT REQUIRED  fields
            if (!empty($request->get('share_voice'))) {
                $campaign->setSharevoice($request->get('share_voice'));
            }
            if (!empty($request->get('market_share'))) {
                $campaign->setMarketshare($request->get('market_share'));
            }
            if (!empty($request->get('mac'))) {
                $campaign->setMac($request->get('mac'));
            }
            if (!empty($request->get('campaign_class_id'))) {

                $campaign_class = $this->getDoctrine()->getRepository('CampaignBundle:Campaignclass')->find($request->get('campaign_class_id'));
                if ($campaign_class) {
                    $campaign->setCampaignclass($campaign_class);
                } else {
                    $response->setStatusCode(400);
                    $response->setContent(json_encode(array(
                        'success' => false,
                        'message' => 'The campaign_class_id you provided is invalid.'
                    )));
                    return $response;
                }
            }

            $campaign->setClientpresentation($request->get('already_presented'));

            $campaign->setClient($client);
            $campaign->setBrand($brand);
            $campaign->setProduct($product);
            $campaign->setProductline($productline);
            $campaign->setDivision($division);
            $campaign->setCountry($country);
            $campaign->setCampaignstatus($campaignstatus);
            $campaign->setUpdatedAt($updateDate);


//Set the new campaign dates
            $new_comp_Date = new \DateTime($request->get('completion_date'));
            $new_comp_Date->setTimezone(self::timezoneUTC());
            $campaign->setCompletionDate($new_comp_Date);
            $new_deliv_date = new \DateTime($request->get('client_deliverabledate'));
            $new_deliv_date->setTimezone(self::timezoneUTC());
            $campaign->setClientDeliverabledate($new_deliv_date);
        } else {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Data input failed validation.',
                'errors_on' => $specialerrors
            )));
            return $response;
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($campaign);
        $em->flush();

        /////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////
        // AFTER THE CAMPAIGN IS SUCCESSFULLY UPDATED ,
        /////////////////////////////////////////////////////////////
        // a) Delete the users from the teammember list who no longer have permissions to the campaign
        // this method should return the list of the users that were removed. and be used below for removing the task ownership.


        $removed_teammembers_ids = self::refresh_campaign_teammembers_list_after_update($campaign);
        // b) If any of the deleted users were task owners in this campaign , remove the task ownership
        //FOR EACH OF THE REMOVED IDS , FIND ALL THE TASKS OF THIS CAMPAIGN THAT HAD THE RESPECTIVE USER ASSIGNED AS A TASK OWNER ,
        // AND CHANGE THE TASKOWNER TO THE CURRENT USER MAKING THE CALL.

        foreach ($removed_teammembers_ids as $user_id) {

            $deleted_user = $this->getDoctrine()->getRepository('UserBundle:User')->find($user_id);

            $tasks_where_this_user_was_taskowner = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy([
                'owner' => $deleted_user,
                'campaign' => $campaign]);

            if ($tasks_where_this_user_was_taskowner) {
                foreach ($tasks_where_this_user_was_taskowner as $task) {
                    $task->setOwner($current_user_making_the_put);


                    //For each task that gets set the current user making the put , 
                    //check if the CURRENT USER IS MEMBER IN THE TEAM, IF HE IS NOT , ADD HIM
                    $checked_the_current_user = self::checkIfCurrentUserIsMemberOrAddHim($current_user_making_the_put, $campaign);
                }
            }
        }


        $em->flush();





        $response->setStatusCode(201);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign updated.',
            'removed_teammembers' => $removed_teammembers_ids
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Update the campaign's status (Build, Approved, Cancelled, Complete).",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was updated.",
     *     403 = "Invalid API KEY",
     *     404 = "Invalid request inputs.",
     *     500 = "Header x-wsse does not exist."
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign's unique identifier",
     *           "requirement" = "True"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    },
     * parameters={
     *      {"name"="campaign_status",        "dataType"="integer", "required"=true,"description"="Campaign status (1 to 4)"        },
     * }
     * )
     * @return array
     * @View()
     */
    public function putCampaignStatusAction($campaignId, Request $request) {
        $user = $this->getUser();
        $response = new Response();
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());

// Return response error if the campaignId is empty
        if ($campaignId == NULL) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Missing campaignId.'
            )));
            return $response;
        }

// Check if the campaign exists for the specified campaign ID
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

        if (!$campaign) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'No campaign for that id'
                    ))
            );
            return $response;
        }

        $campaignstatus = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->findOneById($request->get('campaign_status'));
        if (!$campaignstatus) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'No status type exists for that id'
                    ))
            );
            return $response;
        }

        $campaign->setCampaignstatus($campaignstatus);
        $campaign->setUpdatedAt($updateDate);



        $em = $this->getDoctrine()->getManager();
        $em->persist($campaign);
        $em->flush();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign ' . $campaign->getId() . ' status updated to ' . $campaignstatus->getName() . ' '
                ))
        );
        return $response;
    }

//    /**
//     * @ApiDoc(
//     *    resource = true,
//     *    description = "Delete a campaign based on [campaignId]",
//     *    statusCodes = {
//     *     200 = "Returned when the campaign was deleted with success",
//     *     400 = {
//     *         "Returned When the campaign was not found in database",
//     *         "Returned when the user does not have access to the campaign"
//     *     },
//     *     403 = "Invalid API KEY",
//     *     500 = "Header x-wsse does not exist"
//     *    },
//     *    requirements = {
//     *       {
//     *           "name"="campaignId",
//     *           "dataType"="string",
//     *           "description"="The campaign unique id"
//     *       },
//     *       {
//     *          "name" = "_format",
//     *          "requirement" = "json|xml"
//     *       }
//     *    }
//     * )
//     * @return array
//     * @View()
//     */
//    public function deleteCampaignAction($campaignId) {
//        $user = $this->getUser();
//        $response = new Response();
//
//        if ($campaignId == NULL) {
//            $response->setStatusCode(400);
//            $response->setContent('The id parameter cannot be null.');
//        }
//
//        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')
//                ->findOneBy(['user' => $user, 'id' => $campaignId]);
//
//        $em = $this->getDoctrine()->getManager();
//
//        if (empty($campaign)) {
//            $response = new Response();
//            $response->setStatusCode(400);
//            $response->setContent(json_encode(array(
//                'success' => false,
//                'message' => 'Campaign does not exist.'
//                    ))
//            );
//            return $response;
//        }
//
//        $em->remove($campaign);
//        $em->flush();
//
//        $response->setStatusCode(200);
//        $response->setContent(json_encode(array(
//            'success' => true,
//            'message' => 'Campaign deleted.'
//                ))
//        );
//
//        return $response;
//    }

    /**
     * @ApiDoc(
     *    description = "Returns the type values used for drop down lists in the application such as Task Statuses, Campaign Statuses.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsAction() {
        $user = $this->getUser();
        $response = new Response();

        $clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findAll();
        $brands = $this->getDoctrine()->getRepository('CampaignBundle:Brand')->findAll();
        $products = $this->getDoctrine()->getRepository('CampaignBundle:Product')->findAll();
        $countries = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findAll();
        $task_statuses = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->findAll();
        $campaign_statuses = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->findAll();
        $product_lines = $this->getDoctrine()->getRepository('CampaignBundle:Productline')->findAll();
        $filetypes = $this->getDoctrine()->getRepository('CampaignBundle:Filetype')->findAll();
        $divisions = $this->getDoctrine()->getRepository('CampaignBundle:Division')->findAll();
//        $phases = $this->getDoctrine()->getRepository('CampaignBundle:Phase')->findAll();
        $campaign_classes = $this->getDoctrine()->getRepository('CampaignBundle:Campaignclass')->findAll();

        $client_array = array();
        $brand_array = array();
        $product_array = array();
        $country_array = array();
        $task_statuses_array = array();
        $campaign_statuses_array = array();
        $product_lines_array = array();
        $filetype_array = array();
        $division_array = array();
//        $phase_array = array();
        $campaign_classes_array = array();

        foreach ($clients as $client) {
            $client_array[$client->getId()] = ucfirst($client->getName());
        }
        foreach ($brands as $brand) {
            $brand_array[$brand->getId()] = ucfirst($brand->getName());
        }
        foreach ($countries as $country) {
            $country_array[$country->getId()] = ucfirst($country->getName());
        }
        foreach ($products as $product) {
            $product_array[$product->getId()] = ucfirst($product->getName());
        }
        foreach ($task_statuses as $task_status) {
            $task_statuses_array[$task_status->getId()] = $task_status->getName();
        }
        foreach ($campaign_statuses as $campaign_status) {
            $campaign_statuses_array[$campaign_status->getId()] = $campaign_status->getName();
        }
        foreach ($product_lines as $product_line) {
            $product_lines_array[$product_line->getId()] = ucfirst($product_line->getName());
        }
        foreach ($filetypes as $filetype) {
            $filetype_array[$filetype->getId()] = $filetype->getName();
        }
        foreach ($divisions as $division) {
            $division_array[$division->getId()] = ucfirst($division->getName());
        }
//        foreach ($phases as $phase) {
//            $phase_array[$phase->getId()] = $phase->getName();
//        }

        foreach ($campaign_classes as $campaign_class) {
            $campaign_classes_array[$campaign_class->getId()] = $campaign_class->getName();
        }


        // Sort clients and countries array by name:
        asort($client_array);
        asort($division_array);
        asort($product_array);
        asort($brand_array);
        asort($country_array);
        asort($product_lines_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'clients' => $client_array,
            'brands' => $brand_array,
            'products' => $product_array,
            'countries' => $country_array,
            'task_statuses' => $task_statuses_array,
            'campaign_statuses' => $campaign_statuses_array,
            'product_lines' => $product_lines_array,
            'filetypes' => $filetype_array,
            'divisions' => $division_array,
//            'phases' => $phase_array,
            'campaign_classes' => $campaign_classes_array
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Update the task status / submit a task.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was updated",
     *     403 = {"Invalid API KEY",
     *            "Returned when the status does not match one of the status names in the db.",
     *            "Returned when the user does not have access to the task" },
     *     404 = {
     *         "Returned When the task was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="campaignId",  "dataType"="string",    "description"="The campaign's unique Id",   "requirement"="true"  },
     *       {"name"="taskId",      "dataType"="integer",   "description"="The task's unique Id",       "requirement"="true"  },
     *       {"name" = "_format",      "requirement" = "json|xml"      }
     *    },
     *    parameters={
     *       {"name"="status",                "dataType"="integer", "required"=true,    "description"="The new task status (1 to 3)"       },
     *       {"name"="message",               "dataType"="text",    "required"=false,   "description"="The new task message. Can be null." },
     * }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsTaskAction($campaignId, $taskId, Request $request) {
        $debug_array = array();
//Grab the current user browsing / using the app.
        $user = $this->getUser();
        $response = new Response();

//Grab the current date if needed
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

//Instantiate a campaign reviewers array
        $campaign_reviewers_array = array();
//Fetch the current campaign from the database
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid campaignId.'
            )));
            return $response;
        }
        $debug_array['initial_completeness'] = $campaign->getCompleteness();
//Validate the status input !
        $status_id = $request->get('status');



        $status = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->findOneById($status_id);

        if (!$status) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'That status code does not exist!'
            )));
            return $response;
        }


//FETCH THE CAMPAIGN'S TEAM.
        $teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findBy(['campaign' => $campaign]);
        if (!$teammembers) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The campaign team must have at least one member in order to continue.'
            )));
        }


        $nr = count($teammembers);

        foreach ($teammembers as $teammember) {
            if ($teammember->getIsReviewer()) {
                $campaign_reviewers_array[] = $teammember->getMember();
            }
        }

//instantiate a boolean is_allowed_for_all_values
        $is_allowed_for_all_values = false;
//check if user is in the reviewers array
        if (in_array($user, $campaign_reviewers_array)) {
            $is_allowed_for_all_values = true;
        }

//Fetch the current task to be updated
        $task = $this->getDoctrine()->getRepository('TaskBundle:Task')
                ->find($taskId);

// Check if the task exists
        if (!$task) {
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Task does not exist.'
                    ))
            );
            return $response;
        }

        if ($request->get('status')) {
            $status = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->findOneById($request->get('status'));
            if (!$status) {
                $response->setStatusCode(403);
                $response->setContent(json_encode(array(
                    'success' => false,
                    'message' => 'Invalid status!'
                )));
            }
            if ($request->get('status') == 3) {
                if ($is_allowed_for_all_values) {
                    $task->setTaskstatus($status);
                    $updated_completeness = self::recalculate_campaign_completeness($campaign);
                    $campaign->setCompleteness($updated_completeness);
                } else {
                    $response->setStatusCode(403);
                    $response->setContent(json_encode(array(
                        'success' => false,
                        'message' => 'You are not a campaign reviewer. You cannot change the status to completed.'
                    )));
                    return $response;
                }
            } else {
                $task->setTaskstatus($status);
                $updated_completeness = self::recalculate_campaign_completeness($campaign);
                $campaign->setCompleteness($updated_completeness);
            }

            $task->setTaskmessage(NULL);
            if ($request->get('message')) {
                $newMessage = new Taskmessage();
                $newMessage->setMessage($request->get('message'));
                $newMessage->setCreatedAt($updateDate);
                $newMessage->setUpdatedAt($updateDate);
                $em->persist($newMessage);
                $task->setTaskmessage($newMessage);
            }

            $task->setTaskstatusdate($updateDate);
            $task->setStatuschangedby($user);
            $campaign->setUpdatedAt($updateDate);
            $em->flush();
            $debug_array['post_completeness'] = $campaign->getCompleteness();

            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'message' => 'Task updated.',
                'debug_array' => $debug_array,
            )));
            return $response;
        } else {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Field status cannot be empty.'
                    ))
            );
            return $response;
        }
    }

    /**
     * @ApiDoc(
     *    description = "Change the owners of a task. By default whoever creates the campaign is the initial owner of all tasks.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task's owner was updated",
     *     403 = {"Invalid API KEY",
     *            "Returned when the current user does not match the campaign owner / creator",
     *           },
     *     404 = {
     *         "Returned when a campaign was not found in database by the campaignId in the url.",
     *         "Returned when a task was not found in database  by the taskId in the url.",
     *         "Returned when a user was not found in database  by the userId in the url.",
     *         "Returned when the user is not part of the campaign's team",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The ID of the campaign.",
     *           "requirement"="true"
     *       },
     *      {
     *           "name"="taskId",
     *           "dataType"="integer",
     *           "description"="The ID of the task.",
     *           "requirement"="true"
     *       },
     *      {
     *           "name"="userId",
     *           "dataType"="integer",
     *           "description"="The ID of the user.",
     *           "requirement"="true"
     *       },
     *    }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsTaskOwnerAction($campaignId, $taskId, $userId, Request $request) {
//Grab the current user;
        $user = $this->getUser();
//instantiate a response
        $response = new Response();
        $em = $this->getDoctrine()->getManager();

//Verify that the campaign exists
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid campaignId.'
            )));
            return $response;
        }
//Verify that the user_to_be_owner exists
        $user_to_be_owner = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);
        if (!$user_to_be_owner) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid user id provided.'
            )));
            return $response;
        }

        $validated_as_contrib_or_admin = false;
        if (($user->hasRole('ROLE_CONTRIBUTOR')) || ($user->hasRole('ROLE_ADMINISTRATOR'))) {
            $validated_as_contrib_or_admin = true;
        }

        if (!$validated_as_contrib_or_admin) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'You do not have permissions to change the Task Owner. Only Contributors and Admins allowed.'
            )));
            return $response;
        }

        $current_user_id = $user->getId();

//This is validation that checks if the user is allowed to view the client-campaign-country combination
        $user_can_access_campaign = self::validate_user_is_able_to_view_this_campaign($user, $campaign);


//        
//        print_r($user_can_access_campaign);
//        die('help');
//        
// If the user is administrator , he will bypass that validation !
        if ($user->hasRole('ROLE_ADMINISTRATOR')) {
            $user_can_access_campaign = true;
        }


        if (!$user_can_access_campaign) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'You do not have permissions to change the Task Owner. You are a contributor but you cannot access this campaign.'
            )));
            return $response;
        }

/// END OF VALIDATIONS MOMENTARELY , PROCEED TO THE ACTUAL IMPLEMENTATIOn
/////////////////////////////////////
/////////////////////////////////////
/////////////////////////////////////
/////////////////////////////////////


        $task = $this->getDoctrine()->getRepository('TaskBundle:Task')->findOneBy(['id' => $taskId, 'campaign' => $campaign]);
        if (!$task) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid campaign and task combo.'
            )));
            return $response;
        }

// Get the user we want to set as owner / or throw error
        $user_to_be_owner = $this->getDoctrine()->getRepository('UserBundle:User')->find($userId);
        if (!$user_to_be_owner) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid userId.'
            )));
            return $response;
        }

// Get the teammmembers array for this campaign
        $teammember = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findOneBy(['campaign' => $campaign, 'member' => $userId]);

// Check that the user we want to set as a task owner is a teammember  / or throw error
        if (!$teammember) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid teammember.'
            )));
            return $response;
        }

//If the validation passed , update the task's owner field with the provided user.

        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $campaign->setUpdatedAt($updateDate);

        $em = $this->getDoctrine()->getManager();
        $task->setOwner($user_to_be_owner);
        $em->flush();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'User ' . $user_to_be_owner->getId() . ' has been set as taskowner for ' . $task->getTaskname()->getName() . ' task of the campaign ' . $campaign->getId() . '.'
        )));
        return $response;
    }

    /**
     * @ApiDoc(
     *    deprecated=TRUE,
     *    description = "no longer used, replaced by GET campaigns/eligibleteammembers. Returns a list of all users in the system.",
     *   section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the array was successfully generated.",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Could not find any users."
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getUsersAction() {
        $current_user = $this->getUser();
        $response = new Response();
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();

        if (!$users) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Could not find any users.')));
            return $response;
        }

        $users_array = array();
        foreach ($users as $user) {
            $users_array[$user->getId()] = $user->getFirstname() . ' ' . $user->getLastname();
        }
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'users' => $users_array
        )));
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the existing team members.",
     *   section="Z_DISABLED",
     *    statusCodes = {
     *     200 = {"Returned when successfully found at least 1 teammember for this campaign.",
     *             "Returned when call was successfull , but there were no teammembers for the campaign"},           
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignTeammembersAction($campaignId) {
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')
                ->find($campaignId);

        $tasks = $this->getDoctrine()->getRepository('TaskBundle:Task')->findByCampaign($campaign);

        if (!$campaign) {

// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

        $teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findBy(['campaign' => $campaign]);

        if (!$teammembers) {
            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'teammembers' => null
            )));
            return $response;
        }

        $return_array = array();

        foreach ($teammembers as $teammember) {
            $member['user_id'] = $teammember->getMember()->getId();
            $member['is_reviewer'] = $teammember->getIsReviewer();
//   $member['is_contributor'] = $teammember->getIsContributor();
//   $member['is_writer'] = $teammember->getIsWriter();
            $member['First Name'] = $teammember->getMember()->getFirstname();
            $member['Last Name'] = $teammember->getMember()->getLastname();
            $member['Title'] = $teammember->getMember()->getTitle();
            $member['Office'] = $teammember->getMember()->getOffice();
            $member['Email Adress'] = $teammember->getMember()->getEmail();
            $member['Phone'] = $teammember->getMember()->getPhone();
            $member['Profile Picture location'] = $teammember->getMember()->getProfilepicture();


            $return_array[] = $member;
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'teammembers' => $return_array
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Update the data on the JTBD screen.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was updated",
     *     403 = {"Invalid API KEY", "This authenticated user does not have access to update this campaign."},
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier for updating JTBD Data."}
     *      },
     *      parameters={
     *          {"name"="brief_outline", "dataType"="text", "required"=false, "description"="Text"},
     *          {"name"="mmo_brandshare", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mmo_penetration", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mmo_salesgrowth", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mmo_othermetric", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mco_brandhealth_bhc", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mco_awareness_increase", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="mco_brandhealth_performance", "dataType"="text", "required"=false, "description"="Text value"},
     *          {"name"="share_voice",            "dataType"="decimal", "required"=false,"description"="Decimal value"  },
     *          {"name"="market_share",           "dataType"="decimal", "required"=false,"description"="Decimal value"  },
     *          {"name"="mac",                    "dataType"="integer", "required"=false,"description"="Integer value"  },
     *          {"name"="campaign_class_id",      "dataType"="integer", "required"=false,"description"="Integer value (1 to 3 momentarely)"  },
     *      }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsJtbdAction($campaignId, Request $request) {
//Grab the current user browsing / using the app.
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

//Validation for Campaign.
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

//////////////////////////////////////////////////////////////
//ONLY THE CAMPAIGN OWNER CAN SET THE JTBD DATA MOMENTARELY
//////////////////////////////////////////////////////////////


        if ($user->hasRole('ROLE_VIEWER')) {
            $response = new Response();
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This authenticated user does not have access to update this campaign.'
                    ))
            );
            return $response;
        }




//        if ($campaign->getUser() != $user) {
//            $response->setStatusCode(403);
//            $response->setContent(json_encode(array(
//                'success' => false,
//                'message' => 'You are not the campaign owner.'
//            )));
//            return $response;
//        }
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
// VALIDATION FOR CHECKING IF THE CURRENT USER HAS THE CONTRIBUTOR/WRITTER ROLE NEEDED
//Grab the current date if needed
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

        $brief_outline = $request->get('brief_outline');
        $mmo_brandshare = $request->get('mmo_brandshare');
        $mmo_penetration = $request->get('mmo_penetration');
        $mmo_salesgrowth = $request->get('mmo_salesgrowth');
        $mmo_othermetric = $request->get('mmo_othermetric');

        $mco_brandhealthbhc = $request->get('mco_brandhealth_bhc');
        $mco_awarenessincrease = $request->get('mco_awareness_increase');
        $mco_brandhealthperformance = $request->get('mco_brandhealth_performance');

//SET THE CAMPAIGN TO THE FIELD VALUES
        //New NOT REQUIRED  fields
        if (!empty($request->get('share_voice'))) {
            $campaign->setSharevoice($request->get('share_voice'));
        }
        if (!empty($request->get('market_share'))) {
            $campaign->setMarketshare($request->get('market_share'));
        }
        if (!empty($request->get('mac'))) {
            $campaign->setMac($request->get('mac'));
        }
        if (!empty($request->get('campaign_class_id'))) {

            $campaign_class = $this->getDoctrine()->getRepository('CampaignBundle:Campaignclass')->find($request->get('campaign_class_id'));
            if ($campaign_class) {
                $campaign->setCampaignclass($campaign_class);
            } else {
                $response->setStatusCode(400);
                $response->setContent(json_encode(array(
                    'success' => false,
                    'message' => 'The campaign_class_id you provided is invalid.'
                )));
                return $response;
            }
        }
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());

        $campaign->setBriefOutline($brief_outline);
        $campaign->setMmoBrandshare($mmo_brandshare);
        $campaign->setMmoPenetration($mmo_penetration);
        $campaign->setMmoSalesgrowth($mmo_salesgrowth);
        $campaign->setMmoOthermetric($mmo_othermetric);
        $campaign->setMcoBrandhealthBhc($mco_brandhealthbhc);
        $campaign->setMcoAwarenessincrease($mco_awarenessincrease);
        $campaign->setMcoBrandhealthPerformance($mco_brandhealthperformance);
        $campaign->setUpdatedAt($updateDate);

        $em->flush();
// CREATE THE METHOD... 
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign JTBD data updated.'
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Add a user to team and specify whether the user is a reviewer.",
     *   section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign's team was updated.",
     *     201 = "New team member created.",
     *     403 = {
     *          "Invalid API KEY", 
     *          "Only contributors and administrators are allowed to add/modify campaign Teammembers.",
     *          "You are a contributor , but you are not allowed to view/edit/modify this campaign due to user-client-region-country combination."
     *     },
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned when the user was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier for updating teammember Data."},
     *          {"name"="userId", "dataType"="string", "description"="User identifier for updating teammember Data."}
     *      },
     *      parameters={
     *          {"name"="is_reviewer",      "dataType"="boolean", "required"=true, "description"="Boolean (1/0) value"},
     *
     *      }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsTeammembersAction($campaignId, $userId, Request $request) {
        $user = $this->getUser();
        $response = new Response();
        $em = $this->getDoctrine()->getManager();


        //Grab the values from the response , if nothing set , default to FALSE ( 0 )
        $is_reviewer = $request->get('is_reviewer') ? $request->get('is_reviewer') : false;


        $validated_as_contrib_or_admin = false;
        if (($user->hasRole('ROLE_CONTRIBUTOR')) || ($user->hasRole('ROLE_ADMINISTRATOR'))) {
            $validated_as_contrib_or_admin = true;
        }


        if (!$validated_as_contrib_or_admin) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Only contributors and administrators are allowed to add/modify campaign Teammembers.'
            )));
            return $response;
        }

        // Validate campaignID:
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);
        if (!$campaign) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Wrong campaign Id.'
            )));
            return $response;
        }


        // Validate if user is allowed to modify team members:
        $current_user_id = $user->getId();

        $current_user = $user;
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);
        if (!$campaign) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Wrong campaign Id.'
            )));
            return $response;
        }

        //Disabled the verification if the user is able to view the campaign. (always assume he is able if he uses this call)
        //$user_can_access_campaign = self::validate_user_is_able_to_view_this_campaign($current_user, $campaign);
        $user_can_access_campaign = true;

        // To re-enable , just uncomment and comment the //true 
        // Admins automatically have access to modify team members:
        if ($user->hasRole('ROLE_ADMINISTRATOR')) {
            $user_can_access_campaign = true;
        }

        if (!$user_can_access_campaign) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'You are a contributor , but you are not allowed to view/edit/modify this campaign due to user-client-region-country combination.'
            )));
            return $response;
        } // End of user is allowed to modify team members validation.


        $user_to_be_member = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($userId);
        if (!$user_to_be_member) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Wrong user Id.'
            )));
            return $response;
        }

        //VALIDATE THAT THE USER TO BE MEMBER IN THIS CAMPAIGN , HAS ACCESS FOR THE CAMPAIGN'S CLIENT-COUNTRY COMBO

        $user_to_be_member_has_access = self::validate_user_is_able_to_view_this_campaign($user_to_be_member, $campaign);

        if (!$user_to_be_member_has_access) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The user you are trying to add as a teammember does not have proper access for this campaign.'
            )));
            return $response;
        }




//Check if user is already a member of the team's campaign
        $teammember_already_exists = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')
                ->findOneBy(['campaign' => $campaign, 'member' => $user_to_be_member]);

        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());


        if ($teammember_already_exists) {

            $teammember = $teammember_already_exists;
            $teammember->setIsReviewer($is_reviewer);
            $campaign->setUpdatedAt($updateDate);
            $em->flush();
            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'message' => 'Team member updated.'
            )));
            return $response;
        } else {
            $teammember = new Teammember();
            $teammember->setCampaign($campaign);
            $teammember->setMember($user_to_be_member);
            $teammember->setIsReviewer($is_reviewer);
            $campaign->setUpdatedAt($updateDate);
            $em->persist($teammember);
            $em->flush();
// ELSE , CREATE A NEW ENTRY INTO THE TEAMMEMBER TABLE
            $response->setStatusCode(201);
            $response->setContent(json_encode(array(
                'success' => true,
                'message' => 'New teammember created.'
            )));
            return $response;
        }
    }

    /**
     * @ApiDoc(
     *    description = "Remove a user from the team.",
     *   section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign's team was updated",
     *     403 = {"Invalid API KEY",
     *           },
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned when the user was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier for updating teammember Data."},
     *          {"name"="userId", "dataType"="string", "description"="User identifier for updating teammember Data."}
     *      },
     *     
     * )
     * @return array
     * @View()
     */
    public function deleteCampaignsTeammemberAction($campaignId, $userId) {
        $user = $this->getUser();
        $response = new Response();
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Wrong campaign Id.')));
            return $response;
        }
        $user_to_be_removed = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($userId);
        if (!$user_to_be_removed) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array('success' => false, 'message' => 'Wrong user Id.')));
            return $response;
        }


///VALIDATION NEEDED. ONLY CONTRIBUTORS THAT HAVE ACCESS && ADMINISTRATORS CAN ACCESS THIS CALL
///VALIDATION NEEDED. ONLY CONTRIBUTORS THAT HAVE ACCESS && ADMINISTRATORS CAN ACCESS THIS CALL
///VALIDATION NEEDED. ONLY CONTRIBUTORS THAT HAVE ACCESS && ADMINISTRATORS CAN ACCESS THIS CALL
///VALIDATION NEEDED. ONLY CONTRIBUTORS THAT HAVE ACCESS && ADMINISTRATORS CAN ACCESS THIS CALL
///VALIDATION NEEDED. ONLY CONTRIBUTORS THAT HAVE ACCESS && ADMINISTRATORS CAN ACCESS THIS CALL
//Check if there is anything to remove
        $teammember_exists = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')
                ->findOneBy(['campaign' => $campaignId, 'member' => $user_to_be_removed]);

        if ($teammember_exists) {


            $tasks_of_this_campaign = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy([
                'campaign' => $campaign,
                'owner' => $user_to_be_removed
            ]);
            if ($tasks_of_this_campaign) {
                foreach ($tasks_of_this_campaign as $task_of_this_campaign) {
                    $task_of_this_campaign->setOwner(NULL);
                }

                $em->flush();
            }


//Fetch this campaign's tasks , and for each task , verify if the user is assigned as a taskowner.
//If he is , set the taskowner of that task to NULL.





            $campaign->setUpdatedAt($updateDate);
            $em->remove($teammember_exists);

            $em->flush();
            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'message' => 'Team member removed.'
            )));
            return $response;
        }
        $response->setStatusCode(403);
        $response->setContent(json_encode(array(
            'success' => false,
            'message' => 'Nothing to remove.'
        )));
        return $response;
    }

    /**
     * Method returns array with campaign fields used in POST or PUT campaign method.
     */
    public function campaignFieldsToArrayAction($campaignId) {

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);

        $campaignFields = array(
            'name' => $campaign->getName(),
            'client' => $campaign->getClient()->getName(),
            'country' => $campaign->getCountry()->getName(),
            'brand' => $campaign->getBrand()->getName(),
            'product' => $campaign->getProduct()->getName(),
            'productline' => $campaign->getProductline()->getName(),
            'division' => $campaign->getDivision()->getName(),
            'status' => $campaign->getCampaignstatus() ? $campaign->getCampaignstatus()->getName() : null,
            'completion_date' => date('Y-m-d', $campaign->getCompletionDate()->getTimestamp()),
            'client_deliverabledate' => date('Y-m-d', $campaign->getClientDeliverabledate()->getTimestamp())
        );

        return $campaignFields;
    }

// End of modifiable campaign fields method().

    /**
     * @ApiDoc(
     *    description = "Returns Objectives data for charts.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = {
     *          "Invalid API KEY",
     *          "The lightdata set does not include any data for Objectives. Cannot generate SelectedTasksInformation data without it.",
     *     },
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned When the lightdata for that campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignSelectedtasksinformationAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);



        if (!$campaign) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        $lightdata_id = $campaign->getLightdata();

        $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->findOneById($lightdata_id);

        if (!$lightdata) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Lightdata does not exist for this campaign.'
                    ))
            );
            return $response;
        }
        $objectives = $this->getDoctrine()->getRepository('LightdataBundle:ObjectiveLD')->findBy(['lightdata' => $lightdata]);

        if (count($objectives) == 0) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The lightdata set does not include any data for Objectives. Cannot generate SelectedTasksInformation data without it.'
            )));
            return $response;
        }

        foreach ($objectives as $objective) {

            $return_array[] = array(
                'Uid' => $objective->getId(),
                'Name' => $objective->getName(),
                'HtmlColor' => $objective->getHtmlcolor(),
                'Selected' => $objective->getSelected(),
                'Score' => $objective->getScore(),
            );
        } // End of tasks foreach() loop.

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'Objectives' => $return_array
                        )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns Groupings and Touchpoint data for charts.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned when the campaign was not found in database",
     *         "Returned when the lightdata for that campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignChannelrankingAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);



        if (!$campaign) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($campaign->getLightdata());
        if (!$lightdata) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Lightdata does not exist for this campaign.'
                    ))
            );
            return $response;
        }


        $touchpoints = $this->getDoctrine()->getRepository('LightdataBundle:TouchpointLD')->findByLightdata($lightdata);
        $groupings = $this->getDoctrine()->getRepository('LightdataBundle:GroupingLD')->findByLightdata($lightdata);

        foreach ($touchpoints as $touchpoint) {

            $objectivescores = $this->getDoctrine()->getRepository('LightdataBundle:TouchpointObjectiveScoreLD')->findByTouchpoint($touchpoint);
            $objectivescores_array = array();
            foreach ($objectivescores as $objectivescore) {
                $objectivescores_array[] = $objectivescore->getValue();
            }

            $attributescores = $this->getDoctrine()->getRepository('LightdataBundle:TouchpointAttributeScoreLD')->findByTouchpoint($touchpoint);
            $attributescores_array = array();
            foreach ($attributescores as $attributescore) {
                $attributescores_array[] = $attributescore->getValue();
            }
            $return_array['Touchpoints'][] = array(
                'Name' => $touchpoint->getName(),
                'LocalName' => $touchpoint->getLocalname(),
                'HtmlColor' => $touchpoint->getHtmlcolor(),
                'Selected' => $touchpoint->getSelected(),
                'AggObjectiveScore' => $touchpoint->getAggobjectivescore(),
                'ObjectiveScores' => $objectivescores_array,
                'AttributeScores' => $attributescores_array,
            );
        }

        foreach ($groupings as $grouping) {
            $categories = $this->getDoctrine()->getRepository('LightdataBundle:GroupingCategoryLD')->findByGrouping($grouping);
            $categories_array = array();
            $initial_count = 0;
            foreach ($categories as $category) {
                $categories_array[$initial_count]['Name'] = $category->getName();
                $categories_array[$initial_count]['Htmlcolor'] = $category->getHtmlColor();
                $initial_count++;
            }


            $touchpointcategorymaps = $this->getDoctrine()->getRepository('LightdataBundle:GroupingTouchpointCategoryMapLD')->findByGrouping($grouping);
            $touchpointcategorymaps_array = array();
            foreach ($touchpointcategorymaps as $touchpointcategorymap) {
                $touchpointcategorymaps_array[] = $touchpointcategorymap->getName() . ' : ' . $touchpointcategorymap->getValue();
            }

            $return_array['Groupings'][] = array(
                'Name' => $grouping->getName(),
                'Categories' => $categories_array,
                'TouchpointCategoryMap' => $touchpointcategorymaps_array,
            );
        }


        $return_array['CurrentGroupingIndex'] = $lightdata->getCurrentgroupingindex();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'ChannelRanking' => $return_array
                        )
        ));


        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns Budget Allocation data for charts.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = {"Invalid API KEY", "The lightdata you requested has no allocated touchpoints data in it."},
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned When the lightdata for that campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignChannelallocationAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);



        if (!$campaign) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($campaign->getLightdata());
        if (!$lightdata) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Lightdata does not exist for this campaign.'
                    ))
            );
            return $response;
        }

//die('dead');
        $budgetallocation = $this->getDoctrine()->getRepository('LightdataBundle:BudgetAllocationLD')->findByLightdata($lightdata);

//print_r(count($budgetallocation));


        $allocatedtouchpoints = $this->getDoctrine()->getRepository('LightdataBundle:BAAllocatedTouchpointLD')->findByBudgetallocation($budgetallocation);

        if (count($allocatedtouchpoints) == 0) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The lightdata you requested has no allocated touchpoints data in it.'
            )));

            return $response;
        }

        $allocatedtouchpoints_array = array();
        foreach ($allocatedtouchpoints as $allocatedtouchpoint) {

            $ATallocation = $this->getDoctrine()->getRepository('LightdataBundle:BAATAllocationLD')->findOneByAllocatedtouchpoint($allocatedtouchpoint);
            $ATresult = $this->getDoctrine()->getRepository('LightdataBundle:BAATAResultLD')->findOneByAllocation($ATallocation);
            $ATindividualperformances = $this->getDoctrine()->getRepository('LightdataBundle:BAATARIndividualPerformanceLD')->findByResult($ATresult);
            $ATindividualperformances_array = array();
            foreach ($ATindividualperformances as $ATindividualperformance) {
                $ATindividualperformances_array[] = $ATindividualperformance->getValue();
            }

            $allocatedtouchpoints_array[] = array(
                "TouchpointName" => $allocatedtouchpoint->getTouchpointname(),
                'Allocation' => array(
                    'Budget' => $ATallocation->getBudget(),
                    'CostPerGrp' => $ATallocation->getCostpergrp(),
                    'GRP' => $ATallocation->getGrp(),
                    'Result' => array(
                        'GlobalPerformance' => $ATresult->getGlobalperformance(),
                        'Reach' => $ATresult->getReach(),
                        'IndividualPerformance' => $ATindividualperformances_array,
                    ),
                ),
            );
        }
        $return_array['AllocatedTouchpoints'] = $allocatedtouchpoints_array;


        $total = $this->getDoctrine()->getRepository('LightdataBundle:BATotalLD')->findOneByBudgetallocation($budgetallocation);
        $TOallocation = $this->getDoctrine()->getRepository('LightdataBundle:BATOAllocationLD')->findOneByAllocatedtouchpoint($total);
        $TOresult = $this->getDoctrine()->getRepository('LightdataBundle:BATOAResultLD')->findOneByAllocation($TOallocation);
        $TOindividualperformances = $this->getDoctrine()->getRepository('LightdataBundle:BATOARIndividualPerformanceLD')->findByResult($TOresult);
        $TOindividualperformances_array = array();
        foreach ($TOindividualperformances as $TOindividualperformance) {
            $TOindividualperformances_array[] = $TOindividualperformance->getValue();
        }


        $return_array['Total'] = array(
            'TouchpointName' => $total->getTouchpointName(),
            'Allocation' => array(
                'Budget' => $TOallocation->getBudget(),
                'CostPerGrp' => $TOallocation->getCostpergrp(),
                'GRP' => $TOallocation->getGrp(),
                'Result' => array(
                    'GlobalPerformance' => $TOresult->getGlobalperformance(),
                    'Reach' => $TOresult->getReach(),
                    'IndividualPerformance' => $TOindividualperformances_array,
                ),
            ),
        );

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'ChannelAllocation' => $return_array,
                        )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns time allocation data for charts.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = {"Invalid API KEY", "Timeallocation within this lightdata set has no total data in it. Unable to generate Weekly Phasing without it."},
     *     404 = {
     *         "Returned when the campaign was not found in database",
     *         "Returned when the lightdata for that campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignWeeklyphasingAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);

        if (!$campaign) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($campaign->getLightdata());
        if (!$lightdata) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Lightdata does not exist for this campaign.'
                    ))
            );
            return $response;
        }


        $timeallocation = $this->getDoctrine()->getRepository('LightdataBundle:TimeAllocationLD')->findByLightdata($lightdata);


///GRAB THE TIMEALLOCATION ALLOCATEDTOUCHPOINTS DATA
        $allocatedtouchpoints = $this->getDoctrine()->getRepository('LightdataBundle:TAAllocatedTouchpointLD')->findByTimeallocation($timeallocation);
        $allocatedtouchpoints_array = array();
        foreach ($allocatedtouchpoints as $allocatedtouchpoint) {
            $ATallocationsbyperiod = $this->getDoctrine()->getRepository('LightdataBundle:TAATAllocationByPeriod')->findByAllocatedtouchpoint($allocatedtouchpoint);

            $allocations_by_period_array = array();
            foreach ($ATallocationsbyperiod as $allocation_by_period) {

                $ATResult = $this->getDoctrine()->getRepository('LightdataBundle:TAATABPResult')->findOneByAllocationbyperiod($allocation_by_period);
                $ATindividualperformances = $this->getDoctrine()->getRepository('LightdataBundle:TAATABPRIndividualPerformance')->findByResult($ATResult);
                $ATindividualperformances_array = array();
                foreach ($ATindividualperformances as $ATindividualperformance) {
                    $ATindividualperformances_array[] = $ATindividualperformance->getValue();
                }
                $allocations_by_period_array[] = array(
                    'Budget' => $allocation_by_period->getBudget(),
                    'CostPerGrp' => $allocation_by_period->getCostpergrp(),
                    'GRP' => $allocation_by_period->getGrp(),
                    'Result' => array(
                        'GlobalPerformance' => $ATResult->getGlobalperformance(),
                        'Reach' => $ATResult->getReach(),
                        'IndividualPerformance' => $ATindividualperformances_array,
                    ),
                );
            }
            $allocatedtouchpoints_array[] = array(
                'AllocationByPeriod' => $allocations_by_period_array,
                'TouchpointName' => $allocatedtouchpoint->getTouchpointName(),
                'ReachFrequency' => $allocatedtouchpoint->getReachfrequency(),
            );
        }

///GRAB THE TIMEALLOCATION TOTAL DATA

        $total = $this->getDoctrine()->getRepository('LightdataBundle:TATotalLD')->findOneByTimeallocation($timeallocation);


        if (count($total) == 0) {

            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Timeallocation within this lightdata set has no total data in it. Unable to generate Weekly Phasing without it.'
            )));
            return $response;
        }

        $TOallocationsbyperiod = $this->getDoctrine()->getRepository('LightdataBundle:TATOAllocationByPeriod')->findByAllocatedtouchpoint($total);
        $to_allocations_by_period_array = array();
        foreach ($TOallocationsbyperiod as $TOallocationbyperiod) {

            $TOResult = $this->getDoctrine()->getRepository('LightdataBundle:TATOABPResult')->findOneByAllocationbyperiod($TOallocationbyperiod);
            $TOindividualperformances = $this->getDoctrine()->getRepository('LightdataBundle:TATOABPRIndividualPerformance')->findByResult($TOResult);
            $TOindividualperformances_array = array();
            foreach ($TOindividualperformances as $TOindividualperformance) {
                $TOindividualperformances_array[] = $TOindividualperformance->getValue();
            }
            $to_allocations_by_period_array[] = array(
                'Budget' => $TOallocationbyperiod->getBudget(),
                'CostPerGrp' => $TOallocationbyperiod->getCostpergrp(),
                'GRP' => $TOallocationbyperiod->getGrp(),
                'Result' => array(
                    'GlobalPerformance' => $TOResult->getGlobalperformance(),
                    'Reach' => $TOResult->getReach(),
                    'IndividualPerformance' => $TOindividualperformances_array,
                ),
            );
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'WeeklyPhasing' => array(
                'AllocatedTouchpoints' => $allocatedtouchpoints_array,
                'Total' => array(
                    'AllocationByPeriod' => $to_allocations_by_period_array,
                    'TouchpointName' => $total->getTouchpointname(),
                    'ReachFrequency' => $total->getReachfrequency(),
                ),
                'Campaign_Start_Date' => $campaign->getStartDate() ? date('Y-m-d', $campaign->getStartDate()->getTimestamp()) : null,
            )
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns whatif scenario data for charts.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *         "Returned When the lightdata for that campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignVideoneutralAction($campaignId) {

        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);

        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($campaign->getLightdata());
        if (!$lightdata) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Lightdata does not exist for this campaign.'
                    ))
            );
            return $response;
        }

        $whatifresult = $this->getDoctrine()->getRepository('LightdataBundle:WhatIfResult')->findOneByLightdata($lightdata);

        if (!$whatifresult) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no whatifresult data.'
                    ))
            );
            return $response;
        }


        $what_if_result_return_array = array();


        $wirconfig = $this->getDoctrine()->getRepository('LightdataBundle:WIRConfig')->findOneByWhatifresult($whatifresult);
        $wircoptimizedfunction = $this->getDoctrine()->getRepository('LightdataBundle:WIRCOptimizedFunction')->findOneByConfig($wirconfig);

        $what_if_result_return_array['Config'] = array(
            'FirstPeriod' => $wirconfig->getFirstperiod(),
            'LastPeriod' => $wirconfig->getLastperiod(),
            'SourceBudget' => $wirconfig->getSourcebudget(),
            'BudgetMinPercent' => $wirconfig->getBudgetminpercent(),
            'BudgetMaxPercent' => $wirconfig->getBudgetmaxpercent(),
            'BudgetStepPercent' => $wirconfig->getBudgetsteppercent(),
            'HasCurrentMix' => $wirconfig->getHascurrentmix(),
            'HasSingleTouchpointMix' => $wirconfig->getHassingletouchpointmix(),
            'HasOptimizedMix' => $wirconfig->getHasoptimizedmix(),
            'OptimizedFunction' => array(
                'CalculationType' => $wircoptimizedfunction->getCalculationtype(),
                'AttributeIndex' => $wircoptimizedfunction->getAttributeindex(),
            )
        );


        $wirpoints = $this->getDoctrine()->getRepository('LightdataBundle:WIRPoint')->findByWhatifresult($whatifresult);

        foreach ($wirpoints as $wirpoint) {

            $currentmix = $this->getDoctrine()->getRepository('LightdataBundle:WIRPCurrentMix')->findByPoint($wirpoint);
            $optimizedmix = $this->getDoctrine()->getRepository('LightdataBundle:WIRPOptimizedMix')->findByPoint($wirpoint);
            $singletouchpointmix = $this->getDoctrine()->getRepository('LightdataBundle:WIRPSingleTouchpointMix')->findByPoint($wirpoint);

            $WIRPCMdetails = $this->getDoctrine()->getRepository('LightdataBundle:WIRPCMDetail')->findByCurrentmix($currentmix);
            $WIRPOMdetails = $this->getDoctrine()->getRepository('LightdataBundle:WIRPOMDetail')->findByOptimizedmix($optimizedmix);
            $WIRPSTMdetails = $this->getDoctrine()->getRepository('LightdataBundle:WIRPSTMDetail')->findBySingletouchpointmix($singletouchpointmix);

            $WIRPCMtotal = $this->getDoctrine()->getRepository('LightdataBundle:WIRPCMTotal')->findOneByCurrentmix($currentmix);
            $WIRPOMtotal = $this->getDoctrine()->getRepository('LightdataBundle:WIRPOMTotal')->findOneByOptimizedmix($optimizedmix);
            $WIRPSTMtotal = $this->getDoctrine()->getRepository('LightdataBundle:WIRPSTMTotal')->findOneBySingletouchpointmix($singletouchpointmix);

            $WIRPCM_details_array = array();
            foreach ($WIRPCMdetails as $WIRPCM_detail) {
                $WIRPCM_details_array[] = array(
                    'TouchpointName' => $WIRPCM_detail->getTouchpointname(),
                    'Budget' => $WIRPCM_detail->getBudget(),
                    'FunctionValue' => $WIRPCM_detail->getFunctionvalue(),
                );
            }
            $WIRPOM_details_array = array();
            foreach ($WIRPOMdetails as $WIRPOM_detail) {
                $WIRPOM_details_array[] = array(
                    'TouchpointName' => $WIRPOM_detail->getTouchpointname(),
                    'Budget' => $WIRPOM_detail->getBudget(),
                    'FunctionValue' => $WIRPOM_detail->getFunctionvalue(),
                );
            }
            $WIRPSTM_details_array = array();
            foreach ($WIRPSTMdetails as $WIRPSTM_detail) {
                $WIRPSTM_details_array[] = array(
                    'TouchpointName' => $WIRPSTM_detail->getTouchpointname(),
                    'Budget' => $WIRPSTM_detail->getBudget(),
                    'FunctionValue' => $WIRPSTM_detail->getFunctionvalue(),
                );
            }


            $what_if_result_return_array['Points'][] = array(
                'StepPosition' => $wirpoint->getStepposition(),
                'ActualPercent' => $wirpoint->getActualpercent(),
                'CurrentMix' => array(
                    'Details' => $WIRPCM_details_array,
                    'Total' => array(
                        'TouchpointName' => $WIRPCMtotal ? $WIRPCMtotal->getTouchpointname() : null,
                        'Budget' => $WIRPCMtotal ? $WIRPCMtotal->getBudget() : null,
                        'FunctionValue' => $WIRPCMtotal ? $WIRPCMtotal->getFunctionvalue() : null,
                    ),
                ),
                'OptimizedMix' => array(
                    'Details' => $WIRPOM_details_array,
                    'Total' => array(
                        'TouchpointName' => $WIRPOMtotal ? $WIRPOMtotal->getTouchpointname() : null,
                        'Budget' => $WIRPOMtotal ? $WIRPOMtotal->getBudget() : null,
                        'FunctionValue' => $WIRPOMtotal ? $WIRPOMtotal->getFunctionvalue() : null,
                    ),
                ),
                'SingleTouchpointMix' => array(
                    'Details' => $WIRPSTM_details_array,
                    'Total' => array(
                        'TouchpointName' => $WIRPSTMtotal ? $WIRPSTMtotal->getTouchpointname() : null,
                        'Budget' => $WIRPSTMtotal ? $WIRPSTMtotal->getBudget() : null,
                        'FunctionValue' => $WIRPSTMtotal ? $WIRPSTMtotal->getFunctionvalue() : null,
                    ),
                ),
            );
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'WhatIfResult' => $what_if_result_return_array,
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Update the Real Lives URL and passcode.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was updated",
     *     403 = {"Invalid API KEY",
     *           },
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier for updating JTBD Data."}
     *      },
     *      parameters={
     *          {"name"="real_lives_url", "dataType"="text", "required"=true, "description"="the url"},
     *          {"name"="real_lives_password", "dataType"="text", "required"=true, "description"="the password"},
     *      }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsReallivesAction($campaignId, Request $request) {
//Grab the current user browsing / using the app.
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

//Validation for Campaign.
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

//NO VALIDATION YET FOR WHO CAN CHANGE THE REALLIVES FOR A CAMPAIGN
//NO VALIDATION YET FOR WHO CAN CHANGE THE REALLIVES FOR A CAMPAIGN
//ALSO NO VALIDATION YET FOR THE INPUT
//ALSO NO VALIDATION YET FOR THE INPUT

        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

        $reallivesurl = $request->get('real_lives_url');
        $reallivespassword = $request->get('real_lives_password');
        $old_completeness = $campaign->getCompleteness();
        $campaign->setReallivesurl($reallivesurl);
        $campaign->setReallivespassword($reallivespassword);
        $campaign->setUpdatedat($updateDate);
        $updated_completeness = self::recalculate_campaign_completeness($campaign);
        $campaign->setCompleteness($updated_completeness);
        $em->flush();
        $new_completeness = $campaign->getCompleteness();

        //ADD RECALCULATION OF COMPLETENESS

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign Real Lives data updated.',
            'old_completeness' => $old_completeness,
            'new_completeness' => $new_completeness
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the Real Lives URL and passcode.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned when the campaign was not found in database",
     *         
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignReallivesAction($campaignId) {
        $user = $this->getUser();

        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

        $real_lives_url = $campaign->getReallivesurl();
        $real_lives_password = $campaign->getReallivespassword();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'campaign_id' => $campaign->getId(),
            'real_lives_url' => $real_lives_url ? $real_lives_url : null,
            'real_lives_password' => $real_lives_password ? $real_lives_password : null,
                        )
        ));
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Update the Campaign Idea title/description fields.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was updated",
     *     403 = {"Invalid API KEY",
     *           },
     *     404 = {
     *         "Returned when the campaign was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier for updating JTBD Data."}
     *      },
     *      parameters={
     *          {"name"="campaign_idea_title", "dataType"="text", "required"=true, "description"="the idea text"},
     *          {"name"="campaign_idea", "dataType"="text", "required"=true, "description"="the idea text"},
     *      }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsIdeaAction($campaignId, Request $request) {
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

//NO VALIDATION YET FOR WHO CAN CHANGE THE IDEA FOR A CAMPAIGN
//NO VALIDATION YET FOR WHO CAN CHANGE THE IDEA FOR A CAMPAIGN
//ALSO NO VALIDATION YET FOR THE INPUT
//ALSO NO VALIDATION YET FOR THE INPUT

        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

        $idea_title = $request->get('campaign_idea_title');
        $idea_data = $request->get('campaign_idea');

        $campaign->setCampaignideatitle($idea_title);
        $campaign->setCampaignidea($idea_data);
        $campaign->setUpdatedat($updateDate);

        $em->flush();
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign IDEA title & data updated.'
        )));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the Campaign Idea title/description fields.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *        
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignIdeaAction($campaignId) {
        $user = $this->getUser();

        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

        $campaign_idea_title = $campaign->getCampaignideatitle();
        $campaign_idea = $campaign->getCampaignidea();

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'campaign_id' => $campaign->getId(),
            'campaign_idea_title' => $campaign_idea_title ? $campaign_idea_title : null,
            'campaign_idea' => $campaign_idea ? $campaign_idea : null,
                        )
                )
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display all clients. The reserved value 'all_clients', which is used to set a user's campaign permissions, should be hidden from the Create/Edit Campaign screen.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = "The database has no clients momentarely.",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsClientsAction() {
        $user = $this->getUser();
        $response = new Response();
        $clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findAllWithout_all_clients();
        if (!$clients) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The database has no clients momentarely.'
            )));
        }
        $clients_array = array();
        foreach ($clients as $client) {
            //print_r($client->getName());
            $can_view = Self::validate_user_can_view_this_client($user, $client);
            if ($can_view) {
                $clients_array[$client->getId()] = ucfirst($client->getName());
            }
            if ($client->getName() == 'temp_client') {
                $clients_array[$client->getId()] = ucfirst($client->getName());
            }
        }
        //die();
        // Order Clients alphabetically:


        asort($clients_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'clients' => $clients_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Return a list of the countries which a user is allowed to see due to his permissions.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = "The database has no countries momentarely.",
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    },
     *    parameters = {
     *          {"name"="client_id", "dataType"="integer", "required"=true, "description"="The client id"},
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsCountriesAction(Request $request) {
        $user = $this->getUser();

        $response = new Response();


        if (empty($request->get('client_id'))) {
            $response->setStatusCode(400);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Client id must be provided in the call.'
            )));
            return $response;
        }
        $client_id = $request->get('client_id');
        $client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->find($client_id);
        if (!$client) {
            $response->setStatusCode(400);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no client for that id.'
            )));
            return $response;
        }

//        $countries = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findAllWithout_temp_country();
        $countries = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findAll();

        if (!$countries) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'The database has no countries momentarely.'
            )));
        }

        $total = 0;
        $countries_array = array();
        foreach ($countries as $country) {
            $can_view = Self::validate_user_can_view_this_country_for_client($user, $client, $country);
            if ($can_view) {
                $countries_array[$country->getId()] = $country->getName();
                $total++;
            }
            if (($total > 0) && ($country->getName() == 'temp_country')) {
                $countries_array[$country->getId()] = ucfirst($country->getName());
            }
        }



        asort($countries_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            //'total(debug)' => $total,
            'countries' => $countries_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the divisions of a client.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = {
     *          "Returned when a client could not be found for the specified client_id",
     *          "Returned when no divisions could be found for that existing client."
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *     requirements = {
     *       {
     *           "name"="client_id",
     *           "dataType"="string",
     *           "description"="The client unique id"
     *       },
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsDivisionsAction(Request $request) {
        $user = $this->getUser();
        $response = new Response();

        $client_id = $request->get('client_id');
        $client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneById($client_id);

        if (!$client) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no client for that client id.'
            )));
            return $response;
        }
        $divisions = $this->getDoctrine()->getRepository('CampaignBundle:Division')->findBy(['client' => $client]);
        if (!$divisions) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This client does not have any divisions associated.'
            )));
            return $response;
        }
        $divisions_array = array();
        foreach ($divisions as $division) {
            $divisions_array[$division->getId()] = ucfirst($division->getName());
        }

        // Order Divisions alphabetically:
        asort($divisions_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'divisions' => $divisions_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the brands of a particular client.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = {"Returned when a division could not be found for the specified division_id", "Returned when no brands could be found for that existing division."},
     *     500 = "Header x-wsse does not exist"
     *    },
     *     requirements = {
     *       {
     *           "name"="division_id",
     *           "dataType"="string",
     *           "description"="The division unique id"
     *       },
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsBrandsAction(Request $request) {
        $user = $this->getUser();
        $response = new Response();

        $division_id = $request->get('division_id');
        $division = $this->getDoctrine()->getRepository('CampaignBundle:Division')->findOneById($division_id);

        if (!$division) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no division for that division id.'
            )));
            return $response;
        }

        $brands = $this->getDoctrine()->getRepository('CampaignBundle:Brand')->findBy(['division' => $division]);
        if (!$brands) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This division does not have any brands associated.'
            )));
            return $response;
        }

        $brands_array = array();
        foreach ($brands as $brand) {
            $brands_array[$brand->getId()] = ucfirst($brand->getName());
        }

        // Order Brands alphabetically:
        asort($brands_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'brands' => $brands_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the productlines of a brand.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = {"Returned when a brand could not be found for the specified brand_id", "Returned when no productlines could be found for that existing brand."},
     *     500 = "Header x-wsse does not exist"
     *    },
     *     requirements = {
     *       {
     *           "name"="brand_id",
     *           "dataType"="string",
     *           "description"="The brand unique id"
     *       },
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsProductlinesAction(Request $request) {
        $user = $this->getUser();
        $response = new Response();

        $brand_id = $request->get('brand_id');
        $brand = $this->getDoctrine()->getRepository('CampaignBundle:Brand')->findOneById($brand_id);

        if (!$brand) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no brand for that brand id.'
            )));
            return $response;
        }

        $productlines = $this->getDoctrine()->getRepository('CampaignBundle:Productline')->findBy(['brand' => $brand]);
        if (!$productlines) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This brand does not have any productlines associated.'
            )));
            return $response;
        }

        $productlines_array = array();
        foreach ($productlines as $productline) {
            $productlines_array[$productline->getId()] = ucfirst($productline->getName());
        }

        // Order Product Lines alphabetically:
        asort($productlines_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'productlines' => $productlines_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns the Products Options array for a specified productline.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the request is without errors",
     *     403 = "Invalid API KEY",
     *     404 = {"Returned when a productline could not be found for the specified productline_id",
     *            "Returned when no products could be found for that existing productline."},
     *     500 = "Header x-wsse does not exist"
     *    },
     *     requirements = {
     *       {
     *           "name"="productline_id",
     *           "dataType"="string",
     *           "description"="The productline unique id"
     *       },
     *      {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *      }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getOptionsProductsAction(Request $request) {
        $user = $this->getUser();
        $response = new Response();

        $productline_id = $request->get('productline_id');
        $productline = $this->getDoctrine()->getRepository('CampaignBundle:Productline')->findOneById($productline_id);

        if (!$productline) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'There is no productline for that productline id.'
            )));
            return $response;
        }

        $products = $this->getDoctrine()->getRepository('CampaignBundle:Product')->findBy(['productline' => $productline]);
        if (!$products) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This productline does not have any products associated.'
            )));
            return $response;
        }

        $products_array = array();
        foreach ($products as $product) {
            $products_array[$product->getId()] = ucfirst($product->getName());
        }

        // Order Products alphabetically:
        asort($products_array);

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'products' => $products_array,
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Used to delete a campaign by marking it as not visible. This notvisible field can be used as a flag if you want to display hidden campaigns to Administrators.",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the task was updated",
     *     403 = {"Invalid API KEY",
     *           },
     *     404 = {
     *         "Returned When the campaign was not found in database",
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *      requirements={
     *          {"name"="campaignId", "dataType"="string", "description"="Campaign identifier."}
     *      },
     *      parameters={
     *          {"name"="not_visible", "dataType"="boolean", "required"=true, "description"="Not visible TRUE or FALSE (1/0)"},
     *      }
     * )
     * @return array
     * @View()
     */
    public function putCampaignsNotvisibleAction($campaignId, Request $request) {
        $user = $this->getUser();
        $response = new Response();
        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneById($campaignId);

        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }

//NO VALIDATION YET FOR WHO CAN CHANGE THE NOT VISIBLE FOR A CAMPAIGN
//NO VALIDATION YET FOR WHO CAN CHANGE THE NOT VISIBLE FOR A CAMPAIGN
//ALSO NO VALIDATION YET FOR THE INPUT
//ALSO NO VALIDATION YET FOR THE INPUT

        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());
        $em = $this->getDoctrine()->getManager();

        $notvisible = $request->get('not_visible');


        $campaign->setNotVisible($notvisible);
        $campaign->setUpdatedat($updateDate);

        if ($notvisible == 1) {
            $extramessage = "Campaign is now disabled";
        } elseif ($notvisible == 0) {
            $extramessage = "Campaign is now enabled";
        } else {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid input provided ! Use 1 or 0 only.'
            )));
            return $response;
        }

        $em->flush();
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'success' => true,
            'message' => 'Campaign not_visible state updated. ' . $extramessage
        )));

        return $response;
    }

    function validate_user_can_view_campaign($user, $campaign) {

        $validated_to_display = false;
        $the_campaign_country = $campaign->getCountry();
        $the_campaign_client = $campaign->getClient();
        $the_campaign_region = $the_campaign_country->getRegion();
        $global_region = $this->getDoctrine()->getRepository('CampaignBundle:Region')->find(1);
        $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');
        $temp_client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
        $temp_country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneByName('temp_country');

//CASE 1.   
//The user is an administrator , he can see all the campaigns.
        $user_is_admin = $user->hasRole('ROLE_ADMINISTRATOR');

//CASE 2
//The user is allowed to see all countries and all regions for this client.
        $user_global_this_client = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $the_campaign_client,
            'region' => $global_region,
            'all_countries' => true,
        ]);

//CASE 3
//The user is allowed to see all clients for a specific country.
        $user_all_clients_this_country_false = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $all_clients,
            'country' => $the_campaign_country,
            'all_countries' => false,
        ]);

//CASE 4
//The user is allowed to see all clients in a specific region.
        $user_all_clients_one_region_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $all_clients,
            'country' => NULL,
            'region' => $the_campaign_region,
            'all_countries' => true,
        ]);

//CASE 5
//The user is allowed to see a client in a specific country.
        $user_client_country_false = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $the_campaign_client,
            'country' => $the_campaign_country,
            'all_countries' => false,
        ]);
//CASE 6
        $user_client_region_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $the_campaign_client,
            'region' => $the_campaign_region,
            'all_countries' => true,
        ]);
//CASE 7
        $user_all_clients_all_regions_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
            'user' => $user,
            'client' => $all_clients,
            'region' => $global_region,
            'all_countries' => true,
        ]);

        if ($user_is_admin ||
                $user_client_country_false ||
                $user_client_region_true ||
                $user_all_clients_this_country_false ||
                $user_all_clients_one_region_true ||
                $user_global_this_client ||
                $user_all_clients_all_regions_true) {
            $validated_to_display = true;
        }

        return $validated_to_display;
    }

    /**
     * Function to calculate the completeness of a campaign.
     * 
     * @param type $campaign
     * @return int
     */
    public function recalculate_campaign_completeness($campaign) {
        $completeness = 0;
        $tasks = $campaign->getTasks();

        //$em = $this->getDoctrine()->getManager();

        foreach ($tasks as $task) {
            $taskstatus = $task->getTaskstatus()->getName();
            if ($taskstatus == "Completed") {
                $completeness += 2;
            }
            if ($taskstatus == "Submitted") {
                $validated = $this->validate_task_requirements_are_met($task);
                if ($validated) {
                    $completeness += 1;
                }
            }
            if ($taskstatus == "Open") {
                $validated = $this->validate_task_requirements_are_met($task);
                if ($validated) {
                    $completeness += 1;
                }
            }
        }

        $campaign->setCompleteness($completeness);

        return $completeness;
    }

    function validate_task_requirements_are_met($task) {
        /////////////////////////////////////////////////
        //CHANGE THIS TO FALSEEE
        ////////////////////////////
        $is_validated = false;
        /////////////////////////////////
        /////////////////////////////////
        //$task = $this->getDoctrine()->getRepository('TaskBundle:Task')->find($task);
        $campaign = $task->getCampaign();

        switch ($task->getTaskname()->getName()) {
            case "JTBD":
                $campaign_start_date = $campaign->getStartdate();
                if ($campaign_start_date) {
                    $is_validated = true;
                }
                break;
            case "Comm Tasks":
//if ANY OF THE the Matrix Objective\<OBJECTIVE NAME>\Score > 0 , is validated.
                $lightdata_id = $campaign->getLightdata();
                if ($lightdata_id) {
                    $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($lightdata_id);
                    if ($lightdata) {
                        $objectives = $this->getDoctrine()->getRepository('LightdataBundle:ObjectiveLD')->findByLightdata($lightdata);

                        foreach ($objectives as $objective_value) {

                            $score = $objective_value->getScore();
                            if ($score > 0) {
                                $is_validated = true;
                            }
                        }
                    }
                }
                break;

            case "Real Lives":
// if the campaign has real lives url (not null) value , then is validated
                $reallivesurl = $campaign->getReallivesurl();
                if ($reallivesurl) {
                    $is_validated = true;
                }
                break;
            case "Media Idea":
// if there is a file uploadedd for this campaign with file_type_id = 15 , and attached to this task , then is validated
/// 
                $fileType = $this->getDoctrine()->getRepository('CampaignBundle:Filetype')->findOneById(15);
                $fileQuery = $this->getDoctrine()->getRepository('FileBundle:File')->createQueryBuilder('f')
                        ->where('f.task = :task AND f.fileType = :fileType')
                        ->orderBy('f.updatedAt', 'DESC')
                        ->setMaxResults(1)
                        ->setParameter('task', $task)
                        ->setParameter('fileType', $fileType)
                        ->getQuery();
                $file = $fileQuery->getOneOrNullResult();

                if ($file) {
                    $is_validated = true;
                }

                break;
            case "Fundamental Channels":

//If ANY of the Matrix Touchpoints is selected , then is validated
                $lightdata_id = $campaign->getLightdata();
                if ($lightdata_id) {
                    $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($lightdata_id);
                    if ($lightdata) {
                        $touchpoints = $this->getDoctrine()->getRepository('LightdataBundle:TouchpointLD')->findByLightdata($lightdata);
                        foreach ($touchpoints as $touchpoint) {
                            $touchpoint_selected = $touchpoint->getSelected();
                            if ($touchpoint_selected) {
                                $is_validated = true;
                            }
                        }
                    }
                }

                break;
            case "Budget Allocation & Mapping":
// if Matrix has any allocated touchpoints populated under BudgetAllocation node, then add 1 point
                $lightdata_id = $campaign->getLightdata();
                if ($lightdata_id) {
                    $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($lightdata_id);
                    if ($lightdata) {
                        $budgetallocation = $this->getDoctrine()->getRepository('LightdataBundle:BudgetAllocationLD')->find($lightdata_id);
                        if ($budgetallocation) {
                            $total = $this->getDoctrine()->getRepository('LightdataBundle:BATotalLD')->findOneBy([
                                'budgetallocation' => $budgetallocation
                            ]);
                            if ($total) {
                                $allocation = $this->getDoctrine()->getRepository('LightdataBundle:BATOAllocationLD')->find($total->getId());
                                if ($allocation) {
                                    $grp = $allocation->getGRP();
                                    if ($grp > 0) {
                                        $is_validated = true;
                                    }
                                }
                            }
                        }
                    }
                }

                break;
            case "Phasing":
// old : If Matrix has any data under the TimeAllocation node, then add 1 point
// new : If any of TimeAllocation.Total.AllocationByPeriod[i].GRP  > 0     , is validated.           
                $lightdata_id = $campaign->getLightdata();
                if ($lightdata_id) {
                    $lightdata = $this->getDoctrine()->getRepository('LightdataBundle:Lightdata')->find($lightdata_id);
                    if ($lightdata) {
                        $timeallocation = $this->getDoctrine()->getRepository('LightdataBundle:TimeAllocationLD')->find($lightdata_id);
                        if ($timeallocation) {
                            $total = $this->getDoctrine()->getRepository('LightdataBundle:TATotalLD')->findOneBy([
                                'timeallocation' => $timeallocation
                            ]);
                            if ($total) {
                                $allocationsbyperiod = $this->getDoctrine()->getRepository('LightdataBundle:TATOAllocationByPeriod')->findBy(['allocatedtouchpoint' => $total]);
                                if ($allocationsbyperiod) {
                                    foreach ($allocationsbyperiod as $allocation) {
                                        if ($allocation->getGRP() > 0) {
                                            $is_validated = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                break;
            case "Final Plan":
//if there is a file uploaded for this campaign with file_type_id=12 and task_name_id=8, then add 1 point (check the project_file table)

                $fileType = $this->getDoctrine()->getRepository('CampaignBundle:Filetype')->findOneById(1);
                $fileQuery = $this->getDoctrine()->getRepository('FileBundle:File')->createQueryBuilder('f')
                        ->where('f.task = :task AND f.fileType = :fileType')
                        ->orderBy('f.updatedAt', 'DESC')
                        ->setMaxResults(1)
                        ->setParameter('task', $task)
                        ->setParameter('fileType', $fileType)
                        ->getQuery();
                $file = $fileQuery->getOneOrNullResult();

                if ($file) {
                    $is_validated = true;
                }


                break;
            default:
                //echo "THIS ENTERED INTO DEFAULT MODE";
                break;
        }

        return $is_validated;
    }

    function validate_user_is_able_to_view_this_campaign($user, $campaign) {
        /**
         * Validate that the user is able to view this campaign before continuing 
         */
        // RULES ARE :
        //A) FOR ADMINISTRATORS :
        //
        //A.1 User is an administrator =>> He is allowed to see any campaign. Even the non-visible ones.
        //
        //B) FOR VIEWERS :
        //
        //B.1 User has access to all countries and all regions for the specified client.
        //B.2 User has access to all clients for a specific country.
        //B.3 User has access to all clients for a specific region.
        //B.4 User is allowed to see A client in a specific country.
        //B.5 User is allowed tp see all campaigns in the campaign's region for the campaign's client.
        //B.6 User is allowed to see all campaigns for all clients , and global region (any country) [ This would be an admin ]
        //
        //
        //C) FOR CONTRIBUTORS:
        //
        //C.1 CONTRIBUTOR USERS CAN SEE ALL CAMPAIGNS THAT HAVE THE COMBINATION : TEMP_CLIENT & TEMP_COUNTRY
        //C.2 CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_COUNTRY  IF HE HAS ANY ACCESS TO THE CLIENT OF THE CAMPAIGN
        //C.3.a CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT IF HE HAS ANY ACCESS TO THE CAMPAIGN'S COUNTRY
        //C.3.b CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT IF THEY HAVE ACCESS TO THE CAMPAIGN'S REGION (AND ALL)
        //C.3.c CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR TEMP CLENT IF THEY CAN SEE ALL CLIENTS IN THAT REGION
        //C.4 CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT HAVE TEMP_COUNTRY IF THEY CAN SEE ALL CLIENTS
        //C.5 - NOTHING IMPLEMENTED.

        $debug_this = false;
        $debug_array = array();

        $validated_to_display = false;

        if ($user->isEnabled()) {

            $the_campaign_country = $campaign->getCountry();
            $the_campaign_client = $campaign->getClient();
            $the_campaign_region = $the_campaign_country->getRegion();
            $global_region = $this->getDoctrine()->getRepository('CampaignBundle:Region')->find(1);
            $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');
            $temp_client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
            $temp_country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneByName('temp_country');

            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
            ///////        A.   ADMINS ONLY          //////////////
            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
//CASE A.1.   
//The user is an administrator , he can see all the campaigns.
            $user_is_admin = $user->hasRole('ROLE_ADMINISTRATOR');


            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
            ///////      B.  VIEWERS ( and some contrib)  /////////
            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
//CASE B.1.
//The user is allowed to see all countries and all regions for this client.
            $user_global_this_client = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'region' => $global_region,
                'all_countries' => true,
            ]);

//CASE B.2.
//The user is allowed to see all clients for a specific country.
            $user_all_clients_this_country_false = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'country' => $the_campaign_country,
                'all_countries' => false,
            ]);

//CASE B.3.
//The user is allowed to see all clients in a specific region.
            $user_all_clients_one_region_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'country' => NULL,
                'region' => $the_campaign_region,
                'all_countries' => true,
            ]);

//CASE B.4.
//The user is allowed to see a client in a specific country.
            $user_client_country_false = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'country' => $the_campaign_country,
                'all_countries' => false,
            ]);
//CASE B.5.
// The user is allowed tp see all campaigns in the campaign's region for the campaign's client.
            $user_client_region_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'region' => $the_campaign_region,
                'all_countries' => true,
            ]);
//CASE B.6.
// The user is allowed to see all campaigns for all clients , and global region (any country) [ This would be an admin ]
            $user_all_clients_all_regions_true = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'region' => $global_region,
                'all_countries' => true,
            ]);


            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
            ///////       C.    CONTRIBUTORS ONLY      ////////////
            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
// CASE C.1:    CONTRIBUTOR USERS CAN SEE ALL CAMPAIGNS THAT HAVE THE COMBINATION : TEMP_CLIENT & TEMP_COUNTRY

            $user_can_view_because_case_c1 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {

                if (($the_campaign_country == $temp_country) && ($the_campaign_client == $temp_client)) {
                    $user_can_view_because_case_c1 = true;
                }
            }
////////////////////////////////
//CASE C.2:    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_COUNTRY
//             IF HE HAS ACCESS TO THE CLIENT OF THE CAMPAIGN
//             EXAMPLE : JOHN HAS PERMISSION TO SEE UNILEVEL USA
//             -> JOHN CAN SEE UNILEVELR -> TEMP COUNTRY.


            $user_can_view_because_case_c2 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_country == $temp_country) {

                    // Verify that the user can access this campaign's CLIENT 
                    $user_can_view_because_case_c2 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $the_campaign_client
                    ]);
                }
            }

/////////////////////////////////
//                        
//CASE C.3.a    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT 
//             IF THEY HAVE ACCESS TO THE CAMPAIGN'S COUNTRY   
//             
            $user_can_view_because_case_c3a = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {

                    // Verify that the user can access this campaign's CLIENT 
                    $user_can_view_because_case_c3a = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'country' => $the_campaign_country
                    ]);
                }
            }

            //                        
//CASE C.3.b    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT 
//             IF THEY HAVE ACCESS TO THE CAMPAIGN'S REGION   
//             
            $user_can_view_because_case_c3b = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {

                    // Verify that the user can access this campaign's CLIENT 
                    $user_can_view_because_case_c3b = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'region' => $the_campaign_region,
                        'all_countries' => true
                    ]);
                }
            }
//CASE C.3.c    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR TEMP CLENT 
//            IF THEY CAN SEE ALL CLIENTS IN THAT REGION
            $user_can_view_because_case_c3c = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {
                    // Verify that the user has all_clients access for the campaign's country
                    $user_can_view_because_case_c3c = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $all_clients,
                        'region' => $the_campaign_region,
                        'all_countries' => true
                    ]);
                }
            }

//CASE C.4    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT HAVE TEMP_COUNTRY
//            IF THEY CAN SEE ALL CLIENTS
            $user_can_view_because_case_c4 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_country == $temp_country) {
                    // Verify that the user has all_clients access for the campaign's country
                    $user_can_view_because_case_c4 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $all_clients,
                            //'country' => $the_campaign_country
                    ]);
                }
            }



//CASE C.5    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR TEMP_CLIENT IF HAVE GLOBAL ACCESS TO ANY CLIENT
            $user_can_view_because_case_c5 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {
                    $user_can_view_because_case_c5 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'region' => $global_region,
                        'all_countries' => true
                    ]);
                }
            }

            if ($user_is_admin)
                $debug_array[] = 'User is Administrator';
            if ($user_client_country_false)
                $debug_array[] = 'User Client Country False';
            if ($user_client_region_true)
                $debug_array[] = 'User Client Region True';
            if ($user_all_clients_this_country_false)
                $debug_array[] = 'User All_Cli This Country False';
            if ($user_all_clients_one_region_true)
                $debug_array[] = 'User All_Cli One Reg True';
            if ($user_global_this_client)
                $debug_array[] = 'User is Administrator';
            if ($user_all_clients_all_regions_true)
                $debug_array[] = 'User All_Cli All_Reg True';
            if ($user_can_view_because_case_c1)
                $debug_array[] = 'C.1';
            if ($user_can_view_because_case_c2)
                $debug_array[] = 'C.2';
            if ($user_can_view_because_case_c3a)
                $debug_array[] = 'C.3.a';
            if ($user_can_view_because_case_c3b)
                $debug_array[] = 'C.3.b';
            if ($user_can_view_because_case_c3c)
                $debug_array[] = 'C.3.c';
            if ($user_can_view_because_case_c4)
                $debug_array[] = 'C.4';
            if ($user_can_view_because_case_c5)
                $debug_array[] = 'C.5';

            if ($user_is_admin ||
                    $user_client_country_false ||
                    $user_client_region_true ||
                    $user_all_clients_this_country_false ||
                    $user_all_clients_one_region_true ||
                    $user_global_this_client ||
                    $user_all_clients_all_regions_true ||
                    $user_can_view_because_case_c1 ||
                    $user_can_view_because_case_c2 ||
                    $user_can_view_because_case_c3a ||
                    $user_can_view_because_case_c3b ||
                    $user_can_view_because_case_c3c ||
                    $user_can_view_because_case_c4 ||
                    $user_can_view_because_case_c5
            ) {
                $validated_to_display = true;
            }


            if ($debug_this) {
                print_r($debug_array);
            }

            return $validated_to_display;
        }

        return false;

        /*
         * End of validation for able to view.
         */
    }

    function validate_user_can_view_this_client($user, $client) {
        /**
         * Validate that the user is able to view a specific client by the control_user_access entries
         */
        //Case 0 : The user is administrator =>> he can see anything.
        //Case 1 : Search for the exact match in control user access.
        //Case 2 : Search for the $user -> $all_clients in control user access

        $debug_this = false;
        $debug_array = array();

        $validated_can_view = false;

        if ($user->isEnabled()) {

            //Grab all_clients client.    
            $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');


            //Case 0
            $user_is_admin = $user->hasRole('ROLE_ADMINISTRATOR');

            //Case 1
            $matched_user_client = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $client
            ]);
            //Case 2

            $matched_user_all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients
            ]);


            if ($user_is_admin)
                $debug_array[] = 'User is Administrator';
            if ($matched_user_client)
                $debug_array[] = 'Matched User-Client Combo';
            if ($matched_user_all_clients)
                $debug_array[] = 'Matched User-All_Clients Combo';

            if ($user_is_admin ||
                    $matched_user_client ||
                    $matched_user_all_clients
            ) {
                $validated_can_view = true;
            }

            if ($debug_this) {
                print_r($debug_array);
            }

            return $validated_can_view;
        }

        return false;

        /*
         * End of validation for able to view.
         */
    }

    function validate_user_can_view_this_country_for_client($user, $client, $country) {
        /**
         * Validate that the user is able to view a specific country by the control_user_access entries
         */
        //Case 0 : The user is administrator =>> he can see anything.
        //Case 1 : Search for the exact match in control user access. (User-Client-Country)
        //Case 2 : Search for the $user -> $client -> $region in control user access (User-Client-Region-True)
        //Case 3 : Search for the $user -> $client -> global in control_user access (User-Client-Global- True)
        //Case 4 : Search for the $user -> $all_clients -> $country
        //Case 5 : Serach for the $user -> $all_clients -> $region
        //Case 6 : Search for the $user -> $all_clients -> $global


        $debug_this = false;
        $debug_array = array();

        $region = $country->getRegion();
        $global_region = $this->getDoctrine()->getRepository('CampaignBundle:Region')->findOneByName('Global');
        $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');
        $temp_client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
        $temp_country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneByName('temp_country');

        $validated_can_view = false;

        if ($user->isEnabled()) {



            //Case 0
            $user_is_admin = $user->hasRole('ROLE_ADMINISTRATOR');

            //Case 1
            $matched_user_client_country = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $client,
                'country' => $country,
                'all_countries' => false
            ]);
            //Case 2

            $matched_user_client_region = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $client,
                'region' => $region,
                'all_countries' => true
            ]);
            //Case 3
            $matched_user_client_global = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $client,
                'region' => $global_region,
                'all_countries' => true
            ]);
            ;

            //Case 4
            $matched_user_allclients_country = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'country' => $country,
                'all_countries' => false
            ]);
            ;
            //Case 5
            $matched_user_allclients_region = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'region' => $region,
                'all_countries' => true
            ]);
            ;
            //Case 6
            $matched_user_allclients_global = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'region' => $global_region,
                'all_countries' => true
            ]);
            ;


            $matched_case_7 = false;
            //Case 7
            //The user is contributor and client and country are TEMPS
            if (($user->hasRole('ROLE_CONTRIBUTOR')) && ($client == $temp_client) && ($country == $temp_country)) {
                $matched_case_7 = true;
                $debug_array[] = 'Matched Case 7';
            }

            $matched_case_8 = false;
            //The user is a contributor , 
            //and has global access to any client
            // Looking for countries for temp client.
            if (($user->hasRole('ROLE_CONTRIBUTOR')) && ($client == $temp_client)) {
                $search_for_a_global_entry = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                    'user' => $user,
                    'region' => $global_region,
                    'all_countries' => true
                ]);
                ;

                if ($search_for_a_global_entry) {
                    $matched_case_8 = true;
                    $debug_array[] = 'Matched Case 8 Leah Unilever Global';
                }
            }

            if ($user_is_admin)
                $debug_array[] = 'User is Administrator';
            if ($matched_user_client_country)
                $debug_array[] = 'Matched User-Country Combo';
            if ($matched_user_client_region)
                $debug_array[] = 'Matched User-Region Combo';
            if ($matched_user_client_global)
                $debug_array[] = 'Matched User Client Global';
            if ($matched_user_allclients_country)
                $debug_array[] = 'Matched User all_clients Country';
            if ($matched_user_allclients_region)
                $debug_array[] = 'Matched User allclients Region';
            if ($matched_user_allclients_global)
                $debug_array[] = 'Matched User all_clients Global';

            if ($user_is_admin ||
                    $matched_user_client_country ||
                    $matched_user_client_region ||
                    $matched_user_client_global ||
                    $matched_user_allclients_country ||
                    $matched_user_allclients_region ||
                    $matched_user_allclients_global ||
                    $matched_case_7 ||
                    $matched_case_8
            ) {
                $validated_can_view = true;
            }

            if ($debug_this) {
                print_r($debug_array);
            }

            return $validated_can_view;
        }

        return false;

        /*
         * End of validation for able to view.
         */
    }

    function validate_the_put_and_post_for_contributor($new_client, $new_country, $user) {
        /**
         * Validate that the contributor user is able to PUT / POST this campaign before continuing 
         */
        // THIS APPLIES FOR CONTRIBUTORS ONLY:
        //
        //
        //1 - User -> New Client -> Global Region -> ALL
        //2 - User -> All Clients -> New Country 
        //3 - User -> All Clients -> New Region -> ALL
        //4 - User -> New Country -> New Client
        //5 - User -> New Client -> New Region -> ALL
        //6 - User -> All Clients -> Global Region -> ALL [This is really a contrib user with admin rights if ever happens]
        //7 - New Client = Temp Client , New Country = Temp Country.
        //8 - New Country = Temp Country , User -> New Client  exists in control_user_access
        //9 - New Client = Temp Client , User -> New Country exists in control_user_access
        //10 - New Client = Temp Client , User -> New Region > ALL exists in control_user_access
        //11 - New Client = Temp Client , User -> All Clients -> New Region > ALL         exists in control_user_access
        //12 - New Country = Temp Country , User -> All Clients exists in control_user_access
        //TURN ON DEBUGGING IN ORDER TO SEE WHICH CASE GETS MATCHED WITHIN THE RESPONSE.
        $debug_this = false;

        $validated_to_display = false;

        if ($user->isEnabled()) {

            $the_campaign_country = $new_country;
            $the_campaign_client = $new_client;
            $the_campaign_region = $the_campaign_country->getRegion();
            $global_region = $this->getDoctrine()->getRepository('CampaignBundle:Region')->find(1);
            $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');
            $temp_client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
            $temp_country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneByName('temp_country');


//CASE 1.
//The user is allowed to see all countries and all regions for this client.
            $case1 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'region' => $global_region,
                'all_countries' => true,
            ]);
            if ($debug_this && $case1) {
                print_r('CASE 1 MATCHED');
            }

//CASE 2.
//The user is allowed to see all clients for a specific country.
            $case2 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'country' => $the_campaign_country,
                'all_countries' => false,
            ]);
            if ($debug_this && $case2) {
                print_r('CASE 2 MATCHED');
            }
//CASE 3.
//The user is allowed to see all clients in a specific region.
            $case3 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'country' => NULL,
                'region' => $the_campaign_region,
                'all_countries' => true,
            ]);
            if ($debug_this && $case3) {
                print_r('CASE 3 MATCHED');
            }
//CASE 4.
//The user is allowed to see a client in a specific country.
            $case4 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'country' => $the_campaign_country,
                'all_countries' => false,
            ]);
            if ($debug_this && $case4) {
                print_r('CASE 4 MATCHED');
            }
//CASE 5.
// The user is allowed tp see all campaigns in the campaign's region for the campaign's client.
            $case5 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $the_campaign_client,
                'region' => $the_campaign_region,
                'all_countries' => true,
            ]);
            if ($debug_this && $case5) {
                print_r('CASE 5 MATCHED');
            }
//CASE 6.
// The user is allowed to see all campaigns for all clients , and global region (any country) [ This would be an admin ]
            $case6 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                'user' => $user,
                'client' => $all_clients,
                'region' => $global_region,
                'all_countries' => true,
            ]);
            if ($debug_this && $case6) {
                print_r('CASE 6 MATCHED');
            }

            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
            ///////       C.    CONTRIBUTORS ONLY      ////////////
            ///////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////
// CASE 7: 
//    CONTRIBUTOR USERS CAN SEE ALL CAMPAIGNS THAT HAVE THE COMBINATION : TEMP_CLIENT & TEMP_COUNTRY

            $case7 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {

                if (($the_campaign_country == $temp_country) && ($the_campaign_client == $temp_client)) {
                    $case7 = true;
                }
            }
            if ($debug_this && $case7) {
                print_r('CASE 7 MATCHED');
            }
//CASE 8:  
//  CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_COUNTRY
//             IF HE HAS ACCESS TO THE CLIENT OF THE CAMPAIGN
//             EXAMPLE : JOHN HAS PERMISSION TO SEE UNILEVEL USA
//             -> JOHN CAN SEE UNILEVELR -> TEMP COUNTRY.


            $case8 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_country == $temp_country) {

                    // Verify that the user can access this campaign's CLIENT 
                    $case8 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $the_campaign_client
                    ]);
                }
            }
            if ($debug_this && $case8) {
                print_r('CASE 8 MATCHED');
            }
//                        
//CASE 9   CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT 
//             IF THEY HAVE ACCESS TO THE CAMPAIGN'S COUNTRY   
//             
            $case9 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {

                    // Verify that the user can access this campaign's CLIENT 
                    $case9 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'country' => $the_campaign_country
                    ]);
                }
            }
            if ($debug_this && $case9) {
                print_r('CASE 9 MATCHED');
            }
            //                        
//CASE 10   CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR A TEMP_CLIENT 
//             IF THEY HAVE ACCESS TO THE CAMPAIGN'S REGION   
//             
            $case10 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {

                    // Verify that the user can access this campaign's CLIENT 
                    $case10 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'region' => $the_campaign_region,
                        'all_countries' => true
                    ]);
                }
            }
            if ($debug_this && $case10) {
                print_r('CASE 10 MATCHED');
            }
//CASE 11   CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT ARE FOR TEMP CLENT 
//            IF THEY CAN SEE ALL CLIENTS IN THAT REGION
            $case11 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {
                    // Verify that the user has all_clients access for the campaign's country
                    $case11 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $all_clients,
                        'region' => $the_campaign_region,
                        'all_countries' => true
                    ]);
                }
            }
            if ($debug_this && $case11) {
                print_r('CASE 11 MATCHED');
            }
//CASE 12    CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT HAVE TEMP_COUNTRY
//            IF THEY CAN SEE ALL CLIENTS
            $case12 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_country == $temp_country) {
                    // Verify that the user has all_clients access for the campaign's country
                    $case12 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'client' => $all_clients,
                    ]);
                }
            }
            if ($debug_this && $case12) {
                print_r('CASE 12 MATCHED');
            }
//CASE 13   CONTRIBUTOR USER CAN SEE ALL CAMPAIGNS THAT HAVE TEMP_CLIENT IF THEY HAVE PERMISSION TO A CLIENT AND GLOBAL
            $case13 = false;
            if ($user->hasRole('ROLE_CONTRIBUTOR')) {
                if ($the_campaign_client == $temp_client) {
                    $case13 = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findOneBy([
                        'user' => $user,
                        'region' => $global_region,
                        'all_countries' => true
                    ]);
                }
                if ($debug_this && $case13) {
                    print_r('CASE 13 MATCHED');
                }
            }


            if (
                    $case1 ||
                    $case2 ||
                    $case3 ||
                    $case4 ||
                    $case5 ||
                    $case6 ||
                    $case7 ||
                    $case8 ||
                    $case9 ||
                    $case10 ||
                    $case11 ||
                    $case12 ||
                    $case13
            ) {
                $validated_to_display = true;
            }

            return $validated_to_display;
        }

        return false;

        /*
         * End of validation for able to view.
         */
    }

    function checkIfCurrentUserIsMemberOrAddHim($user, $campaign) {


        //Grab the Entity Manager.
        $em = $this->getDoctrine()->getManager();
        //Check if the user is not already a member in the team
        $current_user_is_member = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findOneBy([
            'member' => $user,
            'campaign' => $campaign,
        ]);
        //If he is not already a member , create a new teammember object in the database.
        if (!$current_user_is_member) {
            $new_teammember = new Teammember();
            $new_teammember->setCampaign($campaign);
            $new_teammember->setMember($user);
            $new_teammember->setIsReviewer(false);

            $em->persist($new_teammember);
            $em->flush();
            return true;
            //Return true if new teammember added
        }
        return false;
        //Return false if user was already in the team.
    }

    /**
     * @ApiDoc(
     *    description = "Display the tasks the user should work on - tasks where the user is the task owner or (if the user is the reviewer and the task status is submitted)",
     *    section="Users",
     *    statusCodes = {
     *     200 = "Returned when the task was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the task was not found in database",
     *         "Returned When the task does not belong to the specified campaign",
     *         "Returned when the user does not have access to the task"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="user_id",     "dataType"="integer","requirement"="true", "description"="The user unique id"     },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getUsersInfoAction($user_id, Request $request) {


        $response = new Response();

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($user_id);
//CHECK THAT THE USER EXISTS IN THE SYSTEM
        if (!$user) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array('success' => false, 'message' => 'There is no user for that user_id.')));
            return $response;
        }


        $roles = $user->getRoles();
        foreach ($roles as $role) {
            $db_role = $this->getDoctrine()->getRepository('UserBundle:Role')->findOneByName($role);
            if ($db_role) {
                $the_role_id = $db_role->getId();
                $the_role_name = $db_role->getName();
                $the_role_sysname = $db_role->getSystemname();
            }
        }


        $primary_user_data = array(
            'user_id' => $user->getId(),
            'user_role_id' => $the_role_id,
            'user_role_name' => $the_role_name,
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
        );


/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

        $all_the_tasks_of_this_user = array();

        $open_task_status = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->find(1);
        $submitted_task_status = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->find(2);


        $tasks_where_user_is_owner = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy([
            'owner' => $user,
            'taskstatus' => $open_task_status
        ]);

        foreach ($tasks_where_user_is_owner as $twuio) {
            if ($twuio->getCampaign()->getNotVisible() == false) {
                //ONLY ADD TASKS THAT HAVE THE CAMPAIGN VISIBILITY ENABLED (NOT_VISIBLE = FALSE)
                $all_the_tasks_of_this_user[] = $twuio->getId();
            }
        }
//        print_r($all_the_tasks_of_this_user);
//        die();
//        
//        $tasks_where_user_is_creator = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy(['createdby' => $user]);
//
//        foreach ($tasks_where_user_is_creator as $twuic) {
//            if ($twuic->getCampaign()->getNotvisible() == false) {
////ONLY ADD TASKS THAT HAVE THE CAMPAIGN VISIBILITY ENABLED (NOT_VISIBLE = FALSE) 
//                $all_the_tasks_of_this_user[] = $twuic->getId();
//            }
//        }
//PRELUAM TOATE INTRARILE DIN TEAMMEMBER UNDE USERUL E REVIEWER        
        $teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findBy(['member' => $user, 'is_reviewer' => true]);

//For each campaign where the user is reviewer, grab the campaign's tasks array.
        $campaign_ids_where_user_is_reviewer = array();
        foreach ($teammembers as $teammember) {
            $campaign_ids_where_user_is_reviewer[] = $teammember->getCampaign()->getId();
        }

        $task_ids_of_all_tasks_where_user_is_reviewer_within_campaign = array();
        foreach ($campaign_ids_where_user_is_reviewer as $campaign_id) {
            $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findOneBy(
                    ['id' => $campaign_id,
                        'not_visible' => false,]
            );
            $tasks_of_this_campaign = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy(['campaign' => $campaign]);
            foreach ($tasks_of_this_campaign as $task) {
                $task_ids_of_all_tasks_where_user_is_reviewer_within_campaign[] = $task->getId();
            }
        }
        foreach ($task_ids_of_all_tasks_where_user_is_reviewer_within_campaign as $task_id) {

            //Validate that the task status is SUBMITTED , and ADD THE ID IF SO.
            $is_task_status_submitted = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy([
                'id' => $task_id,
                'taskstatus' => $submitted_task_status
            ]);
            if ($is_task_status_submitted) {
                $all_the_tasks_of_this_user[] = $task_id;
            }
        }
        $unique_tasks_of_this_user = array_unique($all_the_tasks_of_this_user);
        // print_r($unique_tasks_of_this_user);
        // die("Died @ 3921");

        $returned_task_data_array = array();
        $build_cstatus = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->find(1);
        $approved_cstatus = $this->getDoctrine()->getRepository('CampaignBundle:Campaignstatus')->find(2);

        foreach ($unique_tasks_of_this_user as $uniquetask) {


            $grabbed_task = $this->getDoctrine()->getRepository('TaskBundle:Task')->find($uniquetask);

            $campaign_of_this_task = $grabbed_task->getCampaign();
            $campaign_status = $campaign_of_this_task->getCampaignstatus();
            $validated_status = false;

            if (($campaign_status == $build_cstatus) || ($campaign_status == $approved_cstatus)) {
                $validated_status = true;
            }

            $proceeed = self::validate_user_is_able_to_view_this_campaign($user, $campaign_of_this_task);

            if ($proceeed && $validated_status) {

                $status_changer = $grabbed_task->getStatuschangedby();
                $task_status = $grabbed_task->getTaskstatus();
                $completed = $this->getDoctrine()->getRepository('TaskBundle:Taskstatus')->find(3);
                $task_status_name = $task_status->getName();
                $completed_name = $completed->getName();

                $task_data = array();
                if ($task_status_name !== $completed_name) {
                    $task_data = array(
                        'campaign_id' => $grabbed_task->getCampaign()->getId(),
                        'campaign_name' => $grabbed_task->getCampaign()->getName(),
                        'task_id' => $grabbed_task->getId(),
                        'task_name' => $grabbed_task->getTaskname()->getName(),
                        'last_task_status' => $grabbed_task->getTaskstatus()->getName(),
                        'last_task_message' => $grabbed_task->getTaskmessage() ? $grabbed_task->getTaskmessage()->getMessage() : null,
                        'last_task_status_date' => $grabbed_task->getTaskstatus() ? date('Y-m-d', $grabbed_task->getTaskstatus()->getUpdatedat()->getTimestamp()) : null,
                        'status_changer_user_id' => $status_changer ? $status_changer->getId() : null,
                        'status_changer_first_name' => $status_changer ? $status_changer->getFirstname() : null,
                        'status_changer_last_name' => $status_changer ? $status_changer->getLastname() : null,
                        'status_changer_profile_picture' => $status_changer ? $status_changer->getProfilepicture() : null,
                        'proceed' => $proceeed,
                    );
                }
                $returned_task_data_array[] = $task_data;
            }
        }
        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'user' => $primary_user_data,
            'tasks_data' => $returned_task_data_array
        )));
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the user's profile information (name, email, phone, title, etc.), including data provided by Honey.",
     *    section="Users",
     *    statusCodes = {
     *     200 = "Returned when the task was found",
     *     403 = {"Invalid API KEY", "Invalid user id provided."},
     *     404 = {
     *         "Returned When the task was not found in database",
     *         "Returned When the task does not belong to the specified campaign",
     *         "Returned when the user does not have access to the task"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {"name"="user_id",     "dataType"="integer","requirement"="true", "description"="The user unique id"     },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getUsersProfileAction($user_id, Request $request) {


        $response = new Response();

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($user_id);
//CHECK THAT THE USER EXISTS IN THE SYSTEM
        if (!$user) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array('success' => false, 'message' => 'There is no user for that user_id.')));
            return $response;
        }


        $roles = $user->getRoles();
        foreach ($roles as $role) {
            $db_role = $this->getDoctrine()->getRepository('UserBundle:Role')->findOneByName($role);
            if ($db_role) {
                $the_role_id = $db_role->getId();
                $the_role_name = $db_role->getName();
                $the_role_sysname = $db_role->getSystemname();
            }
        }


        $primary_user_data = array(
            'user_id' => $user->getId(),
            //'user_role_id' => $the_role_id,
            //'user_role_name' => $the_role_name,
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'user_role' => $the_role_sysname,
            'title' => $user->getTitle(),
            'office' => $user->getOffice(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'profile_picture_path' => $user->getProfilepicture(),
            'honey_id' => $user->getHoneyid(),
            'honey_uuid' => $user->getHoneyuuid(),
            'honey_refresh_token' => $user->getHoneyRefreshToken(),
        );


/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////



        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            $primary_user_data,
                        //'tasks_data' => $returned_task_data_array
        )));
        return $response;
    }

    /**
     * @Route("/api/v1/users/{user_id}/access ", name="_get_user_access")
     * @Method("GET")
     *
     * @ApiDoc(
     *      deprecated=TRUE,
     * 		description = "no longer used in the Administration screens. Returns the client-country combinations assigned to the user on the Administration screen.",
     *      section="Users",
     * 		statusCodes = {
     * 			201 = "Returned when the update succeded.",
     * 			400 = "Returned when parameters are not valid.",
     *          403 = "Invalid user ID provided.",
     *          404 = "This user has no user-client-region-country access combination in the database yet."
     * 		},
     * 		requirements = {
     *             {"name" = "user_id"},
     *              {"name" = "_format","requirement" = "json|xml"}
     * 		}
     * )
     *
     */
    public function getUserAccessAction($user_id) {

        $response = new Response();
        $user = $this->getDoctrine()->getRepository("UserBundle:User")->find($user_id);
//Check that the user really exists. Else error.
        if (!$user) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Invalid user ID provided.'
            )));
            return $response;
        }

//If USER exists , grab all useraccesses for that user.      
        $useraccesses = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findByUser($user);
//IF NO USERACCESES FOUND FOR USER , RETURN AN ERROR / MESSAGE
        if (!$useraccesses) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'This user has no user-client-region-country access combination in the database yet.'
            )));
            return $response;
        }
        $return_array = array();
        foreach ($useraccesses as $useraccess_entry) {

            $message_array = array(
                'client' => $useraccess_entry->getClient() ? $useraccess_entry->getClient()->getName() : null,
                'region' => $useraccess_entry->getRegion() ? $useraccess_entry->getRegion()->getName() : null,
                'country' => $useraccess_entry->getCountry() ? $useraccess_entry->getCountry()->getName() : null,
                'all_countries' => $useraccess_entry->getAllCountries() ? $useraccess_entry->getAllCountries() : false,
            );
            $return_array[] = $message_array;
        }
        $response->setStatusCode(201);
        $response->setContent(json_encode(array(
//'success' => true,
            'access' => $return_array
                ))
        );
        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Display the file types that are possible to upload on each task screen (i.e. Target Reckoner files are uploaded on JTBD screen)",
     *    section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the list was succesfully generated was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When task was not found",
     *         "Returned when the user does not have access to the campaign"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="tasknameId",
     *           "dataType"="integer",
     *           "description"="The task unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getTasksFiletypesAction($tasknameId) {

        $response = new Response();

        $taskname = $this->getDoctrine()->getRepository('TaskBundle:Taskname')->find($tasknameId);


        if (!$taskname) {
            $response = new Response();
// Set response data:
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'That taskname does not exist.'
                    ))
            );
            return $response;
        }

        $filetypes = $taskname->getFiletypes();

        foreach ($filetypes as $filetype) {
            $return_array[] = array(
                'FileTypeId' => $filetype->getId(),
                'FileTypeName' => $filetype->getName(),
            );
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode(array(
            'FileTypes' => $return_array
                        )
        ));

        return $response;
    }

    /**
     * @ApiDoc(
     *    description = "Returns users who have the roles, client-country permissions to access a particular campaign.",
     *   section="Z_DISABLED",
     *    statusCodes = {
     *     200 = "Returned when the campaign was found",
     *     403 = "Invalid API KEY",
     *     404 = {
     *         "Returned When the campaign was not found in database"
     *     },
     *     500 = "Header x-wsse does not exist"
     *    },
     *    requirements = {
     *       {
     *           "name"="campaignId",
     *           "dataType"="string",
     *           "description"="The campaign unique id"
     *       },
     *       {
     *          "name" = "_format",
     *          "requirement" = "json|xml"
     *       }
     *    }
     * )
     * @return array
     * @View()
     */
    public function getCampaignEligibleteammembersAction($campaignId) {

        //The logic of the call :
        //For a given campaign id , grab the campaign's country and client combination
        //Search for all the useraccesses that match the given combination , grab the users.
        //Remove the already existing teammembers from the search array returned.
        //
        //Remove QUALITY ASSURANCE USER FROM THE RESPONSE (IF ANY)
        //
        //Return the response



        $response = new Response();

        $campaign = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->find($campaignId);
        $global_region = $this->getDoctrine()->getRepository('CampaignBundle:Region')->findOneByName('Global');
        $temp_client = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
        $temp_country = $this->getDoctrine()->getRepository('CampaignBundle:Country')->findOneByName('temp_country');
        $all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Client')->findOneByName('all_clients');
        $the_quality_assurance_user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneByUsername('qa_user');
        $bertrands_matrix_user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneByUsername('bertrand');


        //Default the quality assurance user to null. If we have QA user then grab his id.
        $the_quality_assurance_user_id = null;
        if ($the_quality_assurance_user) {
            $the_quality_assurance_user_id = $the_quality_assurance_user->getId();
        }
        $bertrands_matrix_user_id = null;
        if ($bertrands_matrix_user) {
            $bertrands_matrix_user_id = $bertrands_matrix_user->getId();
        }

        if (!$campaign) {
            $response->setStatusCode(404);
            $response->setContent(json_encode(array(
                'success' => false,
                'message' => 'Campaign does not exist.'
                    ))
            );
            return $response;
        }
        //Grab this campaign's country and client
        //Using the campaign , grab the country , client and region
        $country = $campaign->getCountry();
        $client = $campaign->getClient();
        $region = $country->getRegion();


        //Instantiate the possible users array.
        $possible_user_ids = array();




        //////////////////////////
        ///SEARCH ALL THE CASES///
        //////////////////////////
        //Case1
        //Get all the users that have client_country acccesses like the campaign's client country combo
        $useraccesses_with_client_country = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $client,
            'country' => $country,
            'all_countries' => false
        ]);
        foreach ($useraccesses_with_client_country as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //Case2
        //Get all the users that have client_country acccesses like the campaign's client region combo
        $useraccesses_with_client_region = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $client,
            'region' => $region,
            'all_countries' => true
        ]);
        foreach ($useraccesses_with_client_region as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //Case3
        //Get all the users that have client like the campaign and region = Global (all countries everywhere)
        $useraccesses_with_client_global = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $client,
            'region' => $global_region,
            'all_countries' => true
        ]);
        foreach ($useraccesses_with_client_global as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //Case4
        //Get all the users that have access to all clients for the campaign's country.
        $useraccesses_with_all_clients_country = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $all_clients,
            'country' => $country,
        ]);
        foreach ($useraccesses_with_all_clients_country as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //Case5
        //Get all the user that have access to all_clients and the campaign's REGION (whole).
        $useraccesses_with_all_clients_region = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $all_clients,
            'region' => $region,
            'all_countries' => true
        ]);
        foreach ($useraccesses_with_all_clients_region as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //Case6
        //Get all the users that have access to all_clients and region is GLOBAL. (this would be  admins? )
        $useraccesses_with_all_clients_global = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
            'client' => $all_clients,
            'region' => $global_region,
            'all_countries' => true
        ]);
        foreach ($useraccesses_with_all_clients_global as $access) {
            $possible_user_ids[] = $access->getUser()->getId();
        }

        //SPECIAL CASES !!!
        // A) This would be the cases only if the campaign client = temp_client [Only contributor users should be returned by this]

        if ($client === $temp_client) {
            //Special Case A.1.
            // The campaign client is temp_client , then fetch all the users that have access to the campaign's country
            $useraccesses_for_temp_client_by_country = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
                'country' => $country,
            ]);
            foreach ($useraccesses_for_temp_client_by_country as $access) {
                if ($access->getUser()->hasRole('ROLE_CONTRIBUTOR')) {
                    $possible_user_ids[] = $access->getUser()->getId();
                }
            }
            //Special Case A.2.
            // The campaign client is temp_client , then fetch all the users that have access to the campaign's region
            $useraccesses_for_temp_client_by_region = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
                'region' => $region,
                'all_countries' => true
            ]);
            foreach ($useraccesses_for_temp_client_by_region as $access) {
                if ($access->getUser()->hasRole('ROLE_CONTRIBUTOR')) {
                    $possible_user_ids[] = $access->getUser()->getId();
                }
            }
            //Special Case A.3
            // The campaign client is temp_client , then fetch all the users that have access to region GLOBAL.
            $useraccesses_for_temp_client_by_global = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
                'region' => $global_region,
                'all_countries' => true
            ]);
            foreach ($useraccesses_for_temp_client_by_global as $access) {
                if ($access->getUser()->hasRole('ROLE_CONTRIBUTOR')) {
                    $possible_user_ids[] = $access->getUser()->getId();
                }
            }
        }
        // B) This would be the cases only if the campaign's country = temp_country [Only contributor users should be returned by this]
        if ($country === $temp_country) {
            //Special case B.1
            // The campaign's country is temp_country , then fetch all the users that have access to the campaign's client
            $useraccesses_for_temp_country_by_campaign_client = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
                'client' => $client,
            ]);
            foreach ($useraccesses_for_temp_country_by_campaign_client as $access) {
                if ($access->getUser()->hasRole('ROLE_CONTRIBUTOR')) {
                    $possible_user_ids[] = $access->getUser()->getId();
                }
            }
            //Special case B.2
            // The campaign's country is temp_country , then fetch all the users that have access to all_clients.
            $useraccesses_for_temp_country_by_all_clients = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findBy([
                'client' => $all_clients,
            ]);
            foreach ($useraccesses_for_temp_country_by_all_clients as $access) {
                if ($access->getUser()->hasRole('ROLE_CONTRIBUTOR')) {
                    $possible_user_ids[] = $access->getUser()->getId();
                }
            }
        }


        //Get all the administrator users (they have access to anything ,anywhere)
        $administrator_users = $this->getDoctrine()->getRepository('UserBundle:User')->findAllAdministrators();
        foreach ($administrator_users as $administrator_user) {
            $possible_user_ids[] = $administrator_user->getId();
        }
        //////////////////////////////
        ///END SEARCH ALL THE CASES///
        //////////////////////////////        
        //FOR EACH OF THE POSSIBLE USER IDS , THESE CHECKS MUST BE MADE :
        //   - Check that the user is enabled.
        //   - Check that the user is not already a teammember into this campaign
        //If checks passed , add userid, firstname , lastname to return array


        $unique_possible_user_ids_including_qa_and_bertrand = array_unique($possible_user_ids);

        $ids_to_remove = array();

        //If the quality assurance user is present within the returned ids array , remove him from the array.
        if ($the_quality_assurance_user_id) {
            $ids_to_remove[] = $the_quality_assurance_user_id;
        }
        if ($bertrands_matrix_user_id) {
            $ids_to_remove[] = $bertrands_matrix_user_id;
        }

        $unique_possible_user_ids = array_diff($unique_possible_user_ids_including_qa_and_bertrand, $ids_to_remove);

//        print_r($unique_possible_user_ids_including_qa_and_bertrand);
//        print_r($unique_possible_user_ids);
//        die('Debug Die Here.');

        $enabled_user_not_teammembers = array();
        foreach ($unique_possible_user_ids as $unique_user_id) {
            $thisUser = $this->getDoctrine()->getRepository('UserBundle:User')->find($unique_user_id);
            //If user is enabled
            if ($thisUser->isEnabled()) {

                //Check if the user isnt already teammember
                $is_already_teammember = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findOneBy([
                    'campaign' => $campaign,
                    'member' => $thisUser
                ]);

                if (!$is_already_teammember) {

                    $userdata['user_id'] = $thisUser->getId();
                    $userdata['first_name'] = $thisUser->getFirstname();
                    $userdata['last_name'] = $thisUser->getLastname();
//                    $userdata['roles'] = $thisUser->getRoles();
                    $enabled_user_not_teammembers[] = $userdata;
                }
            }
        }

        //If there are eligible teammembers , display them :)
        if (count($enabled_user_not_teammembers) > 0) {
            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'possible_teammembers' => $enabled_user_not_teammembers
                            )
            ));
        } else {
            //Return no aditional users are eligible message
            $response->setStatusCode(200);
            $response->setContent(json_encode(array(
                'success' => true,
                'message' => 'No aditional users are eligible team members'
            )));
        }

        return $response;
    }

    function refresh_campaign_teammembers_list_after_update($campaign) {

        //Instantiate an array where to keep the ids of the soon-to-be deleted teammembers.
        $deleted_teammembers = array();
        $deletable_teammembers = array();
        //Fetch all the current teammembers of the campaign.
        $existing_teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findByCampaign($campaign);


        //Get the entity manager in order to be able to delete teammembers if necessary
        $em = $this->getDoctrine()->getManager();

        //print_r(count($existing_teammembers));
        //die();

        foreach ($existing_teammembers as $teammember) {

            $teammember_is_still_valid = false;
            $the_user = $teammember->getMember();

            $teammember_is_still_valid = self::validate_user_is_able_to_view_this_campaign($the_user, $campaign);


            if ($teammember_is_still_valid) {
                //  print_r('Teammember is still valid here');
            } else {
                //print_r($the_user->getFirstname().' must be deleted because he cannot see the new campaign combination ');
                $deletable_teammembers[] = $the_user;
                $deleted_teammembers[] = $the_user->getId();
                $em->remove($teammember);
            }
        }

        $em->flush();
        //print_r($deletable_teammembers);
        return $deleted_teammembers;
    }

    /**
     * @ApiDoc(
     *      description = "Used by the application to remove team members who no longer have access to a campaign if the campaign or the user's permissions are edited.",
     *      section="Users",
     *      statusCodes = {},
     *      parameters={
     *          {"name"="user_id",  "dataType"="integer","required"=false,"description"="DeSCRRRIIIPTOIONnly) "},
     *          {"name"="admin_id",  "dataType"="integer","required"=false,"description"="DeSCRRRIIIPTOdsadIONnly) "},
     *      }
     * )
     *
     */
    public function putTeammemberaccessAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user_id = $request->get('user_id');
        $admin_id = $request->get('admin_id');
        $updateDate = new \DateTime();
        $updateDate->setTimezone(self::timezoneUTC());

        $campaigns_where_user_was_member = array();

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($user_id);
        $admin = $this->getDoctrine()->getRepository('UserBundle:User')->find($admin_id);

        //validate the user
        //validate the admin

        $teammember_entries = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findByMember($user);
        if (!$teammember_entries) {
            //die('This user is not member in any campaign');
        }

        foreach ($teammember_entries as $teammember_entry) {
            $campaigns_where_user_was_member[] = $teammember_entry->getCampaign();
        }

        // For each campaign where the user was member before this update , check again !
        $return_data_array = array();
        foreach ($campaigns_where_user_was_member as $campaign) {


            //This will remove the teammembers that do not coresspond anymore ,
            // and return an array of their ids.

            $removed_teammembers_ids = self::refresh_campaign_teammembers_list_after_update($campaign);

            // Using the array of ids returned , search the campaign if the user was a taskowner. 
            // and reset the taskowner to be the admin using the call
            foreach ($removed_teammembers_ids as $user_id) {
                $return_data_array[$campaign->getId()][] = $user_id;
                $deleted_user = $this->getDoctrine()->getRepository('UserBundle:User')->find($user_id);

                $tasks_where_this_user_was_taskowner = $this->getDoctrine()->getRepository('TaskBundle:Task')->findBy([
                    'owner' => $deleted_user,
                    'campaign' => $campaign]);

                if ($tasks_where_this_user_was_taskowner) {
                    foreach ($tasks_where_this_user_was_taskowner as $task) {
                        $task->setOwner($admin);
                        $checked_the_current_user = self::checkIfCurrentUserIsMemberOrAddHim($admin, $campaign);
                        if ($checked_the_current_user) {
                            $campaign->setUpdatedAt($updateDate);
                        }
                    }
                }
            }
            $em->flush();
        }

        return new Response(json_encode($return_data_array));
    }

//    /**
//     * @ApiDoc(
//     *    resource = true,
//     *    description = "DEBUGGING ONLY ( LIST THE ACCESS TABLE ).",
//     *    section="Z_Debugging",
//     *    statusCodes = {
//     *     200 = "Returned when the campaign was found",
//     *     403 = "Invalid API KEY",
//     *     404 = {
//     *         "Returned When the campaign was not found in database"
//     *     },
//     *     500 = "Header x-wsse does not exist"
//     *    },
//     *    requirements = {
//     *       {
//     *          "name" = "_format",
//     *          "requirement" = "json|xml"
//     *       }
//     *    }
//     * )
//     * @return array
//     * @View()
//     */
//    public function getAaaaccesTableAction() {
//
//        $response = new Response();
//
//        $useraccesses = $this->getDoctrine()->getRepository('CampaignBundle:Useraccess')->findAll();
//        $accesses = array();
//        foreach ($useraccesses as $useraccess) {
//            if ($useraccess->getAllcountries()) {
//                $accesses[] = 'User ' . $useraccess->getUser()->getFirstname() . ' has ' . $useraccess->getClient()->getName() . ' - ' . $useraccess->getRegion()->getName() . ' - ALLCOUNTRIES';
//            } else {
//                $accesses[] = 'User ' . $useraccess->getUser()->getFirstname() . ' has ' . $useraccess->getClient()->getName() . ' - ' . $useraccess->getRegion()->getName() . ' - ctry - ' . $useraccess->getCountry()->getName();
//            }
//        }
//
//        $response->setStatusCode(200);
//        $response->setContent(json_encode(array(
//            'success' => true,
//            'accesses' => $accesses
//        )));
//
//
//        return $response;
//    }
//    /**
//     * @ApiDoc(
//     *    resource = true,
//     *    description = "DEBUGGING ONLY ( LIST THE TEAMMEMBERS TABLE ).",
//     *    section="Z_Debugging",
//     *    statusCodes = {
//     *     200 = "Returned when the campaign was found",
//     *     403 = "Invalid API KEY",
//     *     404 = {
//     *         "Returned When the campaign was not found in database"
//     *     },
//     *     500 = "Header x-wsse does not exist"
//     *    },
//     *    requirements = {
//     *       {
//     *          "name" = "_format",
//     *          "requirement" = "json|xml"
//     *       }
//     *    }
//     * )
//     * @return array
//     * @View()
//     */
//    public function getAaateammembersTableAction() {
//
//        $response = new Response();
//
//        $teammembers = $this->getDoctrine()->getRepository('CampaignBundle:Teammember')->findAll();
//        $members = array();
//        foreach ($teammembers as $teammember) {
//            if ($teammember->getIsReviewer()) {
//                $members[] = 'User ' . $teammember->getMember()->getFirstname() . ' is member in ' . $teammember->getCampaign()->getName() . ' - IS REViEWER';
//            } else {
//                $members[] = 'User ' . $teammember->getMember()->getFirstname() . ' is member in ' . $teammember->getCampaign()->getName();
//            }
//        }
//
//        $response->setStatusCode(200);
//        $response->setContent(json_encode(array(
//            'success' => true,
//            'accesses' => $members
//        )));
//
//
//        return $response;
//    }
//    /**
//     * @ApiDoc(
//     *    resource = true,
//     *    description = "DEBUGGING ONLY ( LIST THE C1-C6 Campaign Statuses ).",
//     *    section="Z_Debugging",
//     *    statusCodes = {
//     *     200 = "Returned when the campaign was found",
//     *     403 = "Invalid API KEY",
//     *     404 = {
//     *         "Returned When the campaign was not found in database"
//     *     },
//     *     500 = "Header x-wsse does not exist"
//     *    },
//     *    requirements = {
//     *       {
//     *          "name" = "_format",
//     *          "requirement" = "json|xml"
//     *       }
//     *    }
//     * )
//     * @return array
//     * @View()
//     */
//    public function getAaacampaignstatusesTableAction() {
//
//        $response = new Response();
//
//        $campaigns = $this->getDoctrine()->getRepository('CampaignBundle:Campaign')->findAll();
//        $statuses = array();
//        foreach ($campaigns as $campaign) {
//            $statuses[] = 'Campaign ' . $campaign->getName() . ' has status :  ' . $campaign->getCampaignstatus()->getName();
//        }
//        $submittedtasks = array();
//        foreach ($campaigns as $campaign) {
//            $tasks = $campaign->getTasks();
//            foreach ($tasks as $task) {
//                if ($task->getTaskstatus()->getName() == 'Submitted') {
//                    $submittedtasks[] = $campaign->getName() . ' - has ' . $task->getTaskname()->getName() . ' set submitted';
//                }
//            }
//        }
//
//        $data = array();
//
//        foreach ($campaigns as $campaign) {
//            $data[] = 'Campaign ' . $campaign->getName() . ' - client: ' . $campaign->getClient()->getName() . ' - country: ' . $campaign->getCountry()->getName() . '';
//        }
//
//
//        $response->setStatusCode(200);
//        $response->setContent(json_encode(array(
//            'success' => true,
//            'statuses' => $statuses,
//            'submittedtasks' => $submittedtasks,
//            'campaignsdata' => $data
//        )));
//
//
//        return $response;
//    }
}
