<?php

namespace Drupal\drupalbook\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class DrupalbookSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalbook_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'drupalbook.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('drupalbook.settings');

    $form['drupalbook_api_key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('drupalbook_api_key'),
    );

    $form['drupalbook_api_client_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('API Client ID'),
      '#default_value' => $config->get('drupalbook_api_client_id'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->configFactory->getEditable('drupalbook.settings')
      // Set the submitted configuration setting
      ->set('drupalbook_api_key', $form_state->getValue('drupalbook_api_key'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('drupalbook_api_client_id', $form_state->getValue('drupalbook_api_client_id'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}