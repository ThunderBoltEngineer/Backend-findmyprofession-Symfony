<?php

namespace RestBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use RestBundle\Entity\Message;
use RestBundle\Entity\User;

/**
 * MessageRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class MessageRepository extends EntityRepository
{
    public function getUserMessages(User $user)
    {
        return $this->createQueryBuilder('message')
            ->where('message.author = :user')
            ->orWhere('message.recipient = :user')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Message[]|array
     */
    public function getUnreadMessages()
    {
        $date = (new \DateTime())->modify('-2 minutes');

        return $this->createQueryBuilder('message')
            ->where('message.is_unread = 1')
            ->andWhere('message.date < :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}