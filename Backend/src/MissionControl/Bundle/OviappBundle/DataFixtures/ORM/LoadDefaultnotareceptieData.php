<?php

namespace MissionControl\Bundle\OviappBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MissionControl\Bundle\OviappBundle\Entity\Reception;
use Symfony\Component\Config\Definition\Exception\Exception;

class LoadDefaultnotareceptieData extends AbstractFixture implements OrderedFixtureInterface
{

    public function timezoneUTC()
    {
        return new \DateTimeZone('UTC');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $creationDate = new \DateTime();
        $creationDate->setTimezone(self::timezoneUTC());
//        echo "Incarcare produse default din datafiles/produse.csv!";
        echo "Creare nota receptie default !";
        try {
            $filename = 'web/assets/datafiles/produse.csv';

//            if (!file_exists($filename)) {
//                throw new Exception($filename.' was not found !');
//            }
//
//            $thefile = fopen($filename, 'r');
//            if (!$thefile) {
//                throw new Exception($filename.' open failed.');
//            }
//
//            while (!feof($thefile)) {
//
//                $line = fgetcsv($thefile);
//                if ($line[0] && $line[1] && $line[2] != NULL) {
//
//                }
//            }

            $receptie = new Reception();
//                    $produs->setId($line[0]);
            $receptie->setClient('date_client');
            $receptie->setCreator('date_creator');
            $receptie->setDateCreated('data_creare');
            $receptie->setDateUpdated('data_update');
            $receptie->setProducts('array_produse');
            //This should change after phases implementation , should be a link to the phase.
            $manager->persist($receptie);



            $manager->flush();
            echo 'Receptie creata cu success ';
        } catch (Exception $e) {
            echo 'Receptia nu a putut fi inserata.', "\n";
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}