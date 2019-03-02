<?php

namespace Tests\Unit\Helper;

use PHPUnit\Framework\TestCase;
use Helper\Helper;
use AppBundle\Entity\Inquiry;
use Symfony\Component\Validator\Validation;

/**
 * Class HelperTest
 * @package Tests\Unit\Helper
 */
class HelperTest extends TestCase
{
    /**
     * @param string $email
     * @param string $message
     * @param string $expected
     * @dataProvider handleValidationErrorMessagesProvider
     */
    public function testHandleValidationErrorMessages(string $email, string $message, string $expected) : void
    {
        $helper = new Helper();
        $inquiry = new Inquiry();
        $inquiry->setEmail($email);
        $inquiry->setMessage($message);
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')  //load object validator
            ->getValidator();
        $errors = $validator->validate($inquiry);
        $this->assertEquals($expected, $helper->handleValidationErrorMessages($errors));

    }

    /**
     * @return array
     */
    public function handleValidationErrorMessagesProvider() : array
    {
        return [
            [
              '',
              '',
              'Email cannot be blank. , Message cannot be blank.'
            ],
            [
              'test@test.com',
              '',
              'Message cannot be blank.'
            ],
            [
              'testemail',
              'Test message',
              'The email "testemail" is not a valid email.'
            ]
        ];
    }
}