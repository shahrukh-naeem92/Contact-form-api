<?php

namespace Tests\Unit\AppBundle\EntityHandlers;

use PHPUnit\Framework\TestCase;
use AppBundle\EntityHandlers\InquiryHandler;

/**
 * Class InquiryHandlerTest
 * @package Tests\Unit\AppBundle\EntityHandlers
 */
class InquiryHandlerTest extends TestCase
{

    /**
     * Tests create function of InquiryHandler class
     *
     * @param int|Null $id
     * @param string $email
     * @param string $message
     *
     * @dataProvider createProvider
     *
     * @return void
     */
    public function testCreate(?int $id, string $email, string $message) : void
    {
        $inquiryHandler = $this->getMockBuilder(InquiryHandler::class)
            ->disableOriginalConstructor()
            ->setMethods(['save'])
            ->getMock();
        $inquiryHandler->method('save')->willReturn($id);
        $inquiryHandler->setEntity();
        if (empty($email) || empty($message)) {
            $this->expectException(\InvalidArgumentException::class);
            $inquiryHandler->create(['email' => $email, 'message' => $message]);
        } else {
            $this->assertEquals((bool)$id, $inquiryHandler->create(['email' => $email, 'message' => $message]));
        }
    }

    /**
     * Returns data for testing create function
     *
     * @return array
     */
    public function createProvider() : array
    {
        return [
            [
                1,
                '',
                ''
            ],
            [
                null,
                'test@test.com',
                'test message'
            ]
        ];
    }
}