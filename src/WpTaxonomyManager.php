<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\Proxy\ContainerProxy;
use Psr\Container\ContainerInterface as Container;

class WpTaxonomyManager implements WpTaxonomyManagerInterface
{
    use ContainerProxy;

    /**
     * Term Manager instance.
     * @var WpTermManagerInterface
     */
    protected WpTermManagerInterface $wpTerm;

    /**
     * List registered taxonomy instance.
     * @var WpTaxonomyInterface[]|array
     */
    public array $taxonomies = [];

    /**
     * @param WpTermManagerInterface $wpTerm
     * @param Container|null $container
     */
    public function __construct(WpTermManagerInterface $wpTerm, ?Container $container = null)
    {
        $this->wpTerm = $wpTerm;

        if ($container !== null) {
            $this->setContainer($container);
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->taxonomies;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): ?WpTaxonomyInterface
    {
        return $this->taxonomies[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function register(string $name,$taxonomyDef): WpTaxonomyInterface
    {
        if (!$taxonomyDef instanceof WpTaxonomyInterface) {
            $taxonomy = new WpTaxonomy($name, is_array($taxonomyDef) ? $taxonomyDef : []);
        } else {
            $taxonomy = $taxonomyDef;
        }
        $this->taxonomies[$name] = $taxonomy;

        return $taxonomy;
    }
}