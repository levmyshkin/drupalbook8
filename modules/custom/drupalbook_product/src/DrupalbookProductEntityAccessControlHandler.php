<?php

namespace Drupal\drupalbook_product;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Product entity.
 *
 * @see \Drupal\drupalbook_product\Entity\DrupalbookProductEntity.
 */
class DrupalbookProductEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\drupalbook_product\Entity\DrupalbookProductEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished product entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published product entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit product entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete product entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add product entities');
  }

}
