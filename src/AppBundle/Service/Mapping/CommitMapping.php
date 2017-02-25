<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Commit;

class CommitMapping extends AbstractMapping implements MappingInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $data)
    {
        $commit = new Commit();
        $date = $this->accessor->getValue($data, '[created_at]');
        $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($date)));
        $commit
            ->setCreatedAt($createdAt)
            ->setMessage($this->accessor->getValue($data, '[message]'))
            ->setSha1($this->accessor->getValue($data, '[id]'))
        ;
        return $commit;
    }

}
