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
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Developer", mappedBy="projects")
     */
    protected $developers;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="projects")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;
    
    public function __construct()
    {
        $this->developers = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getDevelopers()
    {
        return $this->developers;
    }

    /**
     * @param ArrayCollection $developers
     * @return Project
     */
    public function setDevelopers($developers)
    {
        $this->developers = $developers;
        
        return $this;
    }

    /**
     * @param Developer $developer
     * @return Project
     */
    public function addDeveloper(Developer $developer)
    {
        $this->developers->add($developer);
        $developer->addProject($this);

        return $this;
    }
}
