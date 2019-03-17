<?php

namespace AppBundle\EntityHandlers;

/**
 * Abstract EntityHandlerAbstract
 * @package AppBundle\EntityHandlers
 */
Abstract class EntityHandlerAbstract
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
     * @param array $data
     *
     * @return bool
     */
    public abstract function create(array $data) : boolean;

    /**
     * @return void
     */
    protected abstract function setEntity() : void;

    /**
     * @return array
     */
    protected abstract function getEntitySetters() : array;

    /**
     * Sets entity data from array values
     *
     * @param array $data
     *
     * @return void
     */
    protected function setDataFromArray(array $data) : void
    {
        foreach($data as $k => $v) {
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
}