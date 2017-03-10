<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommitRepository")
 */
class Commit
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $shortId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $message;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $developerName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $developerEmail;

    /**
     * @var MergeRequest
     *
     * @ORM\ManyToOne(targetEntity="MergeRequest", inversedBy="commits", cascade={"persist"})
     * @ORM\JoinColumn(name="merge_request_id", referencedColumnName="id")
     */
    protected $mergeRequest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Commit
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortId()
    {
        return $this->shortId;
    }

    /**
     * @param string $shortId
     * @return Commit
     */
    public function setShortId($shortId)
    {
        $this->shortId = $shortId;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Commit
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return MergeRequest
     */
    public function getMergeRequest()
    {
        return $this->mergeRequest;
    }

    /**
     * @param MergeRequest $mergeRequest
     * @return Commit
     */
    public function setMergeRequest(MergeRequest $mergeRequest)
    {
        $this->mergeRequest = $mergeRequest;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Commit
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloperName()
    {
        return $this->developerName;
    }

    /**
     * @param string $developerName
     * @return Commit
     */
    public function setDeveloperName($developerName)
    {
        $this->developerName = $developerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloperEmail()
    {
        return $this->developerEmail;
    }

    /**
     * @param string $developerEmail
     * @return Commit
     */
    public function setDeveloperEmail($developerEmail)
    {
        $this->developerEmail = $developerEmail;

        return $this;
    }
}
