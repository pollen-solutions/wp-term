<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\ParamsBag;
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
class WpTermQuery extends ParamsBag implements WpTermQueryInterface
{
    /**
     * List of built-in classe names by taxonomy.
     * @var array<string, string>
     */
    protected static array $builtInClasses = [];

    /**
     * List of defaults query request arguments.
     * @var array
     */
    protected static array $defaultArgs = [];

    /**
     * Fallback class name.
     * @var string|null
     */
    protected static ?string $fallbackClass = null;

    /**
     * Related taxonomy name identifier.
     * @var string
     */
    protected static string $taxonomy = '';

    /**
     * Hide empty indicator.
     * @var bool
     */
    protected static bool $hideEmpty = false;

    /**
     * Related WordPress Term object.
     * @var WP_Term|null
     */
    protected ?WP_Term $wpTerm = null;

    /**
     * @param WP_Term|null $wp_term
     *
     * @return void
     */
    public function __construct(?WP_Term $wp_term = null)
    {
        if ($this->wpTerm = $wp_term instanceof WP_Term ? $wp_term : null) {
            parent::__construct($this->wpTerm->to_array());
        }
    }

    /**
     * @inheritDoc
     */
    public static function build(object $wp_term): ?WpTermQueryInterface
    {
        if (!$wp_term instanceof WP_Term) {
            return null;
        }

        $classes = self::$builtInClasses;
        $taxonomy = $wp_term->taxonomy;

        $class = $classes[$taxonomy] ?? (self::$fallbackClass ?: static::class);

        return class_exists($class) ? new $class($wp_term) : new static($wp_term);
    }

    /**
     * @inheritDoc
     */
    public static function create($termDef = null, ...$args): ?WpTermQueryInterface
    {
        if (is_numeric($termDef)) {
            return static::createFromId((int)$termDef);
        }
        if (is_string($termDef)) {
            return static::createFromSlug($termDef, ...$args);
        }
        if ($termDef instanceof WP_Term) {
            return static::build($termDef);
        }
        if ($termDef instanceof WpTermQueryInterface) {
            return static::createFromId($termDef->getId());
        }
        if (is_null($termDef) && ($instance = static::createFromGlobal())) {
            if (($taxonomy = static::$taxonomy)) {
                return $instance->getTaxonomy() === $taxonomy ? $instance : null;
            }
            return $instance;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function createFromGlobal(): ?WpTermQueryInterface
    {
        global $wp_query;

        return $wp_query->is_tax() || $wp_query->is_category() || $wp_query->is_tag()
            ? self::createFromId($wp_query->queried_object_id) : null;
    }

    /**
     * @inheritDoc
     */
    public static function createFromId(int $term_id): ?WpTermQueryInterface
    {
        if ($term_id && ($wp_term = get_term($term_id)) && ($wp_term instanceof WP_Term)) {
            if (!$instance = static::build($wp_term)) {
                return null;
            }
            return $instance::is($instance) ? $instance : null;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function createFromSlug(string $term_slug, ?string $taxonomy = null): ?WpTermQueryInterface
    {
        $wp_term = get_term_by('slug', $term_slug, $taxonomy ?? static::$taxonomy);

        return ($wp_term instanceof WP_Term) ? static::createFromId($wp_term->term_id ?? 0) : null;
    }

    /**
     * @inheritDoc
     */
    public static function fetch($query): array
    {
        if (is_array($query)) {
            return static::fetchFromArgs($query);
        }
        if ($query instanceof WP_Term_Query) {
            return static::fetchFromWpTermQuery($query);
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function fetchFromArgs(array $args = []): array
    {
        return static::fetchFromWpTermQuery(new WP_Term_Query(static::parseQueryArgs($args)));
    }

    /**
     * @inheritDoc
     */
    public static function fetchFromIds(array $ids): array
    {
        return static::fetchFromWpTermQuery(new WP_Term_Query(static::parseQueryArgs(['include' => $ids])));
    }

    /**
     * @inheritDoc
     */
    public static function fetchFromWpTermQuery(WP_Term_Query $wp_term_query): array
    {
        $terms = $wp_term_query->get_terms();

        $results = [];
        foreach ($terms as $wp_term) {
            if ($instance = static::createFromId($wp_term->term_id)) {
                if (($taxonomy = static::$taxonomy) && ($taxonomy !== 'any')) {
                    if ($instance->isTax($taxonomy)) {
                        $results[] = $instance;
                    }
                } else {
                    $results[] = $instance;
                }
            }
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    public static function is($instance): bool
    {
        return $instance instanceof static &&
            (!(($taxonomy = static::$taxonomy) && ($taxonomy !== 'any')) || $instance->isTax($taxonomy));
    }

    /**
     * @inheritDoc
     */
    public static function parseQueryArgs(array $args = []): array
    {
        if ($taxonomy = static::$taxonomy) {
            $args['taxonomy'] = $taxonomy;
        }

        if (!isset($args['hide_empty'])) {
            $args['hide_empty'] = static::$hideEmpty;
        }

        return array_merge(static::$defaultArgs, $args);
    }

    /**
     * @inheritDoc
     */
    public static function setBuiltInClass(string $taxonomy, string $classname): void
    {
        if ($taxonomy === 'any') {
            self::setFallbackClass($classname);
        } else {
            self::$builtInClasses[$taxonomy] = $classname;
        }
    }

    /**
     * @inheritDoc
     */
    public static function setDefaultArgs(array $args): void
    {
        self::$defaultArgs = $args;
    }

    /**
     * @inheritDoc
     */
    public static function setFallbackClass(string $classname): void
    {
        self::$fallbackClass = $classname;
    }

    /**
     * @inheritDoc
     */
    public static function setTaxonomy(string $taxonomy): void
    {
        static::$taxonomy = $taxonomy;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return (string)$this->get('description');
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return (int)$this->get('term_id', 0);
    }

    /**
     * @inheritDoc
     */
    public function getMeta(string $meta_key, bool $single = false, $default = null)
    {
        return get_term_meta($this->getId(), $meta_key, $single) ?: $default;
    }

    /**
     * @inheritDoc
     */
    public function getMetaMulti(string $meta_key, $default = null)
    {
        return $this->getMeta($meta_key, false, $default);
    }

    /**
     * @inheritDoc
     */
    public function getMetaSingle(string $meta_key, $default = null)
    {
        return $this->getMeta($meta_key, true, $default);
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return (string)$this->get('name');
    }

    /**
     * @inheritDoc
     */
    public function getPermalink(): string
    {
        return get_term_link($this->getWpTerm());
    }

    /**
     * @inheritDoc
     */
    public function getSlug(): string
    {
        return (string)$this->get('slug');
    }

    /**
     * @inheritDoc
     */
    public function getTaxonomy(): string
    {
        return (string)$this->get('taxonomy');
    }

    /**
     * @inheritDoc
     */
    public function getWpTerm(): WP_Term
    {
        return $this->wpTerm;
    }

    /**
     * @inheritDoc
     */
    public function isTax(string $taxonomy): bool
    {
        return $this->getTaxonomy() === $taxonomy;
    }

    /**
     * @inheritDoc
     */
    public function taxIn(array $taxonomies): bool
    {
        return in_array($this->getTaxonomy(), $taxonomies, true);
    }
}