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

        $receptie = new Reception();

        $furnizor = $manager->getRepository('OviappBundle:Furnizor')->findOneByName('NumeFurnizor1');

        $receptie->setClient($furnizor);
        $receptie->setUser('date_creator');
        $receptie->setDateCreated('data_creare');
        $receptie->setDateUpdated('data_update');
        $receptie->setProducts('array_produse');
        //This should change after phases implementation , should be a link to the phase.
        $manager->persist($receptie);

        $manager->flush();
        echo 'Receptie creata cu success ';
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}