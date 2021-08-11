<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use WP_Term;
use Wp_Term_Query;

interface WpTermProxyInterface
{
    /**
     * Resolve term manager instance|Retrieve list of term instances|Get a term instance.
     *
     * @param true|string|int|WP_Term|WP_Term_Query|array|null $query
     *
     * @return WpTermManagerInterface|WpTermQueryInterface|WpTermQueryInterface[]|array
     */
    public function wpTerm($query = null);

    /**
     * Set related term manager instance.
     *
     * @param WpTermManagerInterface $wpTermManager
     *
     * @return void
     */
    public function setWpTermManager(WpTermManagerInterface $wpTermManager): void;
}
