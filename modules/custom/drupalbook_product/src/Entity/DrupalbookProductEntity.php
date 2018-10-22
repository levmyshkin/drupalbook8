<?php

namespace Drupal\drupalbook_product\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Product entity.
 *
 * @ingroup drupalbook_product
 *
 * @ContentEntityType(
 *   id = "drupalbook_product_entity",
 *   label = @Translation("Product"),
 *   bundle_label = @Translation("Product type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\drupalbook_product\DrupalbookProductEntityListBuilder",
 *     "views_data" = "Drupal\drupalbook_product\Entity\DrupalbookProductEntityViewsData",
 *     "translation" = "Drupal\drupalbook_product\DrupalbookProductEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityForm",
 *       "add" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityForm",
 *       "edit" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityForm",
 *       "delete" = "Drupal\drupalbook_product\Form\DrupalbookProductEntityDeleteForm",
 *     },
 *     "access" = "Drupal\drupalbook_product\DrupalbookProductEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\drupalbook_product\DrupalbookProductEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "drupalbook_product_entity",
 *   data_table = "drupalbook_product_entity_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer product entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/drupalbook_product_entity/{drupalbook_product_entity}",
 *     "add-page" = "/admin/structure/drupalbook_product_entity/add",
 *     "add-form" = "/admin/structure/drupalbook_product_entity/add/{drupalbook_product_entity_type}",
 *     "edit-form" = "/admin/structure/drupalbook_product_entity/{drupalbook_product_entity}/edit",
 *     "delete-form" = "/admin/structure/drupalbook_product_entity/{drupalbook_product_entity}/delete",
 *     "collection" = "/admin/structure/drupalbook_product_entity",
 *   },
 *   bundle_entity_type = "drupalbook_product_entity_type",
 *   field_ui_base_route = "entity.drupalbook_product_entity_type.edit_form"
 * )
 */
class DrupalbookProductEntity extends ContentEntityBase implements DrupalbookProductEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Product entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Product entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Product is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
