<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Point
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var MergeRequest
     *
     * @ORM\ManyToOne(targetEntity="MergeRequest", inversedBy="points", cascade={"persist"})
     * @ORM\JoinColumn(name="merge_request_id", referencedColumnName="id")
     */
    protected $mergeRequest;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="points", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="points", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @var Developer
     *
     * @ORM\ManyToOne(targetEntity="Developer", inversedBy="points", cascade={"persist"})
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id")
     */
    protected $developer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Score
     */
    public function setMergeRequest($mergeRequest)
    {
        $this->mergeRequest = $mergeRequest;

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Score
     */
    public function setProject($project)
    {
        $this->project = $project;

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
     * @return Score
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Developer
     */
    public function getDeveloper()
    {
        return $this->developer;
    }

    /**
     * @param Developer $developer
     * @return Score
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;

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
     * @return Score
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
