<?php

namespace Utils\Validations;

use Utils\Helper;
use Symfony\Component\Validator\Validation;

/**
 * Class InquiryValidator
 * @package Utils\Validations
 */
class InquiryValidator implements ValidatorInterface
{
    /**
     * @var
     */
    private $helper;

    /**
     * Validate the inquiry entity according to the rules provided by entity class
     *
     * @param $inquiry
     *
     * @throws \Exception
     *
     * @return void
     */
    public function validate($inquiry) : void
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
     * Sets and return helper
     *
     * @return Helper
     */
    private function getHelper()
    {
        return $this->helper ?? $this->helper = new Helper();
    }

}