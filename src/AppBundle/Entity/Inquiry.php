<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Inquiry
 *
 * @ORM\Table(name="inquiry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InquiryRepository")
 */
class Inquiry
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=1000)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Inquiry
     */
    public function setEmail($email) : Inquiry
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Inquiry
     */
    public function setMessage($message) : Inquiry
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : ?string
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Inquiry
     */
    public function setCreatedAt($createdAt) : Inquiry
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() : ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Inquiry
     */
    public function setUpdatedAt($updatedAt) : Inquiry
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() : ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Returns validation rules for this entity
     *
     * @param ClassMetadata $metadata
     *
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata) : void
    {
        $metadata->addPropertyConstraint('email', new Assert\NotBlank([
            'message' => 'Email cannot be blank.'
        ]));
        $metadata->addPropertyConstraint('email', new Assert\Email([
            'message' => 'The email {{ value }} is not a valid email.'
        ]));
        $metadata->addPropertyConstraint('message', new Assert\NotBlank([
            'message' => 'Message cannot be blank.'
        ]));
        $metadata->addPropertyConstraint('message', new Assert\Length([
            'max'        => 1000,
            'maxMessage' => 'Message cannot be longer than 1000 characters',
        ]));
    }
}

