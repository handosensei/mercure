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
            ->setId($this->accessor->getValue($data, '[id]'))
            ->setShortId($this->accessor->getValue($data, '[short_id]'))
            ->setMessage($this->accessor->getValue($data, '[message]'))
            ->setDeveloperName($this->accessor->getValue($data, '[author_name]'))
            ->setDeveloperEmail($this->accessor->getValue($data, '[author_email]'))
            ->setCreatedAt($createdAt)
        ;

        return $commit;
    }

}
