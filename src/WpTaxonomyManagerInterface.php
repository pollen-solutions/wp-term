<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\Proxy\ContainerProxyInterface;

interface WpTaxonomyManagerInterface extends ContainerProxyInterface
{
    /**
     * Return list of registered taxonomy instances.
     *
     * @return WpTaxonomyInterface[]|array
     */
    public function all(): array;

    /**
     * Get taxonomy instance by identifier name.
     *
     * @param string $name.
     *
     * @return WpTaxonomyInterface|null
     */
    public function get(string $name): ?WpTaxonomyInterface;

    /**
     * Register taxonomy.
     *
     * @param string $name
     * @param WpTaxonomyInterface|array $taxonomyDef
     *
     * @return WpTaxonomyInterface
     */
    public function register(string $name, $taxonomyDef): WpTaxonomyInterface;
}