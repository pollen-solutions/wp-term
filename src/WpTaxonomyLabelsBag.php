<?php

declare(strict_types=1);

namespace Pollen\WpTerm;

use Pollen\Translation\LabelsBag;

/**
 * @see https://developer.wordpress.org/reference/functions/get_taxonomy_labels/
 */
class WpTaxonomyLabelsBag extends LabelsBag
{
    /**
     * @inheritDoc
     */
    public function parse(): void
    {
        $this->set(
            [
                'name'                       => $this->plural(true),
                'singular_name'              => $this->singular(true),
                'search_items'               => !$this->gender()
                    ? sprintf('Rechercher un %s', $this->singular())
                    : sprintf('Rechercher une %s', $this->singular()),
                'popular_items'              => sprintf('%s populaires', $this->plural(true)),
                'all_items'                  => !$this->gender()
                    ? sprintf('Tous les %s', $this->plural())
                    : sprintf('Toutes les %s', $this->plural()),
                'parent_item'                => sprintf('%s parent', $this->singular(true)),
                'parent_item_colon'          => sprintf('%s parent', $this->singular(true)),
                'edit_item'                  => sprintf('Éditer %s', $this->singularDefinite()),
                'view_item'                  => !$this->gender()
                    ? sprintf('Voir cet %s', $this->singular())
                    : sprintf('Voir cette %s', $this->singular()),
                'update_item'                => !$this->gender()
                    ? sprintf('Mettre à jour ce %s', $this->singular())
                    : sprintf('Mettre à jour cette %s', $this->singular()),
                'add_new_item'               => !$this->gender()
                    ? sprintf('Ajouter un %s', $this->singular())
                    : sprintf('Ajouter une %s', $this->singular()),
                'new_item_name'              => !$this->gender()
                    ? sprintf('Créer un %s', $this->singular())
                    : sprintf('Créer une %s', $this->singular()),
                'separate_items_with_commas' => sprintf('Séparer les %s par une virgule', $this->plural()),
                'add_or_remove_items'        => sprintf('Ajouter ou supprimer des %s', $this->plural()),
                'choose_from_most_used'      => !$this->gender()
                    ? sprintf('Choisir parmi les %s les plus utilisés', $this->plural())
                    : sprintf('Choisir parmi les %s les plus utilisées', $this->plural()),
                'not_found'                  => !$this->gender()
                    ? sprintf('Aucun %s trouvé', $this->singular(true))
                    : sprintf('Aucune %s trouvée', $this->singular(true)),
                /**  */
                'menu_name'                  => $this->plural(true),
            ]
        );
    }
}