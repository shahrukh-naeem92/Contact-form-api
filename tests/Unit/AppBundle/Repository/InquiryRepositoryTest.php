<?php

namespace Tests\Unit\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Inquiry;

/**
 * Class InquiryRepositoryTest
 * @package Tests\Unit\AppBundle\Repository
 */
class InquiryRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * sets up entity manager
     */
    protected function setUp() : void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @param string $email
     * @param string $message
     * @dataProvider ValidateInquiryProvider
     */
    public function testValidateInquiry(string $email, string $message) : void
    {
        $repo = $this->entityManager
            ->getRepository(Inquiry::class) ;
        $inquiry = new Inquiry();
        $inquiry->setEmail($email);
        $inquiry->setMessage($message);

        if (empty($email) || empty($message)) {

            $this->expectException(\InvalidArgumentException::class);
            $repo->validateInquiry($inquiry);

        } else {

            $this->assertEquals('', $repo->validateInquiry($inquiry));

        }

    }

    /**
     * @return array
     */
    public function ValidateInquiryProvider() : array
    {
        return [
            [
                '',
                ''
            ],
            [
                'test@test.com',
                'test message'
            ],

        ];
    }

    /**
     * close and release entity manager
     */
    protected function tearDown() : void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}