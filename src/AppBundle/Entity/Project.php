<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", unique=true)
     */
    protected $apiId;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Gedmo\Slug(fields={"name"})
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $webUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $group;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $useMergeRequest;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MergeRequest", mappedBy="project", cascade={"persist"})
     */
    protected $mergeRequests;

    /**
     * @ORM\ManyToMany(targetEntity="Developer", mappedBy="projects", cascade={"persist"})
     */
    protected $developers;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->useMergeRequest = false;
        $this->mergeRequests = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getApiId()
    {
        return $this->apiId;
    }

    /**
     * @param int $apiId
     * @return Project
     */
    public function setApiId($apiId)
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     * @return Project
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMergeRequests()
    {
        return $this->mergeRequests;
    }

    /**
     * @param ArrayCollection $mergeRequests
     * @return Project
     */
    public function setMergeRequests($mergeRequests)
    {
        $this->mergeRequests = $mergeRequests;

        return $this;
    }

    /**
     * @param MergeRequest $mergeRequest
     * @return Project
     */
    public function addMergeRequest(MergeRequest $mergeRequest)
    {
        $this->mergeRequests->add($mergeRequest);

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
     * @return Project
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }

    /**
     * @param string $webUrl
     * @return Project
     */
    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUseMergeRequest()
    {
        return $this->useMergeRequest;
    }

    /**
     * @param boolean $useMergeRequest
     * @return Project
     */
    public function setUseMergeRequest($useMergeRequest)
    {
        $this->useMergeRequest = $useMergeRequest;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Project
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }
}
