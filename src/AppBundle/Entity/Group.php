<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="m_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group
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
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Point", mappedBy="group")
     */
    protected $points;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getApiId()
    {
        return $this->apiId;
    }

    /**
     * @param string $apiId
     * @return Group
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
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param ArrayCollection $points
     * @return MergeRequest
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * @param Point $point
     * @return MergeRequest
     */
    public function addPoint(Point $point)
    {
        $this->points->add($point);

        return $this;
    }
}
