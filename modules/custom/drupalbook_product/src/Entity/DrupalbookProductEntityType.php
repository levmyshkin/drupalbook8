<?php

namespace Drupal\drupalbook_product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Product type entity.
 *
 * @ConfigEntityType(
 *   id = "drupalbook_product_entity_type",
 *   label = @Translation("Product type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\drupalbook_product\DrupalbookProductEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityTypeForm",
 *       "edit" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityTypeForm",
 *       "delete" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\drupalbook_product\DrupalbookProductEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "drupalbook_product_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "drupalbook_product_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/drupalbook_product_entity_type/{drupalbook_product_entity_type}",
 *     "add-form" = "/admin/structure/drupalbook_product_entity_type/add",
 *     "edit-form" = "/admin/structure/drupalbook_product_entity_type/{drupalbook_product_entity_type}/edit",
 *     "delete-form" = "/admin/structure/drupalbook_product_entity_type/{drupalbook_product_entity_type}/delete",
 *     "collection" = "/admin/structure/drupalbook_product_entity_type"
 *   }
 * )
 */
class DrupalbookProductEntityType extends ConfigEntityBundleBase implements DrupalbookProductEntityTypeInterface {

  /**
   * The Product type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Product type label.
   *
   * @var string
   */
  protected $label;

}
