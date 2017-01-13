<?php

namespace ClientBundle\Filter\Gitlab;

use ClientBundle\Filter\AbstractFilter;
use ClientBundle\Filter\FilterInterface;

abstract class AbstractGitlabFilter extends AbstractFilter
{
    /**
     * @var integer
     */
    protected $page = 1;

    /**
     * @var integer
     */
    protected $perPage = 100;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return FilterInterface
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    public function increasePage()
    {
        $this->page++;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return FilterInterface
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }
}
