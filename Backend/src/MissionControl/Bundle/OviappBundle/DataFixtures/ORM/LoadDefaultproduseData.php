<?php

namespace MissionControl\Bundle\OviappBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MissionControl\Bundle\OviappBundle\Entity\Produs;
use Symfony\Component\Config\Definition\Exception\Exception;

class LoadDefaultproduseData extends AbstractFixture implements OrderedFixtureInterface {

    public function timezoneUTC() {
        return new \DateTimeZone('UTC');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $creationDate = new \DateTime();
        $creationDate->setTimezone(self::timezoneUTC());
        echo "Incarcare produse default din datafiles/produse.csv!";
        try {
            $filename = 'web/assets/datafiles/produse.csv';

            if (!file_exists($filename)) {
                throw new Exception($filename . ' was not found !');
            }

            $thefile = fopen($filename, 'r');
            if (!$thefile) {
                throw new Exception($filename . ' open failed.');
            }

            while (!feof($thefile)) {

                $line = fgetcsv($thefile);
                if ($line[0] && $line[1] && $line[2] != NULL) {

                    $produs = new Produs();

//                    $produs->setId($line[0]);
                    $produs->setNume($line[1]);
                    $produs->setCantitate($line[2]);
                    $produs->setAdaosComercial(10);
                    $produs->setTva(24);
                    $produs->setUnitateMasura($line[3]);
                    $produs->setPretLivrare($line[4]);
                    //This should change after phases implementation , should be a link to the phase.
//                    $produs->setCreatedAt($creationDate);
//                    $produs->setUpdatedAt($creationDate);
                    $manager->persist($produs);
                }
            }

            $manager->flush();
            echo 'Taskname data succesfully imported from ' . $filename;
        } catch (Exception $e) {
            echo 'Could not load Taskname data from taskname.csv file .', "\n";
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1;
    }

}
