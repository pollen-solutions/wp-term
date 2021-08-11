<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use WP_Term;
use WP_Term_Query;

interface WpTermManagerInterface extends BootableTraitInterface, ConfigBagAwareTraitInterface, ContainerProxyInterface
{
    /**
     * Booting.
     *
     * @return static
     */
    public function boot(): WpTermManagerInterface;

    /**
     * List of term instance from a WP_Term_Query|from a list of query arguments|for the current queried WordPress
     * taxonomy.
     *
     * @param WP_Term_Query|array|null $query
     *
     * @return WpTermQueryInterface[]|array
     */
    public function fetch($query = null): array;

    /**
     * Get a Term instance from term ID|from term slug|from WP_Term object|for current queried WordPress term.
     *
     * @param string|int|WP_Term|null $term
     *
     * @return WpTermQueryInterface|null
     */
    public function get($term = null): ?WpTermQueryInterface;

    /**
     * Get Taxonomy instance by identifier name.
     *
     * @param string $name
     *
     * @return WpTaxonomyInterface|null
     */
    public function getTaxonomy(string $name): ?WpTaxonomyInterface;

    /**
     * Register taxonomy.
     *
     * @param string $name
     * @param array|WpTaxonomyInterface $taxonomyDef
     *
     * @return WpTaxonomyInterface
     */
    public function registerTaxonomy(string $name, $taxonomyDef = []): WpTaxonomyInterface;

    /**
     * Retrieve related taxonomy manager instance.
     *
     * @return WpTaxonomyManagerInterface
     */
    public function taxonomyManager(): WpTaxonomyManagerInterface;
}