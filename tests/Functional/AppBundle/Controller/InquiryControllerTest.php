<?php

namespace Tests\Functional\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class InquiryControllerTest
 * @package Tests\Functional\AppBundle\Controller
 */
class InquiryControllerTest extends WebTestCase
{

    /**
     * Tests post action of the inquiry controller.
     *
     * @param string $email
     * @param string $message
     * @param string $expectedMessage
     * @param int $expectedResponseCode
     * @param int $expectedMessageCode
     *
     * @dataProvider postInquiryProvider
     *
     * @return void
     */
    public function testPostInquiry(
        string $email,
        string $message,
        string $expectedMessage,
        int $expectedResponseCode,
        int $expectedMessageCode
    ) : void {
        $client = static::createClient();
        $client->request('Post', '/inquiry', ['email' => $email, 'message' => $message]);
        $content = json_decode($client->getResponse()->getContent(), true);
        $messageStatusCode = $content['status'];
        $message = $content['message'];
        $this->assertEquals($expectedResponseCode, $client->getResponse()->getStatusCode());
        $this->assertEquals($expectedMessage, $message);
        $this->assertEquals($expectedMessageCode, $messageStatusCode);
    }

    /**
     * @return array
     */
    public function postInquiryProvider() : array
    {
        return [
            [
                'test@test.com',
                'test message',
                'Message sent successfully.',
                200,
                200
            ],
            [
                'testemail',
                '',
                'The email "testemail" is not a valid email. , Message cannot be blank.',
                400,
                400
            ],
        ];
    }

    /**
     * Delete all rows inserted during tests
     *
     * @return void
     */
    public function tearDown() : void
    {
        parent::tearDown();

        static::$kernel = static::createKernel();
        static::$kernel -> boot();
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getEntityManager();

        $query = $em->createQuery(
            "DELETE AppBundle:Inquiry i WHERE i.email = 'test@test.com' AND i.message = 'test message'"
        );
        $query->execute();
    }
}