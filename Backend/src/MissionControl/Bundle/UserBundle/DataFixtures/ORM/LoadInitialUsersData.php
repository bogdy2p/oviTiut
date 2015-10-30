<?php

namespace MissionControl\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MissionControl\Bundle\UserBundle\Entity\User;
use MissionControl\Bundle\CampaignBundle\Entity\Useraccess;
use MissionControl\Bundle\UserBundle\Entity\Role;
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;

class LoadInitialUsersData extends AbstractFixture implements OrderedFixtureInterface {

    public function timezoneUTC() {
        return new \DateTimeZone('UTC');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $creationDate = new \DateTime();
        $creationDate->setTimezone(self::timezoneUTC());

        $arrays_of_user_data = array(
            array('qa_user', 'password', 'Quality', 'Assurance User', 'a@a.com', 'ROLE_ADMINISTRATOR', '8f45fa58-4664-b11b-82ee-7a737df7afb7'),
            array('admin', 'admin123', 'Admin', 'Admin123', 'bogdy2p@gmail.com', 'ROLE_ADMINISTRATOR', '12345678-4664-b11b-82ee-7a737df7afb7')
        );
        $count = 0;
        foreach ($arrays_of_user_data as $array_of_user_data) {
            //Generate an aPI KEY//
            $count += 1;
            $rolename = $array_of_user_data[5];
            $role = $manager->getRepository('UserBundle:Role')->findOneByName($rolename);

            // $api_key = Uuid::uuid4()->toString();
            $originalUser = new User();
            $originalUser->setCreatedAt($creationDate);
            $originalUser->setUpdatedAt($creationDate);
            $originalUser->setEnabled(1);
            $originalUser->setLocked(0);
            $originalUser->setExpired(0);
            $originalUser->setCredentialsExpired(0);
            $originalUser->setOffice('New York');
            $originalUser->setTitle('noTitleInformationyet');
            $originalUser->setConfirmationToken('GeneratedOriginalUser');


            $originalUser->addRole($role->getName());
            $originalUser->setUsername($array_of_user_data[0]);
            $originalUser->setEmail($array_of_user_data[4]);
            $originalUser->setUsernameCanonical($array_of_user_data[0]);
            $originalUser->setEmailCanonical($array_of_user_data[4]);
            $originalUser->setPassword(md5($array_of_user_data[1]));
            $originalUser->setApiKey($array_of_user_data[6]);
            $originalUser->setFirstname($array_of_user_data[2]);
            $originalUser->setLastname($array_of_user_data[3]);
            $originalUser->setPhone('2126057000');
            $manager->persist($originalUser);

//    THIS MUST BE DISABLED.
//            //ADD USERACCESS TO TEMP CLIENT FOR EACH OF THIS USERS
//
//            $temp_client = $manager->getRepository('CampaignBundle:Client')->findOneByName('temp_client');
//            $global_region = $manager->getRepository('CampaignBundle:Region')->find(1);
//            $temp_useraccess = new Useraccess();
//            $temp_useraccess->setUser($originalUser);
//            $temp_useraccess->setClient($temp_client);
//            $temp_useraccess->setRegion($global_region);
//            $temp_useraccess->setAllCountries(true);
//            $manager->persist($temp_useraccess);
            //END ADD USERACCESS
        }
        echo'Loaded ' . $count . ' Original Users Successfully.';
        $manager->flush();

        //Set all the default users to have the "created by" set as John Gladysz's Username.
//        $john = $manager->getRepository('UserBundle:User')->findOneByUsername('jgladysz');
//        if ($john) {
//            foreach ($arrays_of_user_data as $userdata) {
//
//                $user = $manager->getRepository('UserBundle:User')->findOneByUsername($userdata[0]);
//                if ($user) {
//                    $user->setCreatedBy($john);
//                    $manager->persist($user);
//                    $manager->flush();
//                }
//            }
//        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 3;
    }

}
