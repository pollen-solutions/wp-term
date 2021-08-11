<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\Exception\ProxyInvalidArgumentException;
use Pollen\Support\ProxyResolver;
use RuntimeException;
use WP_Term;
use WP_Term_Query;

/**
 * @see \Pollen\WpTerm\WpTaxonomyProxyInterface
 */
trait WpTermProxy
{
    /**
     * Related Term Manager instance.
     * @var WpTermManagerInterface|null
     */
    private ?WpTermManagerInterface $wpTermManager = null;

    /**
     * Resolve term manager instance|Retrieve list of term instances|Get a term instance.
     *
     * @param true|string|int|WP_Term|WP_Term_Query|array|null $query
     *
     * @return WpTermManagerInterface|WpTermQueryInterface|WpTermQueryInterface[]|array
     */
    public function wpTerm($query = null)
    {
        if ($this->wpTermManager === null) {
            try {
                $this->wpTermManager = WpTermManager::getInstance();
            } catch (RuntimeException $e) {
                $this->wpTermManager = ProxyResolver::getInstance(
                    WpTermManagerInterface::class,
                    WpTermManager::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        if ($query === null) {
            return $this->wpTermManager;
        }

        if (is_array($query) || ($query instanceof WP_Term_Query)) {
            return $this->wpTermManager->fetch($query);
        }

        if ($term = $this->wpTermManager->get($query)) {
            return $term;
        }

        throw new ProxyInvalidArgumentException('WpTerm Queried is unavailable');
    }

    /**
     * Set related term manager instance.
     *
     * @param WpTermManagerInterface $wpTermManager
     *
     * @return void
     */
    public function setWpTermManager(WpTermManagerInterface $wpTermManager): void
    {
        $this->wpTermManager = $wpTermManager;
    }
}
