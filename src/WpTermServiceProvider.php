<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Container\BootableServiceProvider;

class WpTermServiceProvider extends BootableServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        WpTermManagerInterface::class,
        WpTaxonomyManagerInterface::class
    ];

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->getContainer()->share(WpTermManagerInterface::class, function() {
            return new WpTermManager([], $this->getContainer());
        });

        $this->getContainer()->share(
            WpTaxonomyManagerInterface::class,
            function () {
                return new WpTaxonomyManager(
                    $this->getContainer()->get(WpTermManagerInterface::class), $this->getContainer()
                );
            }
        );
    }
}