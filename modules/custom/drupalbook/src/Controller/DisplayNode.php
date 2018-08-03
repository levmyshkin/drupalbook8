<?php

/**
 * @file
 * Contains \Drupal\drupalbook\Controller\DisplayNode.
 */

namespace Drupal\drupalbook\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;

/**
 * Provides route responses for the DrupalBook module.
 */
class DisplayNode {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content(NodeInterface $node) {
    $element = array(
      '#markup' => $node->body->value,
    );
    return $element;
  }

  /**
   * Checks access for this controller.
   */
  public function access(NodeInterface $node) {
    $user = \Drupal::currentUser();
    if ($node->getType() == 'article' && !in_array('authenticated', $user->getRoles())) {
      return AccessResult::forbidden();
    }
    return AccessResult::allowed();
  }

  /**
   * Returns a page title.
   */
  public function getTitle(NodeInterface $node) {
    return $node->getTitle();
  }

}