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
            $this->saveMultiple($data);
            return true;
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
        foreach ($data as $object) {
            $this->_em->persist($object);
            $index++;
            if (0 === $index % 1000) {
                $this->_em->flush();
            }
        }
        $this->_em->flush();
    }
}
