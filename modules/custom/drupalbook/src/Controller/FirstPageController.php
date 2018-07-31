<?php

/**
 * @file
 * Contains \Drupal\drupalbook\Controller\FirstPageController.
 */

namespace Drupal\drupalbook\Controller;

/**
 * Provides route responses for the DrupalBook module.
 */
class FirstPageController {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content() {
    $element = array(
      '#markup' => 'Hello World!',
    );
    return $element;
  }

  /**
   * Returns a private page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function privateContent() {
    $element = array(
      '#markup' => 'Private content',
    );
    return $element;
  }

}