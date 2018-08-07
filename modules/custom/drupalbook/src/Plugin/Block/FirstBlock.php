<?php

namespace Drupal\drupalbook\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "drupalbook_first_block_block",
 *   admin_label = @Translation("My first block"),
 * )
 */
class FirstBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['drupalbook_first_block_settings'])) {
      $text = $this->t('Hello @name in block!', ['@name' => $config['drupalbook_first_block_settings']]);
    }
    else {
      $text = $this->t('Hello World in block!');
    }

    return [
      '#markup' => $text,
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['drupalbook_first_block_settings'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => !empty($config['drupalbook_first_block_settings']) ? $config['drupalbook_first_block_settings'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['drupalbook_first_block_settings'] = $form_state->getValue('drupalbook_first_block_settings');
  }
}