<?php

namespace Drupal\pcx_rates;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Commission rate entity.
 *
 * @see \Drupal\pcx_rates\Entity\CommissionRate.
 */
class CommissionRateAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\pcx_rates\Entity\CommissionRateInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished commission rate entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published commission rate entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit commission rate entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete commission rate entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add commission rate entities');
  }

}
