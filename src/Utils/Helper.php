<?php

namespace Utils;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class Helper
 * @package Utils
 */
class Helper
{
    /**
     * Converts ConstraintViolationListInterface object to a concatenated string of errors separated by comma.
     *
     * @param ConstraintViolationListInterface $errors
     *
     * @return string
     */
    public function handleValidationErrorMessages(ConstraintViolationListInterface $errors) : string
    {
        $messages = [];
        foreach ($errors as $violation) {
            $messages[] = $violation->getMessage();
        }

        return implode(' , ', $messages);
    }
}