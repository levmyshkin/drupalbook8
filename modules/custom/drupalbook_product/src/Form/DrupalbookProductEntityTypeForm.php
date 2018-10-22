<?php

namespace Drupal\drupalbook_product\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DrupalbookProductEntityTypeForm.
 */
class DrupalbookProductEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $drupalbook_product_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $drupalbook_product_entity_type->label(),
      '#description' => $this->t("Label for the Product type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $drupalbook_product_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\drupalbook_product\Entity\DrupalbookProductEntityType::load',
      ],
      '#disabled' => !$drupalbook_product_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $drupalbook_product_entity_type = $this->entity;
    $status = $drupalbook_product_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Product type.', [
          '%label' => $drupalbook_product_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Product type.', [
          '%label' => $drupalbook_product_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($drupalbook_product_entity_type->toUrl('collection'));
  }

}
