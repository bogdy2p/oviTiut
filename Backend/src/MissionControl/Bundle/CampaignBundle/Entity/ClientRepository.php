<?php

namespace MissionControl\Bundle\CampaignBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends EntityRepository {

    public function findAllWithout_all_clients() {

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->select('c')
                ->from('CampaignBundle:Client', 'c')
                ->where('c.name != ?1')
                ->orderBy('c.id', 'ASC')
                ->setParameter(1, 'all_clients');

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();
        
        return $results;
    }
}
