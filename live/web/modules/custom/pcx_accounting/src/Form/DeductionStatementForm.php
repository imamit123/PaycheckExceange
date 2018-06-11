<?php

namespace Drupal\pcx_accounting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Deduction Statement edit forms.
 *
 * @ingroup pcx_accounting
 */
class DeductionStatementForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\pcx_accounting\Entity\DeductionStatement */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Deduction Statement.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Deduction Statement.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.deduction_statement.canonical', ['deduction_statement' => $entity->id()]);
  }

}
