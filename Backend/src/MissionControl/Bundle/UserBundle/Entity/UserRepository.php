<?php

namespace MissionControl\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

//use MissionControl\Bundle\CampaignBundle\Entity\Teammember;

/**
 * CampaignRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    public function findAllAdministrators() {

        $query = $this->getEntityManager()->createQuery(
                        'SELECT u FROM UserBundle:User u WHERE u.roles LIKE :role'
                )->setParameter('role', '%"ROLE_ADMINISTRATOR"%');
        $administrators = $query->getResult();
        return $administrators;
    }

}
