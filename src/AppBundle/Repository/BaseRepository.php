<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

abstract class BaseRepository extends EntityRepository
{
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
}
