<?php

/*
 * This file is part of the YesWeHack BugBounty backend
 *
 * (c) Romain Honel <romain.honel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picoss\SonataExtraAdminBundle\Filter;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Gedmo\SoftDeleteable\SoftDeleteableListener;

/**
 * Class SoftDeleteableTrashFilter
 *
 * @author Romain Honel <romain.honel@gmail.com>
 */
class SoftDeleteableTrashFilter extends SQLFilter
{
    /**
     * @var SoftDeleteableListener
     */
    protected $listener;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var string[bool]
     */
    protected $disabled = [];

    /**
     * @param ClassMetadata $targetEntity
     * @param string $targetTableAlias
     *
     * @return string
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        $class = $targetEntity->getName();
        if (array_key_exists($class, $this->disabled) && $this->disabled[$class] === true) {
            return '';
        } elseif (array_key_exists($targetEntity->rootEntityName, $this->disabled) && $this->disabled[$targetEntity->rootEntityName] === true) {
            return '';
        }

        $config = $this->getListener()->getConfiguration($this->getEntityManager(), $targetEntity->name);

        if (!isset($config['softDeleteable']) || !$config['softDeleteable']) {
            return '';
        }

        $conn = $this->getEntityManager()->getConnection();
        $platform = $conn->getDatabasePlatform();
        $column = $targetEntity->getQuotedColumnName($config['fieldName'], $platform);

        $addCondSql = $platform->getIsNotNullExpression($targetTableAlias . '.' . $column);
        if (isset($config['timeAware']) && $config['timeAware']) {
            $now = $conn->quote(date('Y-m-d H:i:s')); // should use UTC in database and PHP
            $addCondSql = "({$addCondSql} OR {$targetTableAlias}.{$column} > {$now})";
        }

        return $addCondSql;
    }

    /**
     * @param string $class
     */
    public function disableForEntity($class)
    {
        $this->disabled[$class] = true;
    }

    /**
     * @param string $class
     */
    public function enableForEntity($class)
    {
        $this->disabled[$class] = false;
    }

    /**
     * @return SoftDeleteableListener
     *
     * @throws \RuntimeException
     */
    protected function getListener()
    {
        if ($this->listener === null) {
            $em = $this->getEntityManager();
            $evm = $em->getEventManager();

            foreach ($evm->getListeners() as $listeners) {
                foreach ($listeners as $listener) {
                    if ($listener instanceof SoftDeleteableListener) {
                        $this->listener = $listener;

                        break 2;
                    }
                }
            }

            if ($this->listener === null) {
                throw new \RuntimeException('Listener "SoftDeleteableListener" was not added to the EventManager!');
            }
        }

        return $this->listener;
    }

    /**
     * @return EntityManagerInterface
     *
     * @throws \ReflectionException
     */
    protected function getEntityManager()
    {
        if ($this->entityManager === null) {
            $refl = new \ReflectionProperty('Doctrine\ORM\Query\Filter\SQLFilter', 'em');
            $refl->setAccessible(true);
            $this->entityManager = $refl->getValue($this);
        }

        return $this->entityManager;
    }
}
