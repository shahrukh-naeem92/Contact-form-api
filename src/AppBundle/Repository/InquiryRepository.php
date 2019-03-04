<?php

namespace AppBundle\Repository;

use Helper\Helper;
use AppBundle\Entity\Inquiry;
use Symfony\Component\Validator\Validation;

/**
 * Class InquiryRepository
 * @package AppBundle\Repository
 */
class InquiryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var
     */
    private $helper;

    /**
     * @param Inquiry $inquiry
     * @throws \InvalidArgumentException
     */
    public function validateInquiry(Inquiry $inquiry) : void
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')  //load object validator
            ->getValidator();
        $errors = $validator->validate($inquiry);
        if (count($errors) > 0) {
            $helper = $this->getHelper();
            throw new \InvalidArgumentException($helper->handleValidationErrorMessages($errors));
        }
    }

    /**
     * @return Helper
     */
    private function getHelper()
    {
        return $this->helper ?? $this->helper = new Helper();
    }
}
