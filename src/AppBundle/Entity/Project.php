<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", unique=true)
     */
    protected $apiId;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $group;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MergeRequest", mappedBy="project")
     */
    protected $mergeRequests;

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
}
