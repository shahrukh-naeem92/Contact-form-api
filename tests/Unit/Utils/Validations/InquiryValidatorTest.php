<?php

namespace Tests\Unit\Utils\Validations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Utils\Validations\InquiryValidator;
use AppBundle\Entity\Inquiry;

/**
 * Class InquiryRepositoryTest
 * @package Tests\Unit\AppBundle\Repository
 */
class InquiryValidatorTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * sets up entity manager
     *
     * @return void
     */
    protected function setUp() : void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Tests validate method of InquiryValidator class.
     *
     * @param string $email
     * @param string $message
     *
     * @dataProvider validateInquiryProvider
     *
     * @return void
     */
    public function testValidateInquiry(string $email, string $message) : void
    {
        $validator = new InquiryValidator();
        $inquiry = new Inquiry();
        $inquiry->setEmail($email);
        $inquiry->setMessage($message);

        if (empty($email) || empty($message)) {
            $this->expectException(\InvalidArgumentException::class);
            $validator->validate($inquiry);
        } else {
            $this->assertEquals('', $validator->validate($inquiry));
        }
    }

    /**
     * @return array
     */
    public function validateInquiryProvider() : array
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
     *
     * @return void
     */
    protected function tearDown() : void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}