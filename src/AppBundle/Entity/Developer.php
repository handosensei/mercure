<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeveloperRepository")
 */
class Developer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    protected $apiId;

    /**
     * @ORM\Column(unique=true)
     */
    protected $username;

    /**
     * @ORM\Column()
     */
    protected $name;

    /**
     * @ORM\Column()
     */
    protected $state;

    /**
     * @ORM\Column()
     */
    protected $gravatarUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="developers", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="developers", cascade={"persist"})
     */
    protected $projects;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MergeRequest", mappedBy="developer")
     */
    protected $mergeRequests;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @return int
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
     * @return Developer
     */
    public function setApiId($apiId)
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Developer
     */
    public function setUsername($username)
    {
        $this->username = $username;

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
     * @return Developer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Developer
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getGravatarUrl()
    {
        return $this->gravatarUrl;
    }

    /**
     * @param string $gravatarUrl
     * @return Developer
     */
    public function setGravatarUrl($gravatarUrl)
    {
        $this->gravatarUrl = $gravatarUrl;

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
     * @return Developer
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param ArrayCollection $projects
     * @return Developer
     */
    public function setProjects(ArrayCollection $projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * @param Project $project
     * @return Developer
     */
    public function addProject(Project $project)
    {
        $this->projects->add($project);

        return $this;
    }
}
