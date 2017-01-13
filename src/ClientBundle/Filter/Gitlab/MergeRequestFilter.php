<?php

namespace ClientBundle\Client;

use ClientBundle\Filter\Gitlab\AbstractGitlabFilter;

class MergeRequestFilter extends AbstractGitlabFilter
{
    /**
     * @var integer
     */
    protected $iid;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $sort;

    /**
     * @var string
     */
    protected $orderBy;

    /**
     * @return int
     */
    public function getIid()
    {
        return $this->iid;
    }

    /**
     * @param int $iid
     * @return MergeRequestFilter
     */
    public function setIid($iid)
    {
        $this->iid = $iid;

        return $this;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     * @return MergeRequestFilter
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     * @return MergeRequestFilter
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

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
     * @return MergeRequestFilter
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }
}
