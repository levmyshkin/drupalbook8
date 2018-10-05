<?php

namespace Drupal\drupalbook\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a button subscribe to newsletter.
 *
 * @Block(
 *   id = "drupalbook_subsribe_form_button",
 *   admin_label = @Translation("Subscribe to Newsletter"),
 * )
 */
class SubscribeFormButton extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $text = '<a href="/multistep-form" class="use-ajax" data-dialog-type="modal">Subscribe</a>';

    return [
      '#markup' => $text,
      '#attached' => array(
        'library' => array(
          'core/drupal.dialog.ajax',
          'core/jquery.form',
        ),
      ),
    ];
  }

}