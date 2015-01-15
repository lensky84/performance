<?php

namespace Lensky\PerformanceBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * @var string
     */
    private $alias = 'p';

    /**
     * @param array $orderBy
     *
     * @return array | Post[]
     */
    public function findPostsAndAuthors(array $orderBy)
    {
        $qb = $this->createQueryBuilder($this->alias);
        $qb->addSelect('a')
            ->innerJoin('p.author', 'a');
        $this->addOrder($orderBy, $qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array        $orderBy
     * @param QueryBuilder $qb
     */
    private function addOrder(array $orderBy, QueryBuilder $qb)
    {
        foreach ($orderBy as $orderFieldName => $orderValue) {
            $qb->addOrderBy($this->alias . '.' . $orderFieldName, $orderValue);
        }
    }

    /**
     * Update created date for all posts
     *
     * @param \DateTime $newCreatedAt
     *
     * @return int
     */
    public function updateCreatedAtForAllPosts(\DateTime $newCreatedAt)
    {
        $qb = $this->createQueryBuilder($this->alias);
        $qb->update()
            ->set('p.createdAt', ':newCreatedAt')
            ->setParameter('newCreatedAt', $newCreatedAt);

        return $qb->getQuery()->execute();
    }
}
