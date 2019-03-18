<?php

namespace AppBundle\EntityHandlers;

/**
 * Abstract HandlerAbstract
 * @package AppBundle\EntityHandlers
 */
abstract class HandlerAbstract
{

    /**
     * @var
     */
    protected $entity;

    /**
     * @var
     */
    protected $em;

    /**
     * Sets entity data from array values
     *
     * @param array $data
     *
     * @return void
     */
    protected function setDataFromArray(array $data) : void
    {
        foreach ($data as $k => $v) {
            $this->entity->{$this->getEntitySetters()[$k]}($v);
        }
    }

    /**
     * Save entity data to database
     *
     * @return int|null
     */
    public function save() : ?int
    {
        $this->em->persist($this->entity);
        $this->em->flush();

        return $this->entity->getId();
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    abstract public function create(array $data) : bool;

    /**
     * @return void
     */
    abstract protected function setEntity() : void;

    /**
     * @return array
     */
    abstract protected function getEntitySetters() : array;
}