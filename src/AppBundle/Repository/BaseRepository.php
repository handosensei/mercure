<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

abstract class BaseRepository extends EntityRepository
{
    /**
     * @param $data
     * @return null
     */
    public function remove($data)
    {
        if (empty($data) ) {
            return null;
        }

        foreach ($data as $object) {
            $this->_em->remove($object);
        }
        $this->_em->flush();
    }

    /**
     * @param mixed $data
     * @return null|mixed
     */
    public function save($data)
    {
        if (is_array($data)) {
            return $this->saveMultiple($data);
        }

        if (is_object($data)) {
            $this->_em->persist($data);
            $this->_em->flush();

            return $data;
        }

        return null;
    }

    /**
     * @param array $data
     * @return null
     */
    public function saveMultiple($data)
    {
        if (!is_array($data)) {
            return null;
        }
        $index = 0;
        $result = [];
        foreach ($data as $object) {
            $this->_em->persist($object);
            $index++;
            if (0 === $index % 1000) {
                $this->_em->flush();
            }
            $result[] = $object;
        }
        $this->_em->flush();

        return $result;
    }

    /**
     * @param array $data
     * @param string $field
     * @return array
     */
    public function parseByKey($data, $field = 'id')
    {
        $method = sprintf('get%s', ucfirst($field));
        $result = [];
        foreach ($data as $object) {
            $result[$object->$method()] = $object;
        }

        return $result;
    }
}
