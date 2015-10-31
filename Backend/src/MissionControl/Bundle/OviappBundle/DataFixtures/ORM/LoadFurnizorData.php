<?php

namespace MissionControl\Bundle\OviappBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MissionControl\Bundle\OviappBundle\Entity\Furnizor;
use Symfony\Component\Config\Definition\Exception\Exception;

class LoadFurnizorData extends AbstractFixture implements OrderedFixtureInterface
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

        echo "Creare Furnizor Default !";
        for ($i = 0; $i <= 3; $i++) {
            $furnizor = new Furnizor();

            $furnizor->setName('Furnizorul '.$i);
            $furnizor->setAdress('AdresaFurnizor '.$i);
            $furnizor->setPhone('071532423'.$i);

            $manager->persist($furnizor);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}