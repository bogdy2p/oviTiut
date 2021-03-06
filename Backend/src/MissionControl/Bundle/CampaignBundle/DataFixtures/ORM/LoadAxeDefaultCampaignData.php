<?php

namespace MissionControl\Bundle\CampaignBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MissionControl\Bundle\CampaignBundle\Entity\Product;
use MissionControl\Bundle\CampaignBundle\Entity\Campaign;
use MissionControl\Bundle\CampaignBundle\Entity\Productline;
use MissionControl\Bundle\CampaignBundle\Entity\Brand;
use MissionControl\Bundle\CampaignBundle\Entity\Division;
use MissionControl\Bundle\CampaignBundle\Entity\Client;
use MissionControl\Bundle\CampaignBundle\Entity\Teammember;
use MissionControl\Bundle\CampaignBundle\Entity\Country;
use MissionControl\Bundle\TaskBundle\Entity\Task;
use MissionControl\Bundle\TaskBundle\Entity\Taskname;
use MissionControl\Bundle\TaskBundle\Entity\Taskstatus;
use MissionControl\Bundle\UserBundle\Entity\User;
use MissionControl\Bundle\FileBundle\Entity\File;
use MissionControl\Bundle\CampaignBundle\Entity\Campaignstatus;
//FOR LIGHTDATA
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;
use MissionControl\Bundle\LightdataBundle\Entity\Project;
use MissionControl\Bundle\LightdataBundle\Entity\Lightdata;
use MissionControl\Bundle\LightdataBundle\Entity\SetupLD;
use MissionControl\Bundle\LightdataBundle\Entity\ClientLD;
use MissionControl\Bundle\LightdataBundle\Entity\SurveyLD;
use MissionControl\Bundle\LightdataBundle\Entity\TargetLD;
use MissionControl\Bundle\LightdataBundle\Entity\ObjectiveLD;
use MissionControl\Bundle\LightdataBundle\Entity\GroupingLD;
use MissionControl\Bundle\LightdataBundle\Entity\GroupingCategoryLD;
use MissionControl\Bundle\LightdataBundle\Entity\GroupingTouchpointCategoryMapLD;
use MissionControl\Bundle\LightdataBundle\Entity\TouchpointLD;
use MissionControl\Bundle\LightdataBundle\Entity\TouchpointAttributeScoreLD;
use MissionControl\Bundle\LightdataBundle\Entity\TouchpointObjectiveScoreLD;
use MissionControl\Bundle\LightdataBundle\Entity\CPRAttributeLD;
use MissionControl\Bundle\LightdataBundle\Entity\BudgetAllocationLD;
use MissionControl\Bundle\LightdataBundle\Entity\BAAllocatedTouchpointLD;
use MissionControl\Bundle\LightdataBundle\Entity\BAATAllocationLD;
use MissionControl\Bundle\LightdataBundle\Entity\BAATAResultLD;
use MissionControl\Bundle\LightdataBundle\Entity\BAATARIndividualPerformanceLD;
use MissionControl\Bundle\LightdataBundle\Entity\BATotalLD;
use MissionControl\Bundle\LightdataBundle\Entity\BATOAllocationLD;
use MissionControl\Bundle\LightdataBundle\Entity\BATOAResultLD;
use MissionControl\Bundle\LightdataBundle\Entity\BATOARIndividualPerformanceLD;
use MissionControl\Bundle\LightdataBundle\Entity\TimeAllocationLD;
use MissionControl\Bundle\LightdataBundle\Entity\TAAllocatedTouchpointLD;
use MissionControl\Bundle\LightdataBundle\Entity\TAATAllocationByPeriod;
use MissionControl\Bundle\LightdataBundle\Entity\TAATABPResult;
use MissionControl\Bundle\LightdataBundle\Entity\TAATABPRIndividualPerformance;
use MissionControl\Bundle\LightdataBundle\Entity\TATotalLD;
use MissionControl\Bundle\LightdataBundle\Entity\TATOAllocationByPeriod;
use MissionControl\Bundle\LightdataBundle\Entity\TATOABPResult;
use MissionControl\Bundle\LightdataBundle\Entity\TATOABPRIndividualPerformance;
use MissionControl\Bundle\LightdataBundle\Entity\WhatIfResult;
use MissionControl\Bundle\LightdataBundle\Entity\WIRConfig;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPoint;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPCMDetail;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPCMTotal;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPOMDetail;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPOMTotal;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPSTMDetail;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPSTMTotal;
use MissionControl\Bundle\LightdataBundle\Entity\WIRCOptimizedFunction;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPCurrentMix;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPOptimizedMix;
use MissionControl\Bundle\LightdataBundle\Entity\WIRPSingleTouchpointMix;
//This fixture must only load AFTER the original users are already loaded to the database.
// WHAT WE KNOW : CAMPAIGN UUID : f29a70c2-2ea1-4dbc-bbf8-c4787e48092f
// USER IS ONE OF ORIGINALS
//



class LoadAxeDefaultCampaignData extends AbstractFixture implements OrderedFixtureInterface {

    public function timezoneUTC() {
        return new \DateTimeZone('UTC');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
//        $creationDate = new \DateTime();
//        $creationDate->setTimezone(self::timezoneUTC());
//
//        $creator_email = 'Bret.Leece@Initiative.com';
//        $creator_user = $manager->getRepository('UserBundle:User')->findOneByEmail($creator_email);
//
//        //FIELDS NECCESARY :
//        //'id','name', 'product','country','status','presented','completion_date','deliverable_date',token,
//
//        $axe_campaign_data = array(
//            //id
//            'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f',
//            //name
//            'AXE OCTO III W2',
//            //product (this will fetch the other related)
//            100,
//            //country
//            'Colombia', // can fetch the region
//            //campaign_status
//            '1', //build
//            //presented_to_client
//            true, // true
//            // CompletionDate
//            '2015-05-05',
//            // DeliverableDate
//            '2015-05-05',
//            //TOKEN KEY (another uUID)
//            'b5c152e0-3cab-4c60-abfd-53070b73717c',
//        );
//
//        $product_id = $axe_campaign_data[2];
//        //Reverse fetch this by the unique product id of this campaign.
//        $product = $manager->getRepository('CampaignBundle:Product')->findOneBy(['name' => 'Deodorants']);
//        $country = $manager->getRepository('CampaignBundle:Country')->findOneByName($axe_campaign_data[3]);
//        $status = $manager->getRepository('CampaignBundle:Campaignstatus')->find($axe_campaign_data[4]);
//
//
//        $productline = $product->getProductline();
//        $brand = $productline->getBrand();
//        $division = $brand->getDivision();
//        $client = $division->getClient();
//
//        $completion_date = new \DateTime($axe_campaign_data[6]);
//        $completion_date->setTimezone(self::timezoneUTC());
//        $deliverable_date = new \DateTime($axe_campaign_data[7]);
//        $deliverable_date->setTimezone(self::timezoneUTC());
//
//
//        $campaign = new Campaign();
//
//        $campaign->setUser($creator_user);
//        $campaign->setId($axe_campaign_data[0]);
//        $campaign->setName($axe_campaign_data[1]);
//        $campaign->setClient($client);
//        $campaign->setDivision($division);
//        $campaign->setBrand($brand);
//        $campaign->setProductline($productline);
//        $campaign->setProduct($product);
//        $campaign->setCountry($country);
//        $campaign->setCampaignstatus($status);
//        $campaign->setNotVisible(false);
//        $campaign->setScreentype('10000');
//        $campaign->setCompleteness(0);
//        $campaign->setCompletionDate($completion_date);
//        $campaign->setClientDeliverabledate($deliverable_date);
//        $campaign->setClientPresentation($axe_campaign_data[5]);
//        $campaign->setToken($axe_campaign_data[8]);
//        $campaign->setCreatedAt($creationDate);
//        $campaign->setUpdatedAt($creationDate);
//
//
//
//
//        $manager->persist($campaign);
//
//        $add_as_teammember = new Teammember();
//        $add_as_teammember->setCampaign($campaign);
//        $add_as_teammember->setMember($creator_user);
//        $add_as_teammember->setIsReviewer(false);
//        $manager->persist($add_as_teammember);
//
//
//
//
//
//        //GENERATE THE TASKS FOR THIS CAMPAIGN.....
//
//        $task_types = $manager->getRepository('TaskBundle:Taskname')->findAll();
//        $default_task_status = $manager->getRepository('TaskBundle:Taskstatus')->find(1);
//
//        foreach ($task_types as $tasktype) {
//
//            $new_task = new Task();
//            $new_task->setCampaign($campaign);
//            $new_task->setTaskname($tasktype);
//            $new_task->setOwner($creator_user);
//            $new_task->setTaskmessage(NULL);
//            $new_task->setMatrixfileversion(0);
//            $new_task->setTaskstatus($default_task_status);
//            $new_task->setPhase($tasktype->getPhaseid());
//            $new_task->setCreatedAt($creationDate);
//            $new_task->setCreatedby($creator_user);
//            $new_task->setUpdatedAt($creationDate);
//            $manager->persist($new_task);
//        }
//        $manager->flush();
//
//        ///////////////////////////////////////////////////////////
//        //ADD THE FILE 1
//        ///////////////////////////////////////////////////////////
//        $project_file_datas = self::getProjectFileData();
//
//        //THIS IS A LITTLE MORE COMPLICATED THAN WE FIRST THOUGHT.
//
//        //WE MUST CHECK THE USER'S NAME , AND SET THE FILE-> USER TO THE SPECIFIED NAME....
//
//
//        foreach ($project_file_datas as $project_file_data) {
//
//            //GRAB THE USER THAT CREATED THIS FILE IF EXISTS
//            $user_that_created_this_file = $manager->getRepository('UserBundle:User')->findOneByUsername('bosdoit');
//            $taskname = $manager->getRepository('TaskBundle:Taskname')->find(8);
//            $the_task = $manager->getRepository('TaskBundle:Task')->findOneBy([
//                'campaign'=> $campaign,
//                'taskname' => $taskname
//                    ]);
//            $filetype = $manager->getRepository('CampaignBundle:Filetype')->findOneById($project_file_data['file_type_id']);
//
//            $file = new File();
//            $file->setUuid($project_file_data['uuid']);
//            $file->setFileName($project_file_data['file_name']);
//            $file->setOriginalName($project_file_data['original_name']);
//            $file->setContentType($project_file_data['content_type']);
//            $file->setFileLength($project_file_data['file_length']);
//            $file->setCreatedAt($creationDate);
//            $file->setUpdatedAt($creationDate);
//            $file->setCampaign($campaign);
//            $file->setUser($project_file_data['user_creator_id'] ? $user_that_created_this_file : null);
//            $file->setTask($project_file_data['task_id'] ? $the_task : null);
//            $file->setFileType($project_file_data['file_type_id'] ? $filetype : null);
//            $file->setVersion($project_file_data['version']);
//            $file->setNotVisible(false);
//            $file->setPath($project_file_data['path']);
//
//            $manager->persist($file);
//        }
//
//            $jsondatastring = Self::defaultJsonData();
//            $actual_parsing = self::parseTheLightdataString($jsondatastring,$campaign->getId(),$manager);
//            $campaign->setLightdata($actual_parsing);
//            $campaign->setMatrixfileUuid('e99fa036-c98f-481a-b83f-8e146abe64f4');
//            $campaign->setMatrixfileVersion(1);
//        $manager->flush();
//
//
//
//        echo 'Axe campaign created. Tasks Created Too. Added user as teammember & set as taskowner. Added the 18 files too.';
    }

    public function getProjectFileData() {

        $project_file = array(
            array('uuid' => '322660e0-4101-46e2-9812-5a39e1c42aa6', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => '322660e0-4101-46e2-9812-5a39e1c42aa6.xlsx', 'original_name' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f_flow.xlsx', 'content_type' => '.xlsx', 'file_length' => '9298', 'created_at' => '2015-03-03 16:03:29', 'updated_at' => '2015-03-03 16:03:29', 'path' => 'uploads/campaign_files/f29a70c2-2ea1-4dbc-bbf8-c4787e48092f/322660e0-4101-46e2-9812-5a39e1c42aa6.xlsx', 'task_id' => '107', 'user_creator_id' => '64', 'file_type_id' => '12', 'version' => '5', 'not_visible' => 0),
            array('uuid' => '960962f1-cc39-4cbe-b5d6-2cfddba78f4f', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => '960962f1-cc39-4cbe-b5d6-2cfddba78f4f.xlsx', 'original_name' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f_flow.xlsx', 'content_type' => '.xlsx', 'file_length' => '9312', 'created_at' => '2015-03-03 15:50:20', 'updated_at' => '2015-03-03 15:50:20', 'path' => 'uploads/campaign_files/f29a70c2-2ea1-4dbc-bbf8-c4787e48092f/960962f1-cc39-4cbe-b5d6-2cfddba78f4f.xlsx', 'task_id' => '107', 'user_creator_id' => '64', 'file_type_id' => '12', 'version' => '4', 'not_visible' => 0),
            array('uuid' => 'acac5062-1fd1-4edd-ac79-bb160021bc4a', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => 'acac5062-1fd1-4edd-ac79-bb160021bc4a.xlsx', 'original_name' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f_flow.xlsx', 'content_type' => '.xlsx', 'file_length' => '9298', 'created_at' => '2015-03-03 15:43:08', 'updated_at' => '2015-03-03 15:43:08', 'path' => 'uploads/campaign_files/f29a70c2-2ea1-4dbc-bbf8-c4787e48092f/acac5062-1fd1-4edd-ac79-bb160021bc4a.xlsx', 'task_id' => '107', 'user_creator_id' => '64', 'file_type_id' => '12', 'version' => '2', 'not_visible' => 0),
            array('uuid' => 'c6c21fa9-686c-4dae-aeee-a6adbfe03f77', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => 'c6c21fa9-686c-4dae-aeee-a6adbfe03f77.xlsx', 'original_name' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f_flow.xlsx', 'content_type' => '.xlsx', 'file_length' => '9312', 'created_at' => '2015-03-03 15:46:00', 'updated_at' => '2015-03-03 15:46:00', 'path' => 'uploads/campaign_files/f29a70c2-2ea1-4dbc-bbf8-c4787e48092f/c6c21fa9-686c-4dae-aeee-a6adbfe03f77.xlsx', 'task_id' => '107', 'user_creator_id' => '64', 'file_type_id' => '12', 'version' => '3', 'not_visible' => 0),
            array('uuid' => 'e99fa036-c98f-481a-b83f-8e146abe64f4', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => 'e99fa036-c98f-481a-b83f-8e146abe64f4.uld', 'original_name' => 'C:\\Users\\bertrand.osdoit\\AppData\\Local\\Temp\\tmp45CA.tmp.uld', 'content_type' => '.uld', 'file_length' => '662560', 'created_at' => '2015-01-26 19:26:16', 'updated_at' => '2015-01-26 19:26:16', 'path' => 'uploads/xml/e99fa036-c98f-481a-b83f-8e146abe64f4.uld', 'task_id' => NULL, 'user_creator_id' => NULL, 'file_type_id' => NULL, 'version' => '1', 'not_visible' => 0),
            array('uuid' => 'ffcb3467-53d1-453f-87a4-98879afb49bf', 'campaign_uuid' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f', 'file_name' => 'ffcb3467-53d1-453f-87a4-98879afb49bf.xlsx', 'original_name' => 'f29a70c2-2ea1-4dbc-bbf8-c4787e48092f_flow.xlsx', 'content_type' => '.xlsx', 'file_length' => '9312', 'created_at' => '2015-03-03 09:39:28', 'updated_at' => '2015-03-03 09:39:28', 'path' => 'uploads/campaign_files/f29a70c2-2ea1-4dbc-bbf8-c4787e48092f/ffcb3467-53d1-453f-87a4-98879afb49bf.xlsx', 'task_id' => '107', 'user_creator_id' => '64', 'file_type_id' => '12', 'version' => '1', 'not_visible' => 0)
        );
        return $project_file;
    }

    public function defaultJsonData() {
        return '{"Setup":{"Survey":{"DbID":635,"Name":"Colombia - 2014 - Unilever Datafile"},"Target":{"DbID":100954,"Name":"Male 18-25"},"Client":{"DbID":888905,"Name":"Unilever Deo Fragrance"},"ProjectName":"AXE OCTO III W2","StartDate":"2015-01-05T00:00:00","PeriodType":0,"NbPeriods":23,"Budget":909736.0,"BudgetCurrency":"EUR"},"Objectives":[{"Name":"Notice","HtmlColor":"#33CCCC","Selected":true,"Score":0.348999675068468},{"Name":"Want/Desire","HtmlColor":"#33CCCC","Selected":false,"Score":0.180846779847958},{"Name":"Understand","HtmlColor":"#33CCCC","Selected":false,"Score":0.0195294634911304},{"Name":"Talk About","HtmlColor":"#33CCCC","Selected":true,"Score":0.247918195487781},{"Name":"Recommend","HtmlColor":"#33CCCC","Selected":false,"Score":0.057939769399637},{"Name":"Seek More Information","HtmlColor":"#33CCCC","Selected":false,"Score":0.0209580838323353},{"Name":"Try/Buy","HtmlColor":"#33CCCC","Selected":false,"Score":0.123808032872691}],"Groupings":[{"Name":"VIDEO","Categories":[{"Name":"N/A","HtmlColor":"Gray"},{"Name":"Audio","HtmlColor":"Black"},{"Name":"Display","HtmlColor":"Yellow"},{"Name":"Video","HtmlColor":"Aqua"},{"Name":"Dispaly","HtmlColor":"Gray"}],"TouchpointCategoryMap":{"TV - Ad":3,"TV - Infomercial or advertorial":3,"TV - Product placement":3,"TV - Sponsorship":3,"Radio - Ad":1,"Radio - Promo, competition, sponsorship":1,"Magazine - Ad":2,"Newspaper - Ad":2,"Print - Advertorial or editorial":2,"Print - Loose insert":2,"OOH - Airport ad":2,"OOH - Bar or restaurant ad":2,"OOH - Gym or healthclub ad":2,"OOH - In-flight ad":2,"OOH - Large Posters":2,"OOH - Public transport":2,"OOH - Small Posters":2,"Cinema - Ad":3,"Direct Mail":2,"Events - Other":2,"Events - Sport":2,"Online - Ad":2,"Online - Blogs and review sites":2,"Online - Company website":2,"Online - Email":2,"Online - Instant messaging":2,"Online - magazine ad":2,"Online - newspaper ad":2,"Online - Radio, music services or podcasts":1,"Online - Search":2,"Online - Social media mention or like":2,"Online - Tablets":2,"Online - TV":3,"Online - Video":3,"Online - Branded videos":3,"Online - Social media branded pages":2,"Online - Social media ad":2,"Online - Group deals":2,"Online - in-store promotion":2,"Mobile - Game or app":2,"Mobile - Online ad":2,"Mobile - Online search":2,"Mobile - SMS/MMS":2,"Mobile - voucher codes":2,"Mobile - ad in online radio or music service":1,"Mobile - barcode scan":2,"In-store - Coupon":2,"Free sample":2,"In-store - Ad":2,"In-store - Circular":2,"In-store - Demonstration":2,"In-store - Promotion":2,"Product Packaging":2,"Endorsement - Celebrity":2,"Endorsement - Expert":1,"Endorsement - Friends or family":1,"Positive mention in media":2,"In-game ad - Console or online":3}},{"Name":"POE","Categories":[{"Name":"N/A","HtmlColor":"Gray"},{"Name":"Earned","HtmlColor":"#8DC63F"},{"Name":"Owned","HtmlColor":"#FCB813"},{"Name":"Paid","HtmlColor":"#E21B23"}],"TouchpointCategoryMap":{"TV - Ad":3,"TV - Infomercial or advertorial":3,"TV - Product placement":3,"TV - Sponsorship":3,"Radio - Ad":3,"Radio - Promo, competition, sponsorship":3,"Magazine - Ad":3,"Newspaper - Ad":3,"Print - Advertorial or editorial":3,"Print - Loose insert":3,"OOH - Airport ad":3,"OOH - Bar or restaurant ad":3,"OOH - Gym or healthclub ad":3,"OOH - In-flight ad":3,"OOH - Large Posters":3,"OOH - Public transport":3,"OOH - Small Posters":3,"Cinema - Ad":3,"Direct Mail":2,"Events - Other":3,"Events - Sport":3,"Online - Ad":3,"Online - Blogs and review sites":1,"Online - Company website":2,"Online - Email":2,"Online - Instant messaging":3,"Online - magazine ad":3,"Online - newspaper ad":3,"Online - Radio, music services or podcasts":3,"Online - Search":3,"Online - Social media mention or like":1,"Online - Tablets":3,"Online - TV":3,"Online - Video":3,"Online - Branded videos":2,"Online - Social media branded pages":2,"Online - Social media ad":3,"Online - Group deals":3,"Online - in-store promotion":2,"Mobile - Game or app":2,"Mobile - Online ad":3,"Mobile - Online search":3,"Mobile - SMS/MMS":3,"Mobile - voucher codes":2,"Mobile - ad in online radio or music service":3,"Mobile - barcode scan":2,"In-store - Coupon":2,"Free sample":2,"In-store - Ad":3,"In-store - Circular":3,"In-store - Demonstration":2,"In-store - Promotion":3,"Product Packaging":2,"Endorsement - Celebrity":3,"Endorsement - Expert":1,"Endorsement - Friends or family":1,"Positive mention in media":1,"In-game ad - Console or online":3}},{"Name":"MEDIA GROUP","Categories":[{"Name":"TV","HtmlColor":"#8FC73E"},{"Name":"Radio","HtmlColor":"#B2B4B6"},{"Name":"Print","HtmlColor":"#652D90"},{"Name":"OOH","HtmlColor":"#FFE800"},{"Name":"Cinema","HtmlColor":"#082666"},{"Name":"Direct","HtmlColor":"#BE1E2D"},{"Name":"Events","HtmlColor":"#EB008B"},{"Name":"Online","HtmlColor":"#00A4E4"},{"Name":"Mobile","HtmlColor":"#FBB040"},{"Name":"Retail/POS","HtmlColor":"#0067B1"},{"Name":"Endorsement/PR","HtmlColor":"#717073"},{"Name":"Gaming","HtmlColor":"#8A5D3B"},{"Name":"UNDEFINED","HtmlColor":"Gray"},{"Name":"N/A","HtmlColor":"Gray"}],"TouchpointCategoryMap":{"TV - Ad":0,"TV - Infomercial or advertorial":0,"TV - Product placement":0,"TV - Sponsorship":0,"Radio - Ad":1,"Radio - Promo, competition, sponsorship":1,"Magazine - Ad":2,"Newspaper - Ad":2,"Print - Advertorial or editorial":2,"Print - Loose insert":2,"OOH - Airport ad":3,"OOH - Bar or restaurant ad":3,"OOH - Gym or healthclub ad":3,"OOH - In-flight ad":3,"OOH - Large Posters":3,"OOH - Public transport":3,"OOH - Small Posters":3,"Cinema - Ad":4,"Direct Mail":5,"Events - Other":6,"Events - Sport":6,"Online - Ad":7,"Online - Blogs and review sites":7,"Online - Company website":7,"Online - Email":7,"Online - Instant messaging":7,"Online - magazine ad":7,"Online - newspaper ad":7,"Online - Radio, music services or podcasts":7,"Online - Search":7,"Online - Social media mention or like":7,"Online - Tablets":7,"Online - TV":7,"Online - Video":7,"Online - Branded videos":7,"Online - Social media branded pages":7,"Online - Social media ad":7,"Online - Group deals":7,"Online - in-store promotion":7,"Mobile - Game or app":8,"Mobile - Online ad":8,"Mobile - Online search":8,"Mobile - SMS/MMS":8,"Mobile - voucher codes":8,"Mobile - ad in online radio or music service":8,"Mobile - barcode scan":8,"In-store - Coupon":9,"Free sample":9,"In-store - Ad":9,"In-store - Circular":9,"In-store - Demonstration":9,"In-store - Promotion":9,"Product Packaging":9,"Endorsement - Celebrity":10,"Endorsement - Expert":10,"Endorsement - Friends or family":10,"Positive mention in media":10,"In-game ad - Console or online":11}}],"CurrentGroupingIndex":0,"Touchpoints":[{"Name":"TV - Ad","LocalName":"TV - Ad","HtmlColor":"#8FC73E","Selected":true,"AggObjectiveScore":0.249164,"ObjectiveScores":[0.346127,0.242904,0.222341,0.152201,0.148141,0.130349,0.313064],"AttributeScores":[0.0472973,0.0315315,0.162162,0.0405405,0.0923423,0.342342,0.105856,0.144144,0.558559,0.144144,0.628378,0.941441,0.387387,0.0855856,0.274775]},{"Name":"TV - Infomercial or advertorial","LocalName":"TV - Infomercial or advertorial","HtmlColor":"#ABD56E","Selected":false,"AggObjectiveScore":0.227791,"ObjectiveScores":[0.290673,0.286563,0.233904,0.164909,0.20384,0.160655,0.257612],"AttributeScores":[0.045045,0.0765766,0.173423,0.0855856,0.11036,0.324324,0.0495495,0.207207,0.497748,0.153153,0.40991,0.434685,0.168919,0.105856,0.416667]},{"Name":"TV - Product placement","LocalName":"TV - Product placement","HtmlColor":"#C7E39E","Selected":false,"AggObjectiveScore":0.255691,"ObjectiveScores":[0.387338,0.323025,0.171232,0.124044,0.188387,0.143202,0.266981],"AttributeScores":[0.018018,0.045045,0.0472973,0.0247748,0.144144,0.423423,0.0405405,0.105856,0.601351,0.148649,0.108108,0.34009,0.0698198,0.0472973,0.459459]},{"Name":"TV - Sponsorship","LocalName":"TV - Sponsorship","HtmlColor":"#E3F1CE","Selected":false,"AggObjectiveScore":0.2912915,"ObjectiveScores":[0.405711,0.321148,0.146632,0.176872,0.192268,0.110871,0.245826],"AttributeScores":[0.036036,0.0563063,0.0810811,0.0743243,0.0900901,0.477477,0.0743243,0.126126,0.425676,0.286036,0.52027,0.601351,0.150901,0.0472973,0.490991]},{"Name":"Radio - Ad","LocalName":"Radio - Ad","HtmlColor":"#B2B4B6","Selected":true,"AggObjectiveScore":0.267529,"ObjectiveScores":[0.322038,0.220339,0.199332,0.21302,0.200475,0.172382,0.266615],"AttributeScores":[0.0157658,0.036036,0.38964,0.0833333,0.0675676,0.189189,0.373874,0.184685,0.240991,0.202703,0.65991,0.563063,0.65991,0.0990991,0.213964]},{"Name":"Radio - Promo, competition, sponsorship","LocalName":"Radio - Promo, competition, sponsorship","HtmlColor":"#D8D9DA","Selected":false,"AggObjectiveScore":0.263915,"ObjectiveScores":[0.287736,0.226754,0.227653,0.240094,0.21905,0.190891,0.231867],"AttributeScores":[0.158784,0.0641892,0.185811,0.297297,0.103604,0.390766,0.193694,0.114865,0.394144,0.176802,0.481982,0.338964,0.448198,0.115991,0.359234]},{"Name":"Magazine - Ad","LocalName":"Magazine - Ad","HtmlColor":"#652D90","Selected":true,"AggObjectiveScore":0.2628615,"ObjectiveScores":[0.355538,0.268017,0.22377,0.170185,0.172454,0.193205,0.242829],"AttributeScores":[0.0427928,0.0427928,0.0563063,0.0202703,0.0337838,0.369369,0.0405405,0.153153,0.211712,0.385135,0.00675676,0.254505,0.177928,0.0540541,0.380631]},{"Name":"Newspaper - Ad","LocalName":"Newspaper - Ad","HtmlColor":"#8B61AB","Selected":false,"AggObjectiveScore":0.269406,"ObjectiveScores":[0.340975,0.221477,0.245676,0.197837,0.25525,0.227246,0.207896],"AttributeScores":[0.045045,0.0540541,0.220721,0.0292793,0.045045,0.234234,0.272523,0.177928,0.191441,0.211712,0.045045,0.59009,0.578829,0.105856,0.283784]},{"Name":"Print - Advertorial or editorial","LocalName":"Print - Advertorial or editorial","HtmlColor":"#B296C7","Selected":false,"AggObjectiveScore":0.272541,"ObjectiveScores":[0.373485,0.26954,0.22905,0.171597,0.179582,0.141189,0.234836],"AttributeScores":[0.045045,0.0518018,0.045045,0.045045,0.0608108,0.416667,0.0292793,0.164414,0.344595,0.256757,0.0045045,0.204955,0.146396,0.0698198,0.448198]},{"Name":"Print - Loose insert","LocalName":"Print - Loose insert","HtmlColor":"#D8CAE3","Selected":false,"AggObjectiveScore":0.269769,"ObjectiveScores":[0.346277,0.198608,0.326966,0.193261,0.153042,0.190602,0.220386],"AttributeScores":[0.0900901,0.0427928,0.162162,0.0563063,0.0608108,0.150901,0.0788288,0.15991,0.15991,0.168919,0.0157658,0.288288,0.371622,0.0743243,0.213964]},{"Name":"OOH - Airport ad","LocalName":"OOH - Airport ad","HtmlColor":"#FFE800","Selected":false,"AggObjectiveScore":0.268334,"ObjectiveScores":[0.334345,0.26986,0.18477,0.202323,0.209434,0.182038,0.247991],"AttributeScores":[0.018018,0.0225225,0.155405,0.0135135,0.0202703,0.225225,0.0247748,0.11036,0.162162,0.259009,0.0247748,0.150901,0.439189,0.0382883,0.31982]},{"Name":"OOH - Bar or restaurant ad","LocalName":"OOH - Bar or restaurant ad","HtmlColor":"#FFEB24","Selected":false,"AggObjectiveScore":0.212618,"ObjectiveScores":[0.263112,0.294719,0.179172,0.162124,0.210838,0.144869,0.270156],"AttributeScores":[0.027027,0.027027,0.445946,0.045045,0.0563063,0.184685,0.045045,0.101351,0.301802,0.297297,0.101351,0.0405405,0.421171,0.0855856,0.346847]},{"Name":"OOH - Gym or healthclub ad","LocalName":"OOH - Gym or healthclub ad","HtmlColor":"#FFEE48","Selected":false,"AggObjectiveScore":0.2365295,"ObjectiveScores":[0.347247,0.276274,0.228803,0.125812,0.22911,0.115996,0.250844],"AttributeScores":[0.018018,0.0337838,0.148649,0.027027,0.0225225,0.198198,0.036036,0.119369,0.211712,0.538288,0.045045,0.0337838,0.427928,0.0833333,0.439189]},{"Name":"OOH - In-flight ad","LocalName":"OOH - In-flight ad","HtmlColor":"#FFF16D","Selected":false,"AggObjectiveScore":0.2652085,"ObjectiveScores":[0.328532,0.286165,0.21213,0.201885,0.226395,0.167587,0.21253],"AttributeScores":[0.0202703,0.027027,0.0923423,0.0157658,0.00900901,0.177928,0.0247748,0.0855856,0.164414,0.292793,0.0698198,0.0405405,0.171171,0.0292793,0.342342]},{"Name":"OOH - Large Posters","LocalName":"OOH - Large Posters","HtmlColor":"#FFF591","Selected":false,"AggObjectiveScore":0.322544,"ObjectiveScores":[0.419258,0.36045,0.134835,0.22583,0.129201,0.14653,0.244857],"AttributeScores":[0.018018,0.0202703,0.349099,0.0135135,0.0518018,0.121622,0.0405405,0.135135,0.268018,0.0405405,0.018018,0.621622,0.605856,0.0405405,0.114865]},{"Name":"OOH - Public transport","LocalName":"OOH - Public transport","HtmlColor":"#FFF8B6","Selected":false,"AggObjectiveScore":0.3434705,"ObjectiveScores":[0.464791,0.240379,0.170425,0.22215,0.154982,0.188085,0.205568],"AttributeScores":[0.0135135,0.0157658,0.290541,0.0247748,0.0608108,0.0900901,0.0337838,0.157658,0.216216,0.0743243,0.0495495,0.5,0.635135,0.0427928,0.164414]},{"Name":"OOH - Small Posters","LocalName":"OOH - Small Posters","HtmlColor":"#FFFBDA","Selected":false,"AggObjectiveScore":0.2386335,"ObjectiveScores":[0.345527,0.318052,0.184362,0.13174,0.126085,0.166972,0.29019],"AttributeScores":[0.00900901,0.0157658,0.531532,0.0382883,0.0427928,0.0968468,0.0878378,0.162162,0.204955,0.105856,0.0247748,0.468468,0.605856,0.0608108,0.175676]},{"Name":"Cinema - Ad","LocalName":"Cinema - Ad","HtmlColor":"#082666","Selected":false,"AggObjectiveScore":0.283392,"ObjectiveScores":[0.388043,0.288017,0.143639,0.178741,0.169833,0.164032,0.265332],"AttributeScores":[0.0202703,0.0202703,0.0878378,0.0292793,0.0540541,0.322072,0.0292793,0.130631,0.407658,0.272523,0.213964,0.150901,0.470721,0.0382883,0.405405]},{"Name":"Direct Mail","LocalName":"Direct Mail","HtmlColor":"#BE1E2D","Selected":false,"AggObjectiveScore":0.2768315,"ObjectiveScores":[0.398997,0.206524,0.20866,0.154666,0.175666,0.166942,0.257452],"AttributeScores":[0.349099,0.155405,0.157658,0.283784,0.148649,0.439189,0.144144,0.490991,0.164414,0.686937,0.0788288,0.0743243,0.576577,0.367117,0.247748]},{"Name":"Events - Other","LocalName":"Events - Other","HtmlColor":"#EB008B","Selected":false,"AggObjectiveScore":0.273717,"ObjectiveScores":[0.353838,0.329323,0.144445,0.193596,0.188484,0.129589,0.226291],"AttributeScores":[0.0427928,0.0247748,0.00675676,0.0990991,0.112613,0.594595,0.0157658,0.0698198,0.459459,0.218468,0.0563063,0.0720721,0.186937,0.0518018,0.326577]},{"Name":"Events - Sport","LocalName":"Events - Sport","HtmlColor":"#F57FC5","Selected":false,"AggObjectiveScore":0.264936,"ObjectiveScores":[0.3551,0.377896,0.160903,0.174772,0.164312,0.112668,0.214647],"AttributeScores":[0.018018,0.018018,0.027027,0.0788288,0.0855856,0.662162,0.0157658,0.0585586,0.457207,0.220721,0.0315315,0.218468,0.209459,0.0337838,0.308559]},{"Name":"Online - Ad","LocalName":"Online - Ad","HtmlColor":"#00A4E4","Selected":true,"AggObjectiveScore":0.2936715,"ObjectiveScores":[0.35206,0.257086,0.198647,0.235283,0.142047,0.197754,0.246736],"AttributeScores":[0.292793,0.150901,0.150901,0.468468,0.324324,0.117117,0.481982,0.331081,0.171171,0.34009,0.432432,0.38964,0.326577,0.204955,0.279279]},{"Name":"Online - Blogs and review sites","LocalName":"Online - Blogs and review sites","HtmlColor":"#0EA9E5","Selected":false,"AggObjectiveScore":0.2266815,"ObjectiveScores":[0.271686,0.244553,0.25894,0.181677,0.255627,0.159158,0.241668],"AttributeScores":[0.0709459,0.0990991,0.122748,0.296171,0.39527,0.407658,0.0878378,0.0765766,0.565315,0.136261,0.0259009,0.0292793,0.0461712,0.105856,0.149775]},{"Name":"Online - Company website","LocalName":"Online - Company website","HtmlColor":"#1CAEE7","Selected":false,"AggObjectiveScore":0.2461745,"ObjectiveScores":[0.324786,0.297681,0.209777,0.167563,0.180802,0.174769,0.234822],"AttributeScores":[0.522523,0.189189,0.243243,0.619369,0.259009,0.572072,0.29955,0.13964,0.315315,0.114865,0.0720721,0.027027,0.0833333,0.317568,0.432432]},{"Name":"Online - Email","LocalName":"Online - Email","HtmlColor":"#2AB3E8","Selected":false,"AggObjectiveScore":0.302803,"ObjectiveScores":[0.370764,0.235535,0.205746,0.234842,0.155046,0.176491,0.233588],"AttributeScores":[0.441441,0.182432,0.175676,0.486486,0.405405,0.396396,0.328829,0.486486,0.222973,0.621622,0.209459,0.0788288,0.43018,0.367117,0.274775]},{"Name":"Online - Instant messaging","LocalName":"Online - Instant messaging","HtmlColor":"#38B8EA","Selected":false,"AggObjectiveScore":0.2865475,"ObjectiveScores":[0.345205,0.242077,0.272825,0.22789,0.138955,0.169355,0.233469],"AttributeScores":[0.171171,0.11036,0.0720721,0.313063,0.328829,0.0923423,0.256757,0.240991,0.301802,0.344595,0.20045,0.166667,0.213964,0.148649,0.135135]},{"Name":"Online - magazine ad","LocalName":"Online - magazine ad","HtmlColor":"#46BDEB","Selected":false,"AggObjectiveScore":0.2504365,"ObjectiveScores":[0.320788,0.294299,0.248744,0.180085,0.201862,0.183672,0.209744],"AttributeScores":[0.211712,0.0968468,0.0810811,0.281532,0.182432,0.247748,0.272523,0.175676,0.211712,0.454955,0.186937,0.0833333,0.18018,0.117117,0.362613]},{"Name":"Online - newspaper ad","LocalName":"Online - newspaper ad","HtmlColor":"#55C2ED","Selected":false,"AggObjectiveScore":0.2452575,"ObjectiveScores":[0.333961,0.269991,0.235864,0.156554,0.225073,0.220878,0.207577],"AttributeScores":[0.198198,0.0855856,0.0743243,0.247748,0.186937,0.18018,0.355856,0.189189,0.148649,0.315315,0.254505,0.286036,0.279279,0.119369,0.27027]},{"Name":"Online - Radio, music services or podcasts","LocalName":"Online - Radio, music services or podcasts","HtmlColor":"#63C7EE","Selected":false,"AggObjectiveScore":0.312586,"ObjectiveScores":[0.392183,0.257707,0.183702,0.232989,0.167801,0.157545,0.222854],"AttributeScores":[0.138514,0.109234,0.0472973,0.22973,0.224099,0.298423,0.188063,0.175676,0.265766,0.288288,0.183559,0.0596847,0.143018,0.103604,0.28491]},{"Name":"Online - Search","LocalName":"Online - Search","HtmlColor":"#71CCF0","Selected":false,"AggObjectiveScore":0.2548535,"ObjectiveScores":[0.324354,0.216364,0.331597,0.185353,0.229317,0.297736,0.14418],"AttributeScores":[0.272523,0.132883,0.31982,0.261261,0.182432,0.0720721,0.398649,0.290541,0.108108,0.342342,0.252252,0.20045,0.25,0.394144,0.290541]},{"Name":"Online - Social media mention or like","LocalName":"Online - Social media mention or like","HtmlColor":"#7FD1F1","Selected":false,"AggObjectiveScore":0.2598625,"ObjectiveScores":[0.27125,0.300768,0.127056,0.248475,0.240338,0.163576,0.228118],"AttributeScores":[0.432432,0.306306,0.108108,0.626126,0.657658,0.344595,0.387387,0.40991,0.518018,0.472973,0.259009,0.292793,0.306306,0.351351,0.254505]},{"Name":"Online - Tablets","LocalName":"Online - Tablets","HtmlColor":"#8DD6F3","Selected":false,"AggObjectiveScore":0.297456,"ObjectiveScores":[0.41306,0.32414,0.187854,0.181852,0.17222,0.175454,0.209559],"AttributeScores":[0.222973,0.155405,0.101351,0.432432,0.268018,0.286036,0.137387,0.162162,0.306306,0.283784,0.0855856,0.0427928,0.0855856,0.175676,0.272523]},{"Name":"Online - TV","LocalName":"Online - TV","HtmlColor":"#9BDBF4","Selected":false,"AggObjectiveScore":0.3024215,"ObjectiveScores":[0.427319,0.252753,0.200822,0.177524,0.18289,0.141219,0.236363],"AttributeScores":[0.128378,0.0855856,0.0427928,0.195946,0.209459,0.207207,0.148649,0.150901,0.186937,0.290541,0.193694,0.11036,0.182432,0.137387,0.385135]},{"Name":"Online - Video","LocalName":"Online - Video","HtmlColor":"#AAE0F6","Selected":true,"AggObjectiveScore":0.283167,"ObjectiveScores":[0.379032,0.314452,0.172411,0.187302,0.162185,0.132024,0.256832],"AttributeScores":[0.123874,0.0810811,0.0427928,0.243243,0.364865,0.18018,0.184685,0.175676,0.277027,0.277027,0.236486,0.184685,0.182432,0.146396,0.322072]},{"Name":"Online - Branded videos","LocalName":"Online - Branded videos","HtmlColor":"#B8E5F7","Selected":false,"AggObjectiveScore":0.264312,"ObjectiveScores":[0.33295,0.283256,0.241325,0.195674,0.182792,0.144499,0.241655],"AttributeScores":[0.114865,0.117117,0.0675676,0.27027,0.52027,0.391892,0.103604,0.130631,0.490991,0.202703,0.11036,0.0945946,0.123874,0.144144,0.263514]},{"Name":"Online - Social media branded pages","LocalName":"Online - Social media branded pages","HtmlColor":"#C6EAF9","Selected":true,"AggObjectiveScore":0.269508,"ObjectiveScores":[0.327231,0.304646,0.200522,0.211785,0.168581,0.148114,0.241487],"AttributeScores":[0.454955,0.351351,0.128378,0.713964,0.61036,0.587838,0.358108,0.227477,0.576577,0.301802,0.137387,0.119369,0.157658,0.328829,0.335586]},{"Name":"Online - Social media ad","LocalName":"Online - Social media ad","HtmlColor":"#D4EFFA","Selected":false,"AggObjectiveScore":0.3090835,"ObjectiveScores":[0.411218,0.239407,0.179199,0.206949,0.179923,0.185837,0.225961],"AttributeScores":[0.432432,0.306306,0.108108,0.626126,0.657658,0.344595,0.387387,0.40991,0.518018,0.472973,0.259009,0.292793,0.306306,0.351351,0.254505]},{"Name":"Online - Group deals","LocalName":"Online - Group deals","HtmlColor":"#E2F4FC","Selected":false,"AggObjectiveScore":0.2332285,"ObjectiveScores":[0.306324,0.286465,0.147901,0.160133,0.160099,0.16328,0.316272],"AttributeScores":[0.31982,0.105856,0.716216,0.281532,0.18018,0.177928,0.281532,0.218468,0.153153,0.358108,0.204955,0.0608108,0.216216,0.29955,0.301802]},{"Name":"Online - in-store promotion","LocalName":"Online - in-store promotion","HtmlColor":"#F0F9FD","Selected":false,"AggObjectiveScore":0.2329075,"ObjectiveScores":[0.302574,0.281688,0.213264,0.163241,0.204061,0.175317,0.241568],"AttributeScores":[0.31982,0.105856,0.716216,0.281532,0.18018,0.177928,0.281532,0.218468,0.153153,0.358108,0.204955,0.0608108,0.216216,0.29955,0.301802]},{"Name":"Mobile - Game or app","LocalName":"Mobile - Game or app","HtmlColor":"#FBB040","Selected":false,"AggObjectiveScore":0.290449,"ObjectiveScores":[0.359455,0.307212,0.172643,0.221443,0.140557,0.146997,0.238696],"AttributeScores":[0.31982,0.204955,0.0900901,0.457207,0.333333,0.504505,0.0698198,0.112613,0.355856,0.177928,0.036036,0.0382883,0.0765766,0.231982,0.292793]},{"Name":"Mobile - Online ad","LocalName":"Mobile - Online ad","HtmlColor":"#FBBB5B","Selected":false,"AggObjectiveScore":0.305846,"ObjectiveScores":[0.412388,0.238679,0.177407,0.199304,0.169777,0.171499,0.252087],"AttributeScores":[0.184685,0.0743243,0.193694,0.297297,0.202703,0.144144,0.236486,0.191441,0.150901,0.277027,0.213964,0.119369,0.184685,0.153153,0.182432]},{"Name":"Mobile - Online search","LocalName":"Mobile - Online search","HtmlColor":"#FCC676","Selected":false,"AggObjectiveScore":0.263426,"ObjectiveScores":[0.329892,0.280578,0.198532,0.19696,0.195692,0.213504,0.225988],"AttributeScores":[0.204955,0.0788288,0.268018,0.193694,0.114865,0.0833333,0.245495,0.175676,0.103604,0.274775,0.137387,0.0855856,0.162162,0.315315,0.189189]},{"Name":"Mobile - SMS/MMS","LocalName":"Mobile - SMS/MMS","HtmlColor":"#FCD191","Selected":false,"AggObjectiveScore":0.293129,"ObjectiveScores":[0.351816,0.266092,0.184072,0.234442,0.138809,0.169143,0.253895],"AttributeScores":[0.240991,0.11036,0.29955,0.308559,0.292793,0.313063,0.236486,0.344595,0.191441,0.488739,0.236486,0.0720721,0.297297,0.272523,0.211712]},{"Name":"Mobile - voucher codes","LocalName":"Mobile - voucher codes","HtmlColor":"#FDDDAD","Selected":false,"AggObjectiveScore":0.211882,"ObjectiveScores":[0.280646,0.297186,0.208382,0.143118,0.155683,0.141115,0.293225],"AttributeScores":[0.184685,0.0743243,0.193694,0.297297,0.202703,0.144144,0.236486,0.191441,0.150901,0.277027,0.213964,0.119369,0.184685,0.153153,0.182432]},{"Name":"Mobile - ad in online radio or music service","LocalName":"Mobile - ad in online radio or music service","HtmlColor":"#FDE8C8","Selected":false,"AggObjectiveScore":0.3072735,"ObjectiveScores":[0.342636,0.280161,0.165199,0.271911,0.179579,0.21622,0.200906],"AttributeScores":[0.175676,0.126126,0.0675676,0.286036,0.186937,0.231982,0.283784,0.216216,0.22973,0.34009,0.295045,0.0855856,0.213964,0.119369,0.263514]},{"Name":"Mobile - barcode scan","LocalName":"Mobile - barcode scan","HtmlColor":"#FEF3E3","Selected":false,"AggObjectiveScore":0.280604,"ObjectiveScores":[0.319334,0.274932,0.247103,0.241874,0.177176,0.276923,0.17153],"AttributeScores":[0.335586,0.13964,0.193694,0.423423,0.20045,0.443694,0.195946,0.112613,0.245495,0.166667,0.0630631,0.0405405,0.0765766,0.238739,0.351351]},{"Name":"In-store - Coupon","LocalName":"In-store - Coupon","HtmlColor":"#0067B1","Selected":false,"AggObjectiveScore":0.2219435,"ObjectiveScores":[0.281838,0.26848,0.12746,0.162049,0.153637,0.121664,0.347231],"AttributeScores":[0.25,0.0225225,0.686937,0.0968468,0.0990991,0.328829,0.0157658,0.0563063,0.144144,0.0765766,0.0202703,0.0540541,0.268018,0.150901,0.121622]},{"Name":"Free sample","LocalName":"Free sample","HtmlColor":"#247CBC","Selected":false,"AggObjectiveScore":0.2152275,"ObjectiveScores":[0.299299,0.214449,0.194173,0.131156,0.191698,0.109871,0.335228],"AttributeScores":[0.132883,0.036036,0.376126,0.236486,0.171171,0.378378,0.018018,0.0788288,0.468468,0.144144,0.173423,0.0788288,0.468468,0.132883,0.182432]},{"Name":"In-store - Ad","LocalName":"In-store - Ad","HtmlColor":"#4892C7","Selected":false,"AggObjectiveScore":0.2177245,"ObjectiveScores":[0.294498,0.278037,0.163685,0.140951,0.190952,0.119656,0.302183],"AttributeScores":[0.0135135,0.0337838,0.822072,0.0405405,0.036036,0.126126,0.0405405,0.101351,0.0945946,0.130631,0.0337838,0.0878378,0.369369,0.0923423,0.245495]},{"Name":"In-store - Circular","LocalName":"In-store - Circular","HtmlColor":"#6DA8D2","Selected":false,"AggObjectiveScore":0.228866,"ObjectiveScores":[0.310388,0.336505,0.182402,0.147344,0.138736,0.156061,0.273129],"AttributeScores":[0.0315315,0.027027,0.707207,0.0405405,0.0292793,0.137387,0.036036,0.0810811,0.0968468,0.0923423,0.036036,0.0743243,0.29955,0.108108,0.189189]},{"Name":"In-store - Demonstration","LocalName":"In-store - Demonstration","HtmlColor":"#91BDDD","Selected":false,"AggObjectiveScore":0.237241,"ObjectiveScores":[0.337887,0.250989,0.187778,0.136595,0.206485,0.114554,0.312848],"AttributeScores":[0.207207,0.0653153,0.813063,0.522523,0.0923423,0.288288,0.0608108,0.146396,0.414414,0.168919,0.283784,0.0472973,0.373874,0.231982,0.31982]},{"Name":"In-store - Promotion","LocalName":"In-store - Promotion","HtmlColor":"#B6D3E8","Selected":false,"AggObjectiveScore":0.2313415,"ObjectiveScores":[0.320453,0.26253,0.185464,0.14223,0.163028,0.0809394,0.359815],"AttributeScores":[0.130631,0.0495495,0.873874,0.213964,0.0900901,0.204955,0.0427928,0.0720721,0.247748,0.0810811,0.0833333,0.0540541,0.29955,0.155405,0.211712]},{"Name":"Product Packaging","LocalName":"Product Packaging","HtmlColor":"#DAE9F3","Selected":false,"AggObjectiveScore":0.2419655,"ObjectiveScores":[0.30633,0.216481,0.362135,0.177601,0.215077,0.159659,0.195238],"AttributeScores":[0.027027,0.0315315,0.56982,0.0675676,0.0382883,0.245495,0.0225225,0.0518018,0.132883,0.0923423,0.0157658,0.0405405,0.0518018,0.0990991,0.292793]},{"Name":"Endorsement - Celebrity","LocalName":"Endorsement - Celebrity","HtmlColor":"#717073","Selected":false,"AggObjectiveScore":0.2210065,"ObjectiveScores":[0.296155,0.341876,0.125911,0.145858,0.263373,0.0797752,0.285635],"AttributeScores":[0.00900901,0.0247748,0.0315315,0.0630631,0.211712,0.650901,0.0315315,0.0675676,0.657658,0.0472973,0.0112613,0.211712,0.0337838,0.0405405,0.119369]},{"Name":"Endorsement - Expert","LocalName":"Endorsement - Expert","HtmlColor":"#949396","Selected":false,"AggObjectiveScore":0.181337,"ObjectiveScores":[0.153209,0.221404,0.298323,0.209465,0.319823,0.131503,0.224243],"AttributeScores":[0.0202703,0.0382883,0.141892,0.130631,0.164414,0.72973,0.0247748,0.0720721,0.565315,0.0585586,0.00675676,0.0247748,0.036036,0.0900901,0.130631]},{"Name":"Endorsement - Friends or family","LocalName":"Endorsement - Friends or family","HtmlColor":"#B8B7B9","Selected":false,"AggObjectiveScore":0.2417365,"ObjectiveScores":[0.24842,0.166124,0.206734,0.235053,0.313459,0.185056,0.238888],"AttributeScores":[0.0225225,0.0765766,0.121622,0.13964,0.29955,0.682432,0.0157658,0.0585586,0.632883,0.0855856,0.00900901,0.0292793,0.0315315,0.0653153,0.036036]},{"Name":"Positive mention in media","LocalName":"Positive mention in media","HtmlColor":"#DBDBDC","Selected":false,"AggObjectiveScore":0.2620925,"ObjectiveScores":[0.318343,0.311594,0.176831,0.205842,0.21344,0.100012,0.248412],"AttributeScores":[0.0135135,0.0405405,0.0472973,0.045045,0.227477,0.653153,0.0247748,0.0563063,0.653153,0.0518018,0.00900901,0.146396,0.0427928,0.0810811,0.119369]},{"Name":"In-game ad - Console or online","LocalName":"In-game ad - Console or online","HtmlColor":"#8A5D3B","Selected":false,"AggObjectiveScore":0.2664185,"ObjectiveScores":[0.341868,0.310929,0.163972,0.190969,0.195577,0.144317,0.258169],"AttributeScores":[0.120495,0.0720721,0.0337838,0.254505,0.157658,0.286036,0.0641892,0.118243,0.251126,0.237613,0.0765766,0.0405405,0.0720721,0.140766,0.298423]}],"CPRAttributes":[{"Name":"Capture Data","Description":"Capture data from the consumer?","Selected":false},{"Name":"Customize Messaging","Description":"Allow consumers to customize messaging and content?","Selected":false},{"Name":"Close to Purchase","Description":"Deliver the message close to purchase?","Selected":false},{"Name":"Interactivity","Description":"Enable interactivity and dialogue with consumers?","Selected":false},{"Name":"Spread Virally","Description":"Facilitate consumers to spread the message virally?","Selected":true},{"Name":"Build loyalty?","Description":"Build loyalty?","Selected":false},{"Name":"Content Changes","Description":"Allow for quick copy/content changes?","Selected":false},{"Name":"Multiple Audiences","Description":"Deliver customized messages to multiple audiences?","Selected":false},{"Name":"Stimulate Conversations","Description":"Stimulate conversations about the brand?","Selected":false},{"Name":"Precise Targeting","Description":"Deliver precise audience targeting?","Selected":false},{"Name":"Control Time of Day","Description":"Control the time of day when the consumer is exposed?","Selected":true},{"Name":"Mass Reach","Description":"Generate mass reach quickly?","Selected":true},{"Name":"Target Regions","Description":"Target consumers by specific regions within a country?","Selected":false},{"Name":"Response to Action","Description":"Deliver messages in response to a consumer action?","Selected":false},{"Name":"Control Context","Description":"Control the context in which communication appears?","Selected":true}],"BudgetAllocation":{"AllocatedTouchpoints":[{"TouchpointName":"TV - Ad","Allocation":{"Budget":367500.0,"CostPerGRP":245.0,"GRP":1500.0,"Result":{"GlobalPerformance":0.04785780957188783,"Reach":0.51645967664171111,"IndividualPerformance":[0.20395889302590417,0.096625038347233141]}}},{"TouchpointName":"Radio - Ad","Allocation":{"Budget":97069.0,"CostPerGRP":283.0,"GRP":343.0,"Result":{"GlobalPerformance":0.0065979970160161619,"Reach":0.14923162429657411,"IndividualPerformance":[0.031651388733146553,0.020963334402825332]}}},{"TouchpointName":"Magazine - Ad","Allocation":{"Budget":35416.0,"CostPerGRP":466.0,"GRP":76.0,"Result":{"GlobalPerformance":0.0051878387094041164,"Reach":0.071400047459428115,"IndividualPerformance":[0.022993492824103325,0.011562686879784102]}}},{"TouchpointName":"Online - Ad","Allocation":{"Budget":317341.0,"CostPerGRP":271.0,"GRP":1171.0,"Result":{"GlobalPerformance":0.041265761664321964,"Reach":0.37372912146086273,"IndividualPerformance":[0.12347860586543848,0.086231709642283161]}}},{"TouchpointName":"Online - Video","Allocation":{"Budget":90816.0,"CostPerGRP":264.0,"GRP":344.0,"Result":{"GlobalPerformance":0.025270547680950963,"Reach":0.086315355606669891,"IndividualPerformance":[0.051606317848569477,0.033067904899677446]}}}],"Total":{"TouchpointName":"Total","Allocation":{"Budget":908142.0,"CostPerGRP":264.45602795573677,"GRP":3434.0,"Result":{"GlobalPerformance":0.16339998207580725,"Reach":0.711257643307646,"IndividualPerformance":[0.39530515400725835,0.24604654211781812]}}}},"TimeAllocation":{"AllocatedTouchpoints":[{"AllocationByPeriod":[{"Budget":30386.974379286839,"CostPerGRP":245.0,"GRP":124.028466854232,"Result":{"GlobalPerformance":0.011213597783982236,"Reach":0.090059643649722534,"IndividualPerformance":[0.092619174333165022,0.039751075440075723]}},{"Budget":30386.974379286839,"CostPerGRP":245.0,"GRP":124.028466854232,"Result":{"GlobalPerformance":0.027483565969841736,"Reach":0.25081191887061594,"IndividualPerformance":[0.1528708702412282,0.069003625809923211]}},{"Budget":30386.974379286839,"CostPerGRP":245.0,"GRP":124.028466854232,"Result":{"GlobalPerformance":0.043285347655944752,"Reach":0.33630482674640771,"IndividualPerformance":[0.19382255655324404,0.090901890338136712]}},{"Budget":30386.974379286839,"CostPerGRP":245.0,"GRP":124.028466854232,"Result":{"GlobalPerformance":0.057029151969576072,"Reach":0.37545573698042478,"IndividualPerformance":[0.22263212126353335,0.10753091543587214]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0412547899458995,"Reach":0.32828491561290307,"IndividualPerformance":[0.18911532972985864,0.0882877893901448]}},{"Budget":20743.44229758831,"CostPerGRP":245.0,"GRP":84.6671114187278,"Result":{"GlobalPerformance":0.04675082905175474,"Reach":0.34846032779413966,"IndividualPerformance":[0.20156043663160511,0.09525892503544664]}},{"Budget":20743.44229758831,"CostPerGRP":245.0,"GRP":84.6671114187278,"Result":{"GlobalPerformance":0.051251112351504716,"Reach":0.36175417356022305,"IndividualPerformance":[0.21110687417358548,0.10074186548094685]}},{"Budget":20743.44229758831,"CostPerGRP":245.0,"GRP":84.6671114187278,"Result":{"GlobalPerformance":0.054909389977586681,"Reach":0.37081683257300257,"IndividualPerformance":[0.21849288777302947,0.10507034595243793]}},{"Budget":20743.44229758831,"CostPerGRP":245.0,"GRP":84.6671114187278,"Result":{"GlobalPerformance":0.05786978473763308,"Reach":0.37718286553681696,"IndividualPerformance":[0.2242465182953004,0.1084976411848875]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.041883747874885371,"Reach":0.33084507395887541,"IndividualPerformance":[0.19058781477711659,0.089102618015032858]}},{"Budget":20703.232986787418,"CostPerGRP":245.0,"GRP":84.5029917828058,"Result":{"GlobalPerformance":0.047232881399522988,"Reach":0.35001105248420128,"IndividualPerformance":[0.20260906871107343,0.095855279953518988]}},{"Budget":20703.232986787418,"CostPerGRP":245.0,"GRP":84.5029917828058,"Result":{"GlobalPerformance":0.051608214116060473,"Reach":0.36270272203444515,"IndividualPerformance":[0.21184200191824745,0.1011692140302447]}},{"Budget":20703.232986787418,"CostPerGRP":245.0,"GRP":84.5029917828058,"Result":{"GlobalPerformance":0.055162615144402759,"Reach":0.371393246855022,"IndividualPerformance":[0.21899261089843777,0.10536604893202313]}},{"Budget":20703.232986787418,"CostPerGRP":245.0,"GRP":84.5029917828058,"Result":{"GlobalPerformance":0.0580377528171019,"Reach":0.37752066004316925,"IndividualPerformance":[0.22456729134335543,0.10869020502328196]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.04200948455903121,"Reach":0.33134854839346239,"IndividualPerformance":[0.19088060639295759,0.089264952688932864]}},{"Budget":20144.020175818277,"CostPerGRP":245.0,"GRP":82.220490513544,"Result":{"GlobalPerformance":0.046847967716529208,"Reach":0.34877542514715076,"IndividualPerformance":[0.20177227192026798,0.095379280027658983]}},{"Budget":20144.020175818277,"CostPerGRP":245.0,"GRP":82.220490513544,"Result":{"GlobalPerformance":0.050798201779798373,"Reach":0.36052999426463667,"IndividualPerformance":[0.21016995445809081,0.10019829609043622]}},{"Budget":20144.020175818277,"CostPerGRP":245.0,"GRP":82.220490513544,"Result":{"GlobalPerformance":0.054003673403869475,"Reach":0.36870344268744981,"IndividualPerformance":[0.21669356856397321,0.10400866276161674]}},{"Budget":20144.020175818277,"CostPerGRP":245.0,"GRP":82.220490513544,"Result":{"GlobalPerformance":0.056594651307956705,"Reach":0.37453861417147877,"IndividualPerformance":[0.22179172649503021,0.10702925522583268]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0409299110443069,"Reach":0.32693486415161088,"IndividualPerformance":[0.18834952513507369,0.087865048177199229]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0293306360897052,"Reach":0.26398754483855197,"IndividualPerformance":[0.158261818100323,0.071783113943871976]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.020900466317246666,"Reach":0.19529326812246184,"IndividualPerformance":[0.13179379814238873,0.058407536608610519]}},{"Budget":0.0,"CostPerGRP":245.0,"GRP":0.0,"Result":{"GlobalPerformance":0.014860382855734097,"Reach":0.13229567751343863,"IndividualPerformance":[0.10893507823814819,0.047367838798851654]}}],"TouchpointName":"TV - Ad","ReachFrequency":4},{"AllocationByPeriod":[{"Budget":5868.08823529413,"CostPerGRP":283.0,"GRP":20.7352941176471,"Result":{"GlobalPerformance":0.0027529363017019157,"Reach":0.014925462733313043,"IndividualPerformance":[0.013206167997840249,0.00874670360446752]}},{"Budget":5868.08823529413,"CostPerGRP":283.0,"GRP":20.7352941176471,"Result":{"GlobalPerformance":0.0046799917128932519,"Reach":0.025373286646632159,"IndividualPerformance":[0.022450485596328423,0.014869396127594785]}},{"Budget":5868.08823529413,"CostPerGRP":283.0,"GRP":20.7352941176471,"Result":{"GlobalPerformance":0.0060289305007271915,"Reach":0.032686763385955574,"IndividualPerformance":[0.028921507915270143,0.019155280893783863]}},{"Budget":5868.08823529413,"CostPerGRP":283.0,"GRP":20.7352941176471,"Result":{"GlobalPerformance":0.0069731876522109481,"Reach":0.037806197103481945,"IndividualPerformance":[0.033451223538529341,0.022155400230116223]}},{"Budget":0.0,"CostPerGRP":283.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0048812313565476636,"Reach":0.02646433797243735,"IndividualPerformance":[0.023415856476970535,0.01550878016108136]}},{"Budget":4215.90160705882,"CostPerGRP":283.0,"GRP":14.8971788235294,"Result":{"GlobalPerformance":0.0053946966570899268,"Reach":0.029248168169799731,"IndividualPerformance":[0.025879011551002074,0.017140175988237086]}},{"Budget":4215.90160705882,"CostPerGRP":283.0,"GRP":14.8971788235294,"Result":{"GlobalPerformance":0.0057541223674695136,"Reach":0.031196849307953411,"IndividualPerformance":[0.027603220102824157,0.01828215306724609]}},{"Budget":4215.90160705882,"CostPerGRP":283.0,"GRP":14.8971788235294,"Result":{"GlobalPerformance":0.0060057203647352212,"Reach":0.032560926104661,"IndividualPerformance":[0.028810166089099594,0.019081537022552386]}},{"Budget":4215.90160705882,"CostPerGRP":283.0,"GRP":14.8971788235294,"Result":{"GlobalPerformance":0.006181838962821218,"Reach":0.033515779862356279,"IndividualPerformance":[0.029655028279492412,0.019641105791266808]}},{"Budget":0.0,"CostPerGRP":283.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0043272872739748506,"Reach":0.023461045903649395,"IndividualPerformance":[0.020758519795644685,0.01374877405388676]}},{"Budget":5244.67660794118,"CostPerGRP":283.0,"GRP":18.5324261764706,"Result":{"GlobalPerformance":0.005489572040028869,"Reach":0.029762549483849231,"IndividualPerformance":[0.026334140224039852,0.017441616618524922]}},{"Budget":5244.67660794118,"CostPerGRP":283.0,"GRP":18.5324261764706,"Result":{"GlobalPerformance":0.0063031713762666843,"Reach":0.03417360198998913,"IndividualPerformance":[0.030237074523916458,0.020026606413771641]}},{"Budget":5244.67660794118,"CostPerGRP":283.0,"GRP":18.5324261764706,"Result":{"GlobalPerformance":0.0068726909116331569,"Reach":0.037261338744287054,"IndividualPerformance":[0.032969128533830112,0.021836099270444314]}},{"Budget":5244.67660794118,"CostPerGRP":283.0,"GRP":18.5324261764706,"Result":{"GlobalPerformance":0.0072713545863896806,"Reach":0.039422754472295596,"IndividualPerformance":[0.034881566340769631,0.023102744270115209]}},{"Budget":5567.55413794118,"CostPerGRP":283.0,"GRP":19.6733361764706,"Result":{"GlobalPerformance":0.0077018928990073921,"Reach":0.041756983395887633,"IndividualPerformance":[0.036946910636030346,0.024470662230478713]}},{"Budget":5567.55413794118,"CostPerGRP":283.0,"GRP":19.6733361764706,"Result":{"GlobalPerformance":0.00800326971783979,"Reach":0.043390943642402091,"IndividualPerformance":[0.038392651642712862,0.025428204802733154]}},{"Budget":5567.55413794118,"CostPerGRP":283.0,"GRP":19.6733361764706,"Result":{"GlobalPerformance":0.00821423349102247,"Reach":0.044534715814962191,"IndividualPerformance":[0.039404670347390612,0.026098484603311271]}},{"Budget":5567.55413794118,"CostPerGRP":283.0,"GRP":19.6733361764706,"Result":{"GlobalPerformance":0.0083619081322503525,"Reach":0.045335356335754265,"IndividualPerformance":[0.040113083440665026,0.026567680463715944]}},{"Budget":3371.029411764719,"CostPerGRP":283.0,"GRP":11.9117647058824,"Result":{"GlobalPerformance":0.007434809738233795,"Reach":0.040308951430761013,"IndividualPerformance":[0.035665680449777977,0.023622078395252721]}},{"Budget":3371.029411764719,"CostPerGRP":283.0,"GRP":11.9117647058824,"Result":{"GlobalPerformance":0.0067858408624222027,"Reach":0.036790467997265749,"IndividualPerformance":[0.0325524983561571,0.02156015694732847]}},{"Budget":3371.029411764719,"CostPerGRP":283.0,"GRP":11.9117647058824,"Result":{"GlobalPerformance":0.00633156264935409,"Reach":0.034327529593819059,"IndividualPerformance":[0.030373270890622465,0.020116811933781495]}},{"Budget":3371.029411764719,"CostPerGRP":283.0,"GRP":11.9117647058824,"Result":{"GlobalPerformance":0.0060135679002064112,"Reach":0.03260347271140638,"IndividualPerformance":[0.028847811664748223,0.019106470424298597]}},{"Budget":0.0,"CostPerGRP":283.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0042094975301444869,"Reach":0.022822430897984466,"IndividualPerformance":[0.02019346816532375,0.013374529297009028]}}],"TouchpointName":"Radio - Ad","ReachFrequency":5},{"AllocationByPeriod":[{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0,"Reach":0.0,"IndividualPerformance":[0.0,0.0]}},{"Budget":4660.0,"CostPerGRP":466.0,"GRP":10.0,"Result":{"GlobalPerformance":0.002412429258890611,"Reach":0.014814642581774349,"IndividualPerformance":[0.010692347615280729,0.0053768371961174025]}},{"Budget":4660.0,"CostPerGRP":466.0,"GRP":10.0,"Result":{"GlobalPerformance":0.00446299412894763,"Reach":0.027407088776282555,"IndividualPerformance":[0.019780843088269346,0.0099471488128171966]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.0057234884167179732,"Reach":0.035147739525259659,"IndividualPerformance":[0.025367594717253528,0.012756546247788537]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.0067949085613227657,"Reach":0.041727292661890195,"IndividualPerformance":[0.030116333601890088,0.015144534067514176]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.0077056156842368389,"Reach":0.047319912828026153,"IndividualPerformance":[0.034152761653831139,0.017174323714280976]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.0084797167387138,"Reach":0.052073639969241713,"IndividualPerformance":[0.037583725497981064,0.018899644914032745]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.009120927082234628,"Reach":0.056114947802184151,"IndividualPerformance":[0.040544293868794531,0.020377351283779731]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.0096712078196466451,"Reach":0.059549525991097189,"IndividualPerformance":[0.043046873225445523,0.021629883548109873]}},{"Budget":3728.0,"CostPerGRP":466.0,"GRP":8.0,"Result":{"GlobalPerformance":0.010152730244194596,"Reach":0.062468978428130761,"IndividualPerformance":[0.045137797110620964,0.02268537692931577]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.008646527638415568,"Reach":0.053098019792491846,"IndividualPerformance":[0.038323063291641049,0.019271434075073968]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0073495484926532307,"Reach":0.045133316823618055,"IndividualPerformance":[0.032574603797894876,0.016380718963812876]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0062471162187552444,"Reach":0.038363319300075346,"IndividualPerformance":[0.027688413228210654,0.013923611119240944]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0053100487859419586,"Reach":0.032608821405064034,"IndividualPerformance":[0.02353515124397906,0.011835069451354803]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0045135414680506653,"Reach":0.027717498194304441,"IndividualPerformance":[0.020004878557382207,0.010059809033651584]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.003836510247843066,"Reach":0.023559873465158778,"IndividualPerformance":[0.017004146773774865,0.0085508376786038471]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0032610337106666063,"Reach":0.020025892445384968,"IndividualPerformance":[0.014453524757708638,0.0072682120268132717]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0027718786540666149,"Reach":0.017022008578577212,"IndividualPerformance":[0.012285496044052342,0.0061779802227912807]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0023560968559566214,"Reach":0.014468707291790632,"IndividualPerformance":[0.010442671637444488,0.005251283189372586]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0020026823275631285,"Reach":0.012298401198022035,"IndividualPerformance":[0.0088762708918278133,0.0044635907109666995]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0017022799784286594,"Reach":0.010453641018318726,"IndividualPerformance":[0.0075448302580536433,0.0037940521043216937]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0014469379816643608,"Reach":0.00888559486557092,"IndividualPerformance":[0.0064131057193455967,0.0032249442886734397]}},{"Budget":0.0,"CostPerGRP":466.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0012298972844147062,"Reach":0.0075527556357352843,"IndividualPerformance":[0.0054511398614437573,0.0027412026453724246]}}],"TouchpointName":"Magazine - Ad","ReachFrequency":3},{"AllocationByPeriod":[{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.011092964917447832,"Reach":0.039661067803088867,"IndividualPerformance":[0.028576273284628317,0.020432800789891872]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.018853085408290553,"Reach":0.07140542307028927,"IndividualPerformance":[0.052005931011874444,0.036765635652860354]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.023835400947431841,"Reach":0.096295166242973754,"IndividualPerformance":[0.071853632906753284,0.050126412204745584]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.027875926679290994,"Reach":0.11409589995441292,"IndividualPerformance":[0.0857567818902859,0.0596566018614592]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.031076428668278318,"Reach":0.12731254850767551,"IndividualPerformance":[0.095743610482119393,0.066590455342508986]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.0335634970236703,"Reach":0.13717488208023984,"IndividualPerformance":[0.1030142244768795,0.071684655646155032]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.035473299455574911,"Reach":0.1445384931936487,"IndividualPerformance":[0.10835248905576449,0.0754496818456597]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.036928899080037943,"Reach":0.15003832545222198,"IndividualPerformance":[0.11229472222904376,0.07824353808937029]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.038032943809309612,"Reach":0.15414823478197662,"IndividualPerformance":[0.1152179559320006,0.080322602247974911]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.038867621204666705,"Reach":0.15722132317538179,"IndividualPerformance":[0.11739200869259152,0.08187290540216588]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.039497242728625107,"Reach":0.15952048971660227,"IndividualPerformance":[0.11901238764106255,0.0830306475014536]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.039971440250071613,"Reach":0.16124152112112636,"IndividualPerformance":[0.12022202675711879,0.083896179683997443]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.040328181630868751,"Reach":0.16253034468941782,"IndividualPerformance":[0.12112610945167865,0.08454378035016831]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.040596343734650757,"Reach":0.16349583652437641,"IndividualPerformance":[0.12180241332995698,0.085028614814604692]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.040797802511976552,"Reach":0.16421930998385731,"IndividualPerformance":[0.12230865719675609,0.085391755577948592]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.040949084713056173,"Reach":0.16476154694624015,"IndividualPerformance":[0.12268778862052625,0.085663839146611034]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041062651526805209,"Reach":0.16516801545925205,"IndividualPerformance":[0.12297182783868985,0.085867749178398609]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.04114788551660091,"Reach":0.16547274826725314,"IndividualPerformance":[0.12318468360169328,0.0860205959891914]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041211844013103738,"Reach":0.16570123079666441,"IndividualPerformance":[0.12334422789597345,0.086135182946435018]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041259831401671533,"Reach":0.16587255480440821,"IndividualPerformance":[0.12346383132045055,0.086221096105864731]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041295832337963939,"Reach":0.16600102643063405,"IndividualPerformance":[0.12355350309253582,0.086285515766109058]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041322838878661353,"Reach":0.16609736809612857,"IndividualPerformance":[0.1236207396098979,0.086333821960707935]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.041343097064689041,"Reach":0.16616961755290888,"IndividualPerformance":[0.12367115726480538,0.086370046798916925]}}],"TouchpointName":"Online - Ad","ReachFrequency":5},{"AllocationByPeriod":[{"Budget":0.0,"CostPerGRP":264.0,"GRP":0.0,"Result":{"GlobalPerformance":0.0,"Reach":0.0,"IndividualPerformance":[0.0,0.0]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.0066781468778280327,"Reach":0.016095367532199735,"IndividualPerformance":[0.012606016526079206,0.00837516461219017]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.01202066438009046,"Reach":0.028971661557959522,"IndividualPerformance":[0.022690829746942573,0.015075296301942301]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.0162946783819004,"Reach":0.039272696778567345,"IndividualPerformance":[0.030758680323633266,0.020435401653744009]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.019713889583348358,"Reach":0.047513524955053614,"IndividualPerformance":[0.037212960784985823,0.02472348593518538]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.022589533131300518,"Reach":0.056018179985684056,"IndividualPerformance":[0.043581883517554695,0.028656562216329333]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.025066459658648923,"Reach":0.0665524155420205,"IndividualPerformance":[0.05098692892718043,0.032728184245369857]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.026964005087899857,"Reach":0.074808499400806278,"IndividualPerformance":[0.056777183693740456,0.035902755501263844]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.028444272308508319,"Reach":0.08128215797751373,"IndividualPerformance":[0.061319650577471282,0.038394744555662295]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.029610544025069796,"Reach":0.086371831016583175,"IndividualPerformance":[0.06489591867225912,0.040360243248857348]}},{"Budget":5280.0,"CostPerGRP":264.0,"GRP":20.0,"Result":{"GlobalPerformance":0.030534628594833729,"Reach":0.090385302727982023,"IndividualPerformance":[0.067720306030708916,0.041915772238359864]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.030585203559197825,"Reach":0.09060430374146701,"IndividualPerformance":[0.067874547696165,0.042000817420682159]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.030625649938306607,"Reach":0.090779391533872114,"IndividualPerformance":[0.067997871190715445,0.042068822717307733]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.030657998425267442,"Reach":0.090919389442305293,"IndividualPerformance":[0.068096485317745939,0.04212320725257173]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.030683871742509986,"Reach":0.091031341484412026,"IndividualPerformance":[0.068175348045695611,0.042166702292641349]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.03070456691547194,"Reach":0.091120873497996371,"IndividualPerformance":[0.068238419948236026,0.042201490279091758]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.03072112083704992,"Reach":0.09119248015313422,"IndividualPerformance":[0.068288865774956034,0.042229315524585032]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.0307343625611491,"Reach":0.09124975334618958,"IndividualPerformance":[0.06832921495327067,0.042251572431854179]}},{"Budget":4752.0,"CostPerGRP":264.0,"GRP":18.0,"Result":{"GlobalPerformance":0.030744955038855222,"Reach":0.0912955641370847,"IndividualPerformance":[0.068361489507758555,0.0422693758540718]}},{"Budget":0.0,"CostPerGRP":264.0,"GRP":0.0,"Result":{"GlobalPerformance":0.024367974519816926,"Reach":0.063544555280919582,"IndividualPerformance":[0.048875852148499543,0.031569655553141548]}},{"Budget":0.0,"CostPerGRP":264.0,"GRP":0.0,"Result":{"GlobalPerformance":0.019206624331303136,"Reach":0.046290937189712764,"IndividualPerformance":[0.036255420576995143,0.024087316940156537]}},{"Budget":0.0,"CostPerGRP":264.0,"GRP":0.0,"Result":{"GlobalPerformance":0.015365299465042507,"Reach":0.037032749751770205,"IndividualPerformance":[0.029004336461596121,0.019269853552125231]}},{"Budget":0.0,"CostPerGRP":264.0,"GRP":0.0,"Result":{"GlobalPerformance":0.01229223957203401,"Reach":0.029626199801416175,"IndividualPerformance":[0.023203469169276895,0.015415882841700188]}}],"TouchpointName":"Online - Video","ReachFrequency":3}],"Total":{"AllocationByPeriod":[{"Budget":50076.062614580966,"CostPerGRP":255.79842952534125,"GRP":195.76376097187909,"Result":{"GlobalPerformance":0.027010217461821171,"Reach":0.47013019476401446,"IndividualPerformance":[0.13430710961890674,0.069952209456535019]}},{"Budget":60016.062614580966,"CostPerGRP":265.8356786590586,"GRP":225.76376097187909,"Result":{"GlobalPerformance":0.07972774914602912,"Reach":0.58040444716439255,"IndividualPerformance":[0.25492715479966332,0.14316336566190901]}},{"Budget":60016.062614580966,"CostPerGRP":265.8356786590586,"GRP":225.76376097187909,"Result":{"GlobalPerformance":0.11856047561148082,"Reach":0.64255152602126753,"IndividualPerformance":[0.32488105906659043,0.19072781653177445]}},{"Budget":59084.062614580973,"CostPerGRP":264.04661039821457,"GRP":223.76376097187909,"Result":{"GlobalPerformance":0.14863534133156461,"Reach":0.67896438194296882,"IndividualPerformance":[0.37019055012374019,0.22410996590012605]}},{"Budget":22829.0,"CostPerGRP":288.97468354430379,"GRP":79.0,"Result":{"GlobalPerformance":0.13568774483443502,"Reach":0.6757919002345234,"IndividualPerformance":[0.35377109639616866,0.21298298551391137]}},{"Budget":47788.343904647132,"CostPerGRP":267.62542409690622,"GRP":178.56429024225719,"Result":{"GlobalPerformance":0.15109366302626848,"Reach":0.69374688439220134,"IndividualPerformance":[0.37707739245792887,0.23008171757675294]}},{"Budget":47788.343904647132,"CostPerGRP":267.62542409690622,"GRP":178.56429024225719,"Result":{"GlobalPerformance":0.1634496734697741,"Reach":0.707855092777416,"IndividualPerformance":[0.39587828230684563,0.24367485662295324]}},{"Budget":47788.343904647132,"CostPerGRP":267.62542409690622,"GRP":178.56429024225719,"Result":{"GlobalPerformance":0.1730738536361798,"Reach":0.71829633050507447,"IndividualPerformance":[0.41015595067147259,0.25410097051908304]}},{"Budget":47788.343904647132,"CostPerGRP":267.62542409690622,"GRP":178.56429024225719,"Result":{"GlobalPerformance":0.1806096713365212,"Reach":0.72608810601240237,"IndividualPerformance":[0.42086337564951282,0.26208877718297713]}},{"Budget":22829.0,"CostPerGRP":288.97468354430379,"GRP":79.0,"Result":{"GlobalPerformance":0.16190289962014545,"Reach":0.71522815122443162,"IndividualPerformance":[0.39799206946560595,0.24459691010037768]}},{"Budget":45048.9095947286,"CostPerGRP":258.84909016203738,"GRP":174.0354179592764,"Result":{"GlobalPerformance":0.17011503560272098,"Reach":0.72020373789263137,"IndividualPerformance":[0.40803864404049256,0.25277238675538904]}},{"Budget":44520.9095947286,"CostPerGRP":258.7892081923934,"GRP":172.0354179592764,"Result":{"GlobalPerformance":0.1753972467541712,"Reach":0.722738659635733,"IndividualPerformance":[0.41401245166476075,0.2578954961380755]}},{"Budget":44520.9095947286,"CostPerGRP":258.7892081923934,"GRP":172.0354179592764,"Result":{"GlobalPerformance":0.17933176230372963,"Reach":0.72431926478972808,"IndividualPerformance":[0.41835822070387135,0.26165210862843358]}},{"Budget":44520.9095947286,"CostPerGRP":258.7892081923934,"GRP":172.0354179592764,"Result":{"GlobalPerformance":0.18225601755129381,"Reach":0.72526055672097178,"IndividualPerformance":[0.42132093483058713,0.26434682977447238]}},{"Budget":24140.554137941181,"CostPerGRP":272.24141076522233,"GRP":88.6733361764706,"Result":{"GlobalPerformance":0.16358891686350968,"Reach":0.71419874393837879,"IndividualPerformance":[0.39673492697452151,0.24717789838531684]}},{"Budget":44284.574313759455,"CostPerGRP":259.13501483050953,"GRP":170.89382669001458,"Result":{"GlobalPerformance":0.16915229352844158,"Reach":0.71741104253161769,"IndividualPerformance":[0.403788332756311,0.25240932036405617]}},{"Budget":44284.574313759455,"CostPerGRP":259.13501483050953,"GRP":170.89382669001458,"Result":{"GlobalPerformance":0.17345045612506022,"Reach":0.7196489577121068,"IndividualPerformance":[0.40901335825561613,0.25637826121436652]}},{"Budget":44284.574313759455,"CostPerGRP":259.13501483050953,"GRP":170.89382669001458,"Result":{"GlobalPerformance":0.17678639666801763,"Reach":0.72122186194335169,"IndividualPerformance":[0.41312548359377976,0.25946637764585057]}},{"Budget":42088.049587582995,"CostPerGRP":257.99955705247305,"GRP":163.13225521942638,"Result":{"GlobalPerformance":0.17760328421546065,"Reach":0.71879606530305384,"IndividualPerformance":[0.41385326614134132,0.25962281992247677]}},{"Budget":17192.029411764721,"CostPerGRP":273.2720897615709,"GRP":62.9117647058824,"Result":{"GlobalPerformance":0.14965928881799503,"Reach":0.69688509108146568,"IndividualPerformance":[0.37405661088151165,0.23208395128532011]}},{"Budget":17192.029411764721,"CostPerGRP":273.2720897615709,"GRP":62.9117647058824,"Result":{"GlobalPerformance":0.12705276423970577,"Reach":0.67852955534477832,"IndividualPerformance":[0.33974946161804365,0.20938930152224]}},{"Budget":17192.029411764721,"CostPerGRP":273.2720897615709,"GRP":62.9117647058824,"Result":{"GlobalPerformance":0.1003226403901213,"Reach":0.66187541854765042,"IndividualPerformance":[0.29887040090895128,0.18303547846679782]}},{"Budget":13821.0,"CostPerGRP":271.0,"GRP":51.0,"Result":{"GlobalPerformance":0.085286222694619176,"Reach":0.6390771761263172,"IndividualPerformance":[0.270245294027492,0.1651568230977743]}}],"TouchpointName":"Total","ReachFrequency":1}},"WhatIfResult":{"Config":{"FirstPeriod":0,"LastPeriod":22,"SourceBudget":909094.6793579231,"BudgetMinPercent":50,"BudgetMaxPercent":200,"BudgetStepPercent":25,"HasCurrentMix":true,"HasSingleTouchpointMix":true,"HasOptimizedMix":true,"OptimizedFunction":{"CalculationType":1,"AttributeIndex":-1}},"Points":[{"StepPosition":0,"ActualPercent":50,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":183955.339678962,"FunctionValue":0.340551123513339},{"TouchpointName":"Radio - Ad","Budget":48534.5,"FunctionValue":0.0476046103363636},{"TouchpointName":"Magazine - Ad","Budget":17708.0,"FunctionValue":0.0084635172175118},{"TouchpointName":"Online - Ad","Budget":158941.5,"FunctionValue":0.179197840332398},{"TouchpointName":"Online - Video","Budget":45408.0,"FunctionValue":0.0182541517066301}],"Total":{"TouchpointName":"Total","Budget":454547.339678962,"FunctionValue":0.463044290799186}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":213000.0,"FunctionValue":0.274587728969757},{"TouchpointName":"Online - Ad","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"Magazine - Ad","Budget":79000.0,"FunctionValue":0.157591948132652},{"TouchpointName":"Radio - Ad","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"TV - Ad","Budget":162000.0,"FunctionValue":0.43649905635153}],"Total":{"TouchpointName":"Total","Budget":454000.0,"FunctionValue":0.609096899353844}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":454547.339678962,"FunctionValue":0.464811199763807}],"Total":{"TouchpointName":"Total","Budget":454547.339678962,"FunctionValue":0.464811199763807}}},{"StepPosition":6,"ActualPercent":200,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":735821.358715847,"FunctionValue":0.509090665829604},{"TouchpointName":"Radio - Ad","Budget":194138.0,"FunctionValue":0.190418441345455},{"TouchpointName":"Magazine - Ad","Budget":70832.0,"FunctionValue":0.0338540688700472},{"TouchpointName":"Online - Ad","Budget":635766.0,"FunctionValue":0.54073969033208},{"TouchpointName":"Online - Video","Budget":181632.0,"FunctionValue":0.0846418759085803}],"Total":{"TouchpointName":"Total","Budget":1818189.3587158471,"FunctionValue":0.767126674172735}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":278000.0,"FunctionValue":0.335757038620294},{"TouchpointName":"Online - Ad","Budget":464000.0,"FunctionValue":0.471846899133},{"TouchpointName":"Magazine - Ad","Budget":100000.0,"FunctionValue":0.187761757828452},{"TouchpointName":"Radio - Ad","Budget":767000.0,"FunctionValue":0.644222763186102},{"TouchpointName":"TV - Ad","Budget":209000.0,"FunctionValue":0.464845179453727}],"Total":{"TouchpointName":"Total","Budget":1818000.0,"FunctionValue":0.885821734070459}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":1818189.35871585,"FunctionValue":0.605000884764044}],"Total":{"TouchpointName":"Total","Budget":1818189.35871585,"FunctionValue":0.605000884764044}}},{"StepPosition":3,"ActualPercent":125,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":459888.349197404,"FunctionValue":0.465996569370741},{"TouchpointName":"Radio - Ad","Budget":121336.25,"FunctionValue":0.119011525840909},{"TouchpointName":"Magazine - Ad","Budget":44270.0,"FunctionValue":0.0211587930437795},{"TouchpointName":"Online - Ad","Budget":397353.75,"FunctionValue":0.433567931673692},{"TouchpointName":"Online - Video","Budget":113520.0,"FunctionValue":0.0456353792665752}],"Total":{"TouchpointName":"Total","Budget":1136368.349197404,"FunctionValue":0.683501821464321}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"Online - Ad","Budget":410000.0,"FunctionValue":0.44151725424358},{"TouchpointName":"Magazine - Ad","Budget":86000.0,"FunctionValue":0.168662964332483},{"TouchpointName":"Radio - Ad","Budget":461000.0,"FunctionValue":0.544058847923839},{"TouchpointName":"TV - Ad","Budget":179000.0,"FunctionValue":0.448213838519259}],"Total":{"TouchpointName":"Total","Budget":1136000.0,"FunctionValue":0.80196698564857}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":1136368.3491974,"FunctionValue":0.550042774287058}],"Total":{"TouchpointName":"Total","Budget":1136368.3491974,"FunctionValue":0.550042774287058}}},{"StepPosition":2,"ActualPercent":100,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":367910.679357923,"FunctionValue":0.441643026897866},{"TouchpointName":"Radio - Ad","Budget":97069.0000000001,"FunctionValue":0.0952092206727273},{"TouchpointName":"Magazine - Ad","Budget":35416.0,"FunctionValue":0.0169270344350236},{"TouchpointName":"Online - Ad","Budget":317883.0,"FunctionValue":0.374199401971377},{"TouchpointName":"Online - Video","Budget":90816.0,"FunctionValue":0.0365083034132601}],"Total":{"TouchpointName":"Total","Budget":909094.6793579231,"FunctionValue":0.639077176126317}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"Online - Ad","Budget":345000.0,"FunctionValue":0.396494380148938},{"TouchpointName":"Magazine - Ad","Budget":82000.0,"FunctionValue":0.162475237598569},{"TouchpointName":"Radio - Ad","Budget":327000.0,"FunctionValue":0.457365757550639},{"TouchpointName":"TV - Ad","Budget":155000.0,"FunctionValue":0.43104187250626}],"Total":{"TouchpointName":"Total","Budget":909000.0,"FunctionValue":0.750619336943936}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":909094.679357923,"FunctionValue":0.5281703663492}],"Total":{"TouchpointName":"Total","Budget":909094.679357923,"FunctionValue":0.5281703663492}}},{"StepPosition":5,"ActualPercent":175,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":643843.688876366,"FunctionValue":0.497344402284711},{"TouchpointName":"Radio - Ad","Budget":169870.75,"FunctionValue":0.166616136177273},{"TouchpointName":"Magazine - Ad","Budget":61978.0,"FunctionValue":0.0296223102612913},{"TouchpointName":"Online - Ad","Budget":556295.25,"FunctionValue":0.513035610355016},{"TouchpointName":"Online - Video","Budget":158928.0,"FunctionValue":0.0638895309732052}],"Total":{"TouchpointName":"Total","Budget":1590915.688876366,"FunctionValue":0.743540625980294}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":304000.0,"FunctionValue":0.355225742875166},{"TouchpointName":"Online - Ad","Budget":380000.0,"FunctionValue":0.422060390617266},{"TouchpointName":"Magazine - Ad","Budget":83000.0,"FunctionValue":0.164055954308096},{"TouchpointName":"Radio - Ad","Budget":639000.0,"FunctionValue":0.612193154641471},{"TouchpointName":"TV - Ad","Budget":184000.0,"FunctionValue":0.451303428584876}],"Total":{"TouchpointName":"Total","Budget":1590000.0,"FunctionValue":0.865849424886512}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":1590915.68887637,"FunctionValue":0.588078696846364}],"Total":{"TouchpointName":"Total","Budget":1590915.68887637,"FunctionValue":0.588078696846364}}},{"StepPosition":1,"ActualPercent":75,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":275933.009518443,"FunctionValue":0.404125898510789},{"TouchpointName":"Radio - Ad","Budget":72801.7500000001,"FunctionValue":0.0714069155045455},{"TouchpointName":"Magazine - Ad","Budget":26562.0,"FunctionValue":0.0126952758262677},{"TouchpointName":"Online - Ad","Budget":238412.25,"FunctionValue":0.292760839044068},{"TouchpointName":"Online - Video","Budget":68112.0,"FunctionValue":0.0273812275599451}],"Total":{"TouchpointName":"Total","Budget":681821.00951844314,"FunctionValue":0.572925102724559}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"Online - Ad","Budget":394000.0,"FunctionValue":0.431399493048454},{"TouchpointName":"Magazine - Ad","Budget":105000.0,"FunctionValue":0.193746895904029},{"TouchpointName":"Radio - Ad","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"TV - Ad","Budget":182000.0,"FunctionValue":0.450085034739887}],"Total":{"TouchpointName":"Total","Budget":681000.0,"FunctionValue":0.690968858091059}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":681821.009518442,"FunctionValue":0.502387717614668}],"Total":{"TouchpointName":"Total","Budget":681821.009518442,"FunctionValue":0.502387717614668}}},{"StepPosition":4,"ActualPercent":150,"CurrentMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":551866.019036885,"FunctionValue":0.483513036372257},{"TouchpointName":"Radio - Ad","Budget":145603.5,"FunctionValue":0.142813831009091},{"TouchpointName":"Magazine - Ad","Budget":53124.0,"FunctionValue":0.0253905516525354},{"TouchpointName":"Online - Ad","Budget":476824.5,"FunctionValue":0.478292086103288},{"TouchpointName":"Online - Video","Budget":136224.0,"FunctionValue":0.0547624551198902}],"Total":{"TouchpointName":"Total","Budget":1363642.0190368849,"FunctionValue":0.717298330770527}},"OptimizedMix":{"Details":[{"TouchpointName":"Online - Video","Budget":0.0,"FunctionValue":"NaN"},{"TouchpointName":"Online - Ad","Budget":494000.0,"FunctionValue":0.486524921487736},{"TouchpointName":"Magazine - Ad","Budget":112000.0,"FunctionValue":0.201497316497548},{"TouchpointName":"Radio - Ad","Budget":568000.0,"FunctionValue":0.589249740325212},{"TouchpointName":"TV - Ad","Budget":189000.0,"FunctionValue":0.454252797059939}],"Total":{"TouchpointName":"Total","Budget":1363000.0,"FunctionValue":0.836179561856856}},"SingleTouchpointMix":{"Details":[{"TouchpointName":"TV - Ad","Budget":1363642.01903688,"FunctionValue":0.569832416450655}],"Total":{"TouchpointName":"Total","Budget":1363642.01903688,"FunctionValue":0.569832416450655}}}]}}';
    }
    //MATRIX FILE FROM 26 JAN , 19:26.
     public function parseTheLightdataString($datastring,$campaign_id, ObjectManager $em) {
        $array_of_missing_nodes = array();
        $missing_setup_nodes = array();
        $missing_groupings_node = array();
        $touchpoints_missing_nodes = array();
        $budgetallocation_missing_nodes = array();
        $timeallocation_missing_nodes = array();
        $the_start_date = null;
        $error_on_parsing = false;

        $contentOfJsonFile = $datastring;

        $lightdata_uuid = Uuid::uuid4()->toString();
        $lightdata = new Lightdata();
        $lightdata->setInputstring($contentOfJsonFile);

        $arrayOfJsonObjects = json_decode($contentOfJsonFile, true);


        $project_data = $arrayOfJsonObjects;
        if (isset($arrayOfJsonObjects['Project'])) {
            $project_data = $arrayOfJsonObjects['Project'];
        }

        //INSTANTIATE THE LIGHTDATA OBJECT
        ////////////////////////////////////////////////////////////////
        //Assign Project SETUP Data
        ////////////////////////////////////////////////////////////////
        //Grab setup array from the whole array.


        if (isset($project_data['Setup'])) {
            $setup_data = $project_data['Setup'];

            $client = new ClientLD();
            $target = new TargetLD();
            $survey = new SurveyLD();
            $setup = new SetupLD();



            if (isset($setup_data['Client'])) {
                $client->setName($setup_data['Client']['Name']);
                $client->setDbid($setup_data['Client']['DbID']);
                $setup->setClient($client);
            } else {
                $missing_setup_nodes[] = 'Client';
            }
            if (isset($setup_data['Target'])) {
                $target->setName($setup_data['Target']['Name']);
                $target->setDbid($setup_data['Target']['DbID']);
                $setup->setTarget($target);
            } else {
                $missing_setup_nodes[] = 'Target';
            }
            if (isset($setup_data['Survey'])) {
                $survey->setName($setup_data['Survey']['Name']);
                $survey->setDbid($setup_data['Survey']['DbID']);
                $setup->setSurvey($survey);
            } else {
                $missing_setup_nodes[] = 'Survey';
            }
            if (isset($setup_data['ProjectName'])) {
                $setup->setProjectName($setup_data['ProjectName']);
            } else {
                $missing_setup_nodes[] = 'ProjectName';
            }
            if (isset($setup_data['StartDate'])) {
                $setup->setStartDate(new \DateTime($setup_data['StartDate']));
                $the_start_date = new \DateTime($setup_data['StartDate']);
            } else {
                $missing_setup_nodes[] = 'StartDate';
                $the_start_date = null;
            }
            if (isset($setup_data['PeriodType'])) {
                $setup->setPeriodType($setup_data['PeriodType']);
            } else {
                $missing_setup_nodes[] = 'PeriodType';
            }
            if (isset($setup_data['NbPeriods'])) {
                $setup->setNbPeriods($setup_data['NbPeriods']);
            } else {
                $missing_setup_nodes[] = 'NbPeriods';
            }
            if (isset($setup_data['Budget'])) {
                $setup->setBudget($setup_data['Budget']);
            } else {
                $missing_setup_nodes[] = 'Budget';
            }
            if (isset($setup_data['BudgetCurrency'])) {
                $setup->setBudgetCurrency($setup_data['BudgetCurrency']);
            } else {
                $missing_setup_nodes[] = 'BudgetCurrency';
            }
            $setup->setLightdata($lightdata);
            $lightdata->setSetup($setup);
        } else {
            $error_on_parsing = true;
            $array_of_missing_nodes[] = "Setup";
        }
        if (isset($project_data['CurrentGroupingIndex'])) {
            $lightdata->setCurrentgroupingindex($project_data['CurrentGroupingIndex']);
        } else {
            $array_of_missing_nodes[] = 'CurrentGroupingIndex';
        }
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////
        //Assign OBJECTIVES Data
        ////////////////////////////////////////////////////////////////
        //ONLY ADD IF EXISTS
        if (isset($project_data['Objectives'])) {
            $objectives_data = $project_data['Objectives'];

            foreach ($objectives_data as $objective_data) {
                $objective = new ObjectiveLD();
                $objective->setName($objective_data['Name']);
                $objective->setHtmlcolor($objective_data['HtmlColor']);
                $objective->setSelected($objective_data['Selected']);
                $objective->setScore($objective_data['Score']);
                $objective->setLightdata($lightdata);
                $lightdata->addObjective($objective);
            }
        } else {
            $array_of_missing_nodes[] = 'Objectives';
        }
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////
        //Assign GROUPINGS Data
        ////////////////////////////////////////////////////////////////


        if (isset($project_data['Groupings'])) {
            $groupings_data = $project_data['Groupings'];


            foreach ($groupings_data as $grouping_data) {
                if (isset($grouping_data['Name'])) {
                    $grouping = new GroupingLD();

                    $grouping->setName($grouping_data['Name']);

                    $grouping->setLightdata($lightdata);

                    if (isset($grouping_data['Categories'])) {
                        foreach ($grouping_data['Categories'] as $groupings_cateogry) {
                            $groupingcategory = new GroupingCategoryLD();
                            $groupingcategory->setGrouping($grouping);
                            $groupingcategory->setName($groupings_cateogry['Name']);
                            $groupingcategory->setHtmlcolor($groupings_cateogry['HtmlColor']);
                            $grouping->addGroupingcategory($groupingcategory);
                        }
                    } else {
                        $missing_groupings_node[] = "Categories";
                    }

                    if (isset($grouping_data['TouchpointCategoryMap'])) {
                        foreach ($grouping_data['TouchpointCategoryMap'] as $key => $value) {
                            $groupingstouchpointcategorymap = new GroupingTouchpointCategoryMapLD();
                            $groupingstouchpointcategorymap->setGrouping($grouping);
                            $groupingstouchpointcategorymap->setName($key);
                            $groupingstouchpointcategorymap->setValue($value);
                            $grouping->addGroupingtouchpointcategorymap($groupingstouchpointcategorymap);
                        }
                    } else {
                        $missing_groupings_node[] = "TouchpointCategoryMap";
                    }
                    $lightdata->addGrouping($grouping);
                } else {
                    $missing_groupings_node[] = "Groupings Node Availlable, Data Inside Missing.";
                }
            }
        } else {
            $array_of_missing_nodes[] = "Groupings";
        }
        //END FOREACH GROUPING
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////    
        //ASSIGN THE CURRENT GROUPING INDEX , TO THE LIGHTDATA ENTITI DIRECTLY
        //ASSIGN THE CURRENT GROUPING INDEX , TO THE LIGHTDATA ENTITI DIRECTLY    
        ////////////////////////////////////////////////////////////////    
        ////////////////////////////////////////////////////////////////
        //ASSIGN TOUCHPOINTS , OBJECTIVESCORES AND ATTRIBUTESCORES FOR EACH TOUCHPOINT
        //ASSIGN TOUCHPOINTS , OBJECTIVESCORES AND ATTRIBUTESCORES FOR EACH TOUCHPOINT    

        if (isset($project_data['Touchpoints'])) {
            $touchpoints_data = $project_data['Touchpoints'];

            foreach ($touchpoints_data as $touchpoint_data) {
                $touchpoint = new TouchpointLD();
                $touchpoint->setName($touchpoint_data['Name']);
                $touchpoint->setLocalname($touchpoint_data['LocalName']);
                $touchpoint->setHtmlcolor($touchpoint_data['HtmlColor']);
                $touchpoint->setSelected($touchpoint_data['Selected']);
                $touchpoint->setAggobjectivescore($touchpoint_data['AggObjectiveScore']);
                $touchpoint->setLightdata($lightdata);

                //EVEN IF TOUCHPOINTS NODE IS AVAILLABLE , WE SHOULD CHECK IF THERE ARE ANY TOUCHPOINTS SET.
                //EVEN IF TOUCHPOINTS NODE IS AVAILLABLE , WE SHOULD CHECK IF THERE ARE ANY TOUCHPOINTS SET.
                //EVEN IF TOUCHPOINTS NODE IS AVAILLABLE , WE SHOULD CHECK IF THERE ARE ANY TOUCHPOINTS SET.
                //EVEN IF TOUCHPOINTS NODE IS AVAILLABLE , WE SHOULD CHECK IF THERE ARE ANY TOUCHPOINTS SET.


                if (isset($touchpoint_data['ObjectiveScores'])) {
                    foreach ($touchpoint_data['ObjectiveScores'] as $touchpoint_objectivescore) {
                        $touchpointObjectiveScore = new TouchpointObjectiveScoreLD();
                        $touchpointObjectiveScore->setValue($touchpoint_objectivescore);
                        $touchpointObjectiveScore->setTouchpoint($touchpoint);
                        $touchpoint->addTouchpointobjectivescore($touchpointObjectiveScore);
                    }
                } else {
                    $touchpoints_missing_nodes[] = "ObjectiveScores";
                }

                if (isset($touchpoint_data['AttributeScores'])) {
                    foreach ($touchpoint_data['AttributeScores'] as $touchpoint_attributescore) {
                        $touchpointAttributeScore = new TouchpointAttributeScoreLD();
                        $touchpointAttributeScore->setValue($touchpoint_attributescore);
                        $touchpointAttributeScore->setTouchpoint($touchpoint);
                        $touchpoint->addTouchpointattributescore($touchpointAttributeScore);
                    }
                } else {
                    $touchpoints_missing_nodes[] = "AttributeScores";
                }
                $lightdata->addTouchpoint($touchpoint);
            }
        } else {
            $array_of_missing_nodes[] = "Touchpoints";
        }

        ////////////////////////////////////////////////////////////////    
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////
        //ASSIGN CPRATTRIBUTES 
        ////////////////////////////////////////////////////

        if (isset($project_data['CPRAttributes'])) {

            $cprattributes_data = $project_data['CPRAttributes'];
            foreach ($cprattributes_data as $cprattribute_data) {
                $cprattribute = new CPRAttributeLD();
                $cprattribute->setName($cprattribute_data['Name']);
                $cprattribute->setDescription($cprattribute_data['Description']);
                $cprattribute->setSelected($cprattribute_data['Selected']);
                $cprattribute->setLightdata($lightdata);
                $lightdata->addCprattribute($cprattribute);
            }
        } else {
            $array_of_missing_nodes[] = "CPRAttributes";
        }
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        ////ASSIGN BUDGETALLOCATION
        ///////////////////////////////////////////////////////////////
        if (isset($project_data['BudgetAllocation'])) {
            $budgetallocation_data = $project_data['BudgetAllocation'];

            $budgetallocation = new BudgetAllocationLD();
            $lightdata->setBudgetallocation($budgetallocation);
            $budgetallocation->setLightdata($lightdata);

            ///ADD THE BUDGETALLOCATION ALLOCATEDTOUCHPOINTS
            if (isset($budgetallocation_data['AllocatedTouchpoints'])) {
                $ba_allocatedtouchpoints = $budgetallocation_data['AllocatedTouchpoints'];
                foreach ($ba_allocatedtouchpoints as $budgetallocation_allocatedtouchpoint) {
                    $AllocatedTouchpoint = new BAAllocatedTouchpointLD();
                    $AllocatedTouchpoint->setTouchpointname($budgetallocation_allocatedtouchpoint['TouchpointName']);
                    $AllocatedTouchpoint->setBudgetallocation($budgetallocation);
                    $budgetallocation->addAllocatedtouchpoint($AllocatedTouchpoint);

                    $allocation_data = $budgetallocation_allocatedtouchpoint['Allocation'];
                    $allocation = new BAATAllocationLD();
                    $allocation->setAllocatedtouchpoint($AllocatedTouchpoint);
                    $allocation->setBudget($allocation_data['Budget']);
                    $allocation->setCostpergrp($allocation_data['CostPerGRP']);
                    $allocation->setGrp($allocation_data['GRP']);
                    $AllocatedTouchpoint->setAllocation($allocation);

                    $result_data = $allocation_data['Result'];
                    $Result = new BAATAResultLD();
                    $Result->setAllocation($allocation);
                    $Result->setGlobalperformance($result_data['GlobalPerformance']);
                    $Result->setReach($result_data['Reach']);
                    $allocation->setResult($Result);


                    if (isset($result_data['IndividualPerformance'])) {
                        $individual_performances_data = $result_data['IndividualPerformance'];

                        foreach ($individual_performances_data as $individual_performance_data) {

                            $IndividualPerformance = new BAATARIndividualPerformanceLD();
                            $IndividualPerformance->setResult($Result);
                            $IndividualPerformance->setValue($individual_performance_data);
                            $Result->addIndividualperformance($IndividualPerformance);
                        }
                    } else {
                        //RETURN THAT NODE RESULT INDIVIDUALPERFORMANCE IS MISSING
                    }
                }
            } else {
                //RETURN THAT NODE RESULT ALLOCATEDTOUCHPOINTS IS MISSING
            }

            ///ADD THE BUDGETALLOCATION TOTAL
            if (isset($budgetallocation_data['Total'])) {
                $ba_total = $budgetallocation_data['Total'];
                $budgetallocation_total = new BATotalLD();
                $budgetallocation_total->setTouchpointname($ba_total['TouchpointName']);
                $budgetallocation_total->setBudgetallocation($budgetallocation);
                $budgetallocation->addTotal($budgetallocation_total);

                $total_data = $ba_total['Allocation'];
                $allocation = new BATOAllocationLD();
                $allocation->setAllocatedtouchpoint($budgetallocation_total);
                $allocation->setBudget($total_data['Budget']);
                $allocation->setCostpergrp($total_data['CostPerGRP']);
                $allocation->setGrp($total_data['GRP']);
                $budgetallocation_total->setAllocation($allocation);

                $result_data = $total_data['Result'];
                $Result = new BATOAResultLD();
                $Result->setAllocation($allocation);
                $Result->setGlobalperformance($result_data['GlobalPerformance']);
                $Result->setReach($result_data['Reach']);
                $allocation->setResult($Result);

                if (isset($result_data['IndividualPerformance'])) {
                    $individual_performances_data = $result_data['IndividualPerformance'];
                    foreach ($individual_performances_data as $individual_performance_data) {

                        $IndividualPerformance = new BATOARIndividualPerformanceLD();
                        $IndividualPerformance->setResult($Result);
                        $IndividualPerformance->setValue($individual_performance_data);
                        $Result->addIndividualperformance($IndividualPerformance);
                    }
                } else {
                    //RETURN THAT NODE RESULTDATA INDIVIDUALPERFORMANCE IS MISSING
                }
            } else {
                //RETURN THAT NODE BUDGETALLOCATION_TOTAL IS MISSING
            }
        } else {
            //RETURN THAT WHOLE BUDGETALLOCATION NODE IS MISSING
            $array_of_missing_nodes[] = "BudgetAllocation";
        }
        /////////////////////////////////////////
        // END OF ASSIGNS FOR BUDGETALLOCATION
        /////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        ////ASSIGN TIME ALLOCATION
        ///////////////////////////////////////////////////////////////
        if (isset($project_data['TimeAllocation'])) {
            $timeallocation_data = $project_data['TimeAllocation'];

            $timeallocation = new TimeAllocationLD();

            $lightdata->setTimeallocation($timeallocation);
            $timeallocation->setLightdata($lightdata);


            ///ADD THE TIMEALLOCATION ALLOCATEDTOUCHPOINTS
//$timeallocation_missing_nodes
            if (isset($timeallocation_data['AllocatedTouchpoints'])) {
                $timeallocation_allocatedtouchpoints_data = $timeallocation_data['AllocatedTouchpoints'];
                foreach ($timeallocation_allocatedtouchpoints_data as $ta_allocatedtouchpoint) {
                    $TAAllocatedTouchpoint = new TAAllocatedTouchpointLD();
                    $TAAllocatedTouchpoint->setTouchpointname($ta_allocatedtouchpoint['TouchpointName']);
                    $TAAllocatedTouchpoint->setReachfrequency($ta_allocatedtouchpoint['ReachFrequency']);
                    $TAAllocatedTouchpoint->setTimeallocation($timeallocation);
                    $timeallocation->addAllocatedtouchpoint($TAAllocatedTouchpoint);

                    $allocations_by_period_data = $ta_allocatedtouchpoint['AllocationByPeriod'];
                    foreach ($allocations_by_period_data as $allocation_by_period) {
                        $AllocationByPeriod = new TAATAllocationByPeriod();
                        $AllocationByPeriod->setAllocatedtouchpoint($TAAllocatedTouchpoint);
                        $AllocationByPeriod->setBudget($allocation_by_period['Budget']);
                        $AllocationByPeriod->setCostpergrp($allocation_by_period['CostPerGRP']);
                        $AllocationByPeriod->setGrp($allocation_by_period['GRP']);
                        $TAAllocatedTouchpoint->addAllocationbyperiod($AllocationByPeriod);

                        $ABPresult_data = $allocation_by_period['Result'];
                        $ABPResult = new TAATABPResult();
                        $ABPResult->setAllocationbyperiod($AllocationByPeriod);
                        $ABPResult->setGlobalperformance($ABPresult_data['GlobalPerformance']);
                        $ABPResult->setReach($ABPresult_data['Reach']);
                        $AllocationByPeriod->setResult($ABPResult);

                        $ABPindividual_performances_data = $ABPresult_data['IndividualPerformance'];
                        foreach ($ABPindividual_performances_data as $individual_performance_data) {

                            $ABPIndividualPerformance = new TAATABPRIndividualPerformance();
                            $ABPIndividualPerformance->setResult($ABPResult);
                            $ABPIndividualPerformance->setValue($individual_performance_data);
                            $ABPResult->addIndividualperformance($ABPIndividualPerformance);
                        }
                    }
                }
            } else {
                $timeallocation_missing_nodes[] = "AllocatedTouchpoints";
            }


            ///ADD THE TIMEALLOCATION TOTAL
            //ONLYADD TOTAL IF IS SET
            if (isset($timeallocation_data['Total'])) {
                $timeallocation_total_data = $timeallocation_data['Total'];
                $TATotal = new TATotalLD();
                $TATotal->setTimeallocation($timeallocation);
                $TATotal->setTouchpointname($timeallocation_total_data['TouchpointName']);
                $TATotal->setReachfrequency($timeallocation_total_data['ReachFrequency']);
                $timeallocation->addTotal($TATotal);


                if (isset($timeallocation_total_data['AllocationByPeriod'])) {
                    $allocations_by_period_data_total = $timeallocation_total_data['AllocationByPeriod'];
                    foreach ($allocations_by_period_data_total as $allocation_by_period) {
                        $TotalAllocationByPeriod = new TATOAllocationByPeriod();
                        $TotalAllocationByPeriod->setAllocatedtouchpoint($TATotal);
                        $TotalAllocationByPeriod->setBudget($allocation_by_period['Budget']);
                        $TotalAllocationByPeriod->setCostpergrp($allocation_by_period['CostPerGRP']);
                        $TotalAllocationByPeriod->setGrp($allocation_by_period['GRP']);
                        $TATotal->addAllocationbyperiod($TotalAllocationByPeriod);


                        $TotalABPresult_data = $allocation_by_period['Result'];
                        $TotalABPResult = new TATOABPResult();
                        $TotalABPResult->setAllocationbyperiod($TotalAllocationByPeriod);
                        $TotalABPResult->setGlobalperformance($TotalABPresult_data['GlobalPerformance']);
                        $TotalABPResult->setReach($TotalABPresult_data['Reach']);
                        $TotalAllocationByPeriod->setResult($TotalABPResult);

                        $TotalABPindividual_performances_data = $TotalABPresult_data['IndividualPerformance'];
                        foreach ($TotalABPindividual_performances_data as $individual_performance_data) {

                            $TOABPIndividualPerformance = new TATOABPRIndividualPerformance();
                            $TOABPIndividualPerformance->setResult($TotalABPResult);
                            $TOABPIndividualPerformance->setValue($individual_performance_data);
                            $TotalABPResult->addIndividualperformance($TOABPIndividualPerformance);
                        }
                    }
                }
            } else {
                $timeallocation_missing_nodes[] = "Total";
            }
        } else {
            $array_of_missing_nodes[] = "TimeAllocation";
        }
        ////END ASSIGN TIME ALLOCATION   
        ////ASSIGN THE WHATIFRESULT DATA////ASSIGN THE WHATIFRESULT DATA
        ////ASSIGN THE WHATIFRESULT DATA////ASSIGN THE WHATIFRESULT DATA
        ////ASSIGN THE WHATIFRESULT DATA////ASSIGN THE WHATIFRESULT DATA
        ////ASSIGN THE WHATIFRESULT DATA////ASSIGN THE WHATIFRESULT DATA
        //ONLY IF THE WHATIFRESULT IS AVAILLABLE INTO THE JSON UPDATED
        if (isset($project_data['WhatIfResult'])) {



            $whatifresult_data = $project_data['WhatIfResult'];




            $WhatIfResult = new WhatIfResult();
            ////////////////////////////////////////////
            $WhatIfResult->setLightdata($lightdata);
            $lightdata->setWhatifresult($WhatIfResult);
            ////////////////////////////////////////////
            $wirconfig_data = $whatifresult_data['Config'];
            $WIRConfig = new WIRConfig();
            ////////////////////////////////////////////
            $WIRConfig->setWhatifresult($WhatIfResult);
            $WhatIfResult->setConfig($WIRConfig);
            ////////////////////////////////////////////
            $WIRConfig->setFirstperiod($wirconfig_data['FirstPeriod']);
            $WIRConfig->setLastperiod($wirconfig_data['LastPeriod']);
            $WIRConfig->setSourcebudget($wirconfig_data['SourceBudget']);
            $WIRConfig->setBudgetminpercent($wirconfig_data['BudgetMinPercent']);
            $WIRConfig->setBudgetmaxpercent($wirconfig_data['BudgetMaxPercent']);
            $WIRConfig->setBudgetsteppercent($wirconfig_data['BudgetStepPercent']);
            $WIRConfig->setHascurrentmix($wirconfig_data['HasCurrentMix']);
            $WIRConfig->setHassingletouchpointmix($wirconfig_data['HasSingleTouchpointMix']);
            $WIRConfig->setHasoptimizedmix($wirconfig_data['HasOptimizedMix']);
            $wircoptimizedfunction_data = $wirconfig_data['OptimizedFunction'];
            $WIRCOptimizedFunction = new WIRCOptimizedFunction();
            ////////////////////////////////////////////
            $WIRCOptimizedFunction->setConfig($WIRConfig);
            $WIRConfig->setOptimizedfunction($WIRCOptimizedFunction);
            ////////////////////////////////////////////
            $WIRCOptimizedFunction->setCalculationtype($wircoptimizedfunction_data['CalculationType']);
            $WIRCOptimizedFunction->setAttributeindex($wircoptimizedfunction_data['AttributeIndex']);


            $wirpoints_data = $whatifresult_data['Points'];
            foreach ($wirpoints_data as $wirpoint_data) {
                $WIRPoint = new WIRPoint();
                $WIRPoint->setWhatifresult($WhatIfResult);
                $WIRPoint->setStepposition($wirpoint_data['StepPosition']);
                $WIRPoint->setActualpercent($wirpoint_data['ActualPercent']);
                $WhatIfResult->addPoint($WIRPoint);


                //ASSIGN THE CURRENT MIX DATA
                //ASSIGN THE CURRENT MIX DATA
                $currentmix_data = $wirpoint_data['CurrentMix'];
                $WIRPCurrentMix = new WIRPCurrentMix();
                $WIRPCurrentMix->setPoint($WIRPoint);
                $WIRPoint->setCurrentmix($WIRPCurrentMix);

                $wirp_currentmix_details_data = $currentmix_data['Details'];
                foreach ($wirp_currentmix_details_data as $detail_data) {
                    $WIRPCMDetail = new WIRPCMDetail();
                    $WIRPCMDetail->setCurrentmix($WIRPCurrentMix);
                    $WIRPCMDetail->setTouchpointname($detail_data['TouchpointName']);
                    $WIRPCMDetail->setBudget($detail_data['Budget']);
                    $WIRPCMDetail->setFunctionvalue($detail_data['FunctionValue']);
                    $WIRPCurrentMix->addDetail($WIRPCMDetail);
                }

                $wirp_currentmix_total_data = $currentmix_data['Total'];
                $WIRPCMTotal = new WIRPCMTotal();
                $WIRPCMTotal->setCurrentmix($WIRPCurrentMix);
                $WIRPCMTotal->setTouchpointname($wirp_currentmix_total_data['TouchpointName']);
                $WIRPCMTotal->setBudget($wirp_currentmix_total_data['Budget']);
                $WIRPCMTotal->setFunctionvalue($wirp_currentmix_total_data['FunctionValue']);
                $WIRPCurrentMix->setTotal($WIRPCMTotal);
                //END ASSIGN THE CURRENT MIX DATA
                //ASSIGN THE OPTIMIZED MIX DATA
                //ASSIGN THE OPTIMIZED MIX DATA
                $optimizedmix_data = $wirpoint_data['OptimizedMix'];
                $WIRPOptimizedMix = new WIRPOptimizedMix();
                $WIRPOptimizedMix->setPoint($WIRPoint);
                $WIRPoint->setOptimizedmix($WIRPOptimizedMix);

                $wirp_optimizedmix_details_data = $optimizedmix_data['Details'];
                foreach ($wirp_optimizedmix_details_data as $detail_data) {
                    $WIRPOMDetail = new WIRPOMDetail();
                    $WIRPOMDetail->setOptimizedmix($WIRPOptimizedMix);
                    $WIRPOMDetail->setTouchpointname($detail_data['TouchpointName']);
                    $WIRPOMDetail->setBudget($detail_data['Budget']);
                    $WIRPOMDetail->setFunctionvalue($detail_data['FunctionValue']);
                    $WIRPOptimizedMix->addDetail($WIRPOMDetail);
                }
                $wirp_optimizedmix_total_data = $optimizedmix_data['Total'];
                $WIRPOMTotal = new WIRPOMTotal();
                $WIRPOMTotal->setOptimizedmix($WIRPOptimizedMix);
                $WIRPOMTotal->setTouchpointname($wirp_optimizedmix_total_data['TouchpointName']);
                $WIRPOMTotal->setBudget($wirp_optimizedmix_total_data['Budget']);
                $WIRPOMTotal->setFunctionvalue($wirp_optimizedmix_total_data['FunctionValue']);
                $WIRPOptimizedMix->setTotal($WIRPOMTotal);


                //END ASSIGN THE OPTIMIZED MIX DATA
                //ASSIGN THE SINGLETOUCHPOINT MIX DATA
                //ASSIGN THE SINGLETOUCHPOINT MIX DATA
                $singletouchpointmix_data = $wirpoint_data['SingleTouchpointMix'];
                $WIRPSingleTouchpointMix = new WIRPSingleTouchpointMix();
                $WIRPSingleTouchpointMix->setPoint($WIRPoint);
                $WIRPoint->setSingletouchpointmix($WIRPSingleTouchpointMix);

                $wirp_singletouchpointmix_details_data = $singletouchpointmix_data['Details'];
                foreach ($wirp_singletouchpointmix_details_data as $detail_data) {
                    $WIRPSTMDetail = new WIRPSTMDetail();
                    $WIRPSTMDetail->setSingletouchpointmix($WIRPSingleTouchpointMix);
                    $WIRPSTMDetail->setTouchpointname($detail_data['TouchpointName']);
                    $WIRPSTMDetail->setBudget($detail_data['Budget']);
                    $WIRPSTMDetail->setFunctionvalue($detail_data['FunctionValue']);
                    $WIRPSingleTouchpointMix->addDetail($WIRPSTMDetail);
                }
                $wirp_singletouchpointmix_total_data = $singletouchpointmix_data['Total'];
                $WIRPSTMTotal = new WIRPSTMTotal();
                $WIRPSTMTotal->setSingletouchpointmix($WIRPSingleTouchpointMix);
                $WIRPSTMTotal->setTouchpointname($wirp_singletouchpointmix_total_data['TouchpointName']);
                $WIRPSTMTotal->setBudget($wirp_singletouchpointmix_total_data['Budget']);
                $WIRPSTMTotal->setFunctionvalue($wirp_singletouchpointmix_total_data['FunctionValue']);
                $WIRPSingleTouchpointMix->setTotal($WIRPSTMTotal);

                //END ASSIGN THE SINGLETOUCHPOINT MIX DATA
            }

            $em->persist($WhatIfResult);
        } else {
            $array_of_missing_nodes[] = "WhatIfResult";
        }
        
        
        $lightdata->setCampaign($campaign_id);
        $lightdata->setVersion(1);
        $em->persist($lightdata);
        $em->flush();
        return $lightdata->getId();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 10;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
