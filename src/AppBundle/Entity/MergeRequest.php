<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MergeRequestRepository")
 */
class MergeRequest
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $upVotes;

    /**
     * @var Developer
     *
     * @ORM\ManyToOne(targetEntity="Developer", inversedBy="mergeRequests", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id")
     */
    protected $developer;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="mergeRequests", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Commit", mappedBy="mergeRequest", cascade={"persist"}, fetch="EAGER")
     */
    protected $commits;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Point", mappedBy="mergeRequest")
     */
    protected $points;

    /**
     * @var ArrayCollection
     */
    protected $changes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->commits = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getApiId()
    {
        return $this->apiId;
    }

    /**
     * @param integer $apiId
     * @return MergeRequest
     */
    public function setApiId($apiId)
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MergeRequest
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return MergeRequest
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return MergeRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpVotes()
    {
        return $this->upVotes;
    }

    /**
     * @param int $upVotes
     * @return MergeRequest
     */
    public function setUpVotes($upVotes)
    {
        $this->upVotes = $upVotes;

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
     * @return MergeRequest
     */
    public function setDeveloper($developer)
    {
        $this->developer = $developer;

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
     * @return MergeRequest
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
        $project->addMergeRequest($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCommits()
    {
        return $this->commits;
    }

    /**
     * @param ArrayCollection $commits
     * @return MergeRequest
     */
    public function setCommits($commits)
    {
        $this->commits = $commits;

        return $this;
    }

    /**
     * @param Commit $commit
     * @return MergeRequest
     */
    public function addCommit(Commit $commit)
    {
        $commit->setMergeRequest($this);
        $this->commits->add($commit);

        return $this;
    }

    /**
     * @return MergeRequest
     */
    public function resetCommit()
    {
        $this->commits->clear();

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

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return MergeRequest
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return MergeRequest
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param ArrayCollection $changes
     * @return MergeRequest
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;

        return $this;
    }
}
