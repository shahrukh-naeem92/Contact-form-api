<?php

namespace AppBundle\EntityHandlers;

use AppBundle\Entity\Inquiry;
use Utils\Validations\InquiryValidator;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class InquiryHandler
 * @package AppBundle\EntityHandlers
 */
class InquiryHandler extends HandlerAbstract
{

    /**
     * @var
     */
    private $validator;

    /**
     * Inquiry constructor.
     *
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->setEntity();
        $this->em = $em;
    }

    /**
     * Sets entity property
     *
     * @return void
     */
    protected function setEntity(): void
    {
        $this->entity = new Inquiry();
    }

    /**
     * Provides all the setter functions of entity in an array
     *
     * @return array
     */
    public function getEntitySetters() : array
    {
        return [
            'email' => 'setEmail',
            'message' => 'setMessage'
        ];
    }

    /**
     * Handles the creation of entity including validation and persisting the entity to database
     *
     * @param array $data
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function create(array $data) : boolean
    {
        $this->setDataFromArray($data);
        $this->validate();
        $id = $this->save();

        return null != $id;
    }

    /**
     * Sets and return validator
     *
     * @return InquiryValidator
     */
    public function getValidator()
    {
        return $this->validator ?: $this->validator = new InquiryValidator();
    }

    /**
     * Validate the entity
     *
     * @throws \Exception
     */
    public function validate() : void
    {
        $validator = $this->getValidator();
        $validator->validate($this->entity);
    }
}