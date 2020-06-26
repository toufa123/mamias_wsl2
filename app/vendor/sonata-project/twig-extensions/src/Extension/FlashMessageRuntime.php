<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Twig\Extension;

use Sonata\Twig\FlashMessage\FlashManager;

/**
 * This is the Sonata flash message Twig runtime.
 *
 * @author Vincent Composieux <composieux@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final since sonata-project/twig-extensions 0.x
 */
class FlashMessageRuntime
{
    /**
     * @var FlashManager
     */
    private $flashManager;

    public function __construct(FlashManager $flashManager)
    {
        $this->flashManager = $flashManager;
    }

    /**
     * Returns flash messages handled by Sonata flash manager.
     *
     * @param string      $type             Type of flash message
     * @param string|null $deprecatedDomain Translation domain to use
     *
     * @return array
     */
    public function getFlashMessages($type, $deprecatedDomain = null)
    {
        return $this->flashManager->get($type, $deprecatedDomain);
    }

    /**
     * Returns flash messages types handled by Sonata flash manager.
     *
     * @return array
     */
    public function getFlashMessagesTypes()
    {
        return $this->flashManager->getHandledTypes();
    }
}
