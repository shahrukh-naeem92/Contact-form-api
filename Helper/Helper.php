<?php

namespace Helper;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class Helper
 * @package Helper
 */
class Helper
{
    /**
     * @param ConstraintViolationListInterface $errors
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