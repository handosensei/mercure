<?php

namespace ClientBundle\Filter;

/**
 * Class AbstractFilter
 * @package ClientBundle\Filter
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @inheritdoc
     */
    public function getParameters()
    {
        return $this->buildParameters();
    }

    /**
     * @return array
     */
    private function buildParameters()
    {
        $classVars = get_class_vars(get_class($this));
        foreach ($classVars as $name => $value) {
            if (null === $value) {
                continue;
            }

            $method = sprintf('get%s',ucfirst($name));
            $this->parameters[$name] = $this->$method();
        }

        return $this->parameters;
    }
}
