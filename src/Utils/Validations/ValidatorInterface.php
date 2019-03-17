<?php

namespace Utils\Validations;

/**
 * Interface ValidatorInterface
 * @package Utils\Validations
 */
interface ValidatorInterface
{
    /**
     * @param $entity
     *
     * @return void
     */
    public function validate($entity) : void;
}