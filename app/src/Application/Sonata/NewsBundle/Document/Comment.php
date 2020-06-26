<?php

namespace App\Application\Sonata\NewsBundle\Document;

use Sonata\NewsBundle\Document\BaseComment as BaseComment;

/**
 * This file has been generated by the SonataEasyExtendsBundle.
 *
 * @link https://sonata-project.org/easy-extends
 *
 * References:
 * @link http://www.doctrine-project.org/docs/mongodb_odm/1.0/en/reference/working-with-objects.html
 */
class Comment extends BaseComment
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
