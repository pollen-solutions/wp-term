<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\ParamsBagInterface;
use WP_Term;
use WP_Term_Query;

/**
 * @property-read int $term_id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string $term_group
 * @property-read int $term_taxonomy_id
 * @property-read string $taxonomy
 * @property-read string $description
 * @property-read int $parent
 * @property-read int $count
 * @property-read string $filter
 */
interface WpTermQueryInterface extends ParamsBagInterface
{
    /**
     * Build an instance from WP_Term object.
     *
     * @param WP_Term|object $wp_term
     *
     * @return static
     */
    public static function build(object $wp_term): ?WpTermQueryInterface;

    /**
     * Create an instance from a term ID|from a term slug|from a WP_Term object|for current queried WordPress Term.
     *
     * @param int|string|WP_Term|null $termDef
     * @param mixed ...$args List of custom arguments
     *
     * @return static|null
     */
    public static function create($termDef = null, ...$args): ?WpTermQueryInterface;

    /**
     * Create an instance for current term.
     *
     * @return static|null
     */
    public static function createFromGlobal(): ?WpTermQueryInterface;

    /**
     * Create an instance from term ID.
     *
     * @param int $term_id
     *
     * @return static|null
     */
    public static function createFromId(int $term_id): ?WpTermQueryInterface;

    /**
     * Create an instance from term slug.
     *
     * @param string $term_slug
     * @param string|null $taxonomy
     *
     * @return static|null
     */
    public static function createFromSlug(string $term_slug, ?string $taxonomy = null): ?WpTermQueryInterface;

    /**
     * Retrieve list of instances from WP_Term_Query object|from a list of query arguments.
     *
     * @param WP_Term_Query|array $query
     *
     * @return WpTermQueryInterface[]|array
     */
    public static function fetch($query): array;

    /**
     * Retrieve list of instances from a list of query arguments.
     * @see https://developer.wordpress.org/reference/classes/wp_term_query/
     *
     * @param array $args
     *
     * @return WpTermQueryInterface[]|array
     */
    public static function fetchFromArgs(array $args = []): array;

    /**
     * Retrieve list of instances from a list of term IDs.
     * @see https://developer.wordpress.org/reference/classes/wp_term_query/
     *
     * @param int[] $ids Liste des identifiants de qualification.
     *
     * @return WpTermQueryInterface[]|array
     */
    public static function fetchFromIds(array $ids): array;

    /**
     * Retrieve list of instances from WP_Term_Query object.
     * @see https://developer.wordpress.org/reference/classes/wp_term_query/
     *
     * @param WP_Term_Query $wp_term_query
     *
     * @return WpTermQueryInterface[]|array
     */
    public static function fetchFromWpTermQuery(WP_Term_Query $wp_term_query): array;

    /**
     * Check class instance integrity.
     *
     * @param static|object $instance
     *
     * @return bool
     */
    public static function is($instance): bool;

    /**
     * Parse term query arguments.
     *
     * @param array $args
     *
     * @return array
     */
    public static function parseQueryArgs(array $args = []) : array;

    /**
     * Set a built-in class name by taxonomy.
     *
     * @param string $taxonomy
     * @param string $classname
     *
     * @return void
     */
    public static function setBuiltInClass(string $taxonomy, string $classname): void;

    /**
     * Set the defaults list of terms query arguments.
     *
     * @param array $args
     *
     * @return void
     */
    public static function setDefaultArgs(array $args): void;

    /**
     * Set the fallback class name.
     *
     * @param string $classname
     *
     * @return void
     */
    public static function setFallbackClass(string $classname): void;

    /**
     * Set related taxonomy by identifier.
     *
     * @param string $taxonomy
     *
     * @return void
     */
    public static function setTaxonomy(string $taxonomy): void;

    /**
     * Get term description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get term ID.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Get term meta.
     *
     * @param string $meta_key
     * @param bool $single
     * @param mixed $default
     *
     * @return mixed
     */
    public function getMeta(string $meta_key, bool $single = false, $default = null);

    /**
     * Get term meta multi.
     *
     * @param string $meta_key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getMetaMulti(string $meta_key, $default = null);

    /**
     * Get term meta single.
     *
     * @param string $meta_key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getMetaSingle(string $meta_key, $default = null);

    /**
     * Get term name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get term display permalink.
     *
     * @return string
     */
    public function getPermalink(): string;

    /**
     * Get term slug.
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Get taxonomy name identifier.
     *
     * @return string
     */
    public function getTaxonomy(): string;

    /**
     * Get Wordpress WP_Term object.
     *
     * @return WP_Term
     */
    public function getWpTerm(): WP_Term;

    /**
     * Check if term is in taxonomy by name.
     *
     * @param string $taxonomy
     *
     * @return bool
     */
    public function isTax(string $taxonomy): bool;

    /**
     * Check if term is in one of taxonomies by their identifier names.
     *
     * @param array $taxonomies Taxonomie(s) en correspondances.
     *
     * @return bool
     */
    public function taxIn(array $taxonomies): bool;
}