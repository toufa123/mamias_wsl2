<?php

namespace App\Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 */
class Media extends BaseMedia
{
	/**
	 * @var int $id
	 */
	protected $id;

	/**
	 * Get id.
	 *
	 * @return int $id
	 */
	public function getId ()
	{
		return $this->id;
	}
}
