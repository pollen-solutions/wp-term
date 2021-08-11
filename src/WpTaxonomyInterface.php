<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ParamsBagAwareTraitInterface;
use Pollen\Translation\LabelsBagInterface;
use WP_Taxonomy;
use WP_REST_Controller;

/**
 * @property-read string $label
 * @property-read object $labels
 * @property-read string $description
 * @property-read bool $public
 * @property-read bool $hierarchical
 * @property-read bool $exclude_from_search
 * @property-read bool $publicly_queryable
 * @property-read bool $show_ui
 * @property-read bool $show_in_menu
 * @property-read bool $show_in_nav_menus
 * @property-read bool $show_in_admin_bar
 * @property-read int $menu_position
 * @property-read string $menu_icon
 * @property-read string $capability_type
 * @property-read bool $map_meta_cap
 * @property-read string $register_meta_box_cb
 * @property-read array $taxonomies
 * @property-read bool|string $has_archive
 * @property-read string|bool $query_var
 * @property-read bool $can_export
 * @property-read bool $delete_with_user
 * @property-read bool $_builtin
 * @property-read string $_edit_link
 * @property-read object $cap
 * @property-read array|false $rewrite
 * @property-read array|bool $supports
 * @property-read bool $show_in_rest
 * @property-read string|bool $rest_base
 * @property-read string|bool $rest_controller_class
 * @property-read WP_REST_Controller $rest_controller
 */
interface WpTaxonomyInterface extends BootableTraitInterface, ParamsBagAwareTraitInterface, WpTermProxyInterface
{
    /**
     * Booting.
     *
     * @return static
     */
    public function boot(): WpTaxonomyInterface;

    /**
     * Get identifier name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Retrieve LabelBag instance|Get label string.
     *
     * @param string|null $key
     * @see https://codex.wordpress.org/Function_Reference/register_post_type
     * plural|singular|name|singular_name|add_new|add_new_item|edit_item|new_item|view_item|view_items|search_items|
     * not_found|not_found_in_trash|parent_item_colon|all_items|archives|attributes|insert_into_item|
     * uploaded_to_this_item|featured_image|set_featured_image|remove_featured_image|use_featured_image|menu_name|
     * filter_items_list|items_list_navigation|items_list|name_admin_bar
     * @param string $default
     *
     * @return LabelsBagInterface|WpTaxonomyLabelsBag|string
     */
    public function label(?string $key = null, string $default = '');

    /**
     * Set WP_Taxonomy related object.
     *
     * @param WP_Taxonomy $taxonomy
     *
     * @return static
     */
    public function setWpTaxonomy(WP_Taxonomy $taxonomy): WpTaxonomyInterface;
}