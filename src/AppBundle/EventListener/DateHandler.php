<?php

namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\Inquiry;

/**
 * Class DateHandler
 * @package AppBundle\EventListener
 */
class DateHandler
{
    /**
     * @param LifecycleEventArgs $args
     * @return Void
     */
    public function prePersist(LifecycleEventArgs $args) : Void
    {
        $entity = $args->getObject();

        if ($entity instanceof Inquiry) {
            $date = new \DateTime();
            $entity->setCreatedAt($date);
            $entity->setUpdatedAt($date);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return Void
     */
    public function preUpdate(LifecycleEventArgs $args) : Void
    {
        $entity = $args->getObject();

        if ($entity instanceof Inquiry) {
            $entity->setUpdatedAt(new \DateTime());
        }
    }
}