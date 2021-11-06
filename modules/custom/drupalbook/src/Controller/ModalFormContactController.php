<?php

namespace Drupal\drupalbook\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;

/**
 * ModalFormContactController class.
 */
class ModalFormContactController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * ModalFormContactController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   *   The form builder.
   */
  public function __construct(FormBuilder $form_builder) {
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Callback for modal form.
   */
  public function openModalForm() {
    $response = new AjaxResponse();
    $modal_form = $this->formBuilder->getForm('Drupal\drupalbook\Form\ModalForm');
    $enquiry_title = $this->t("Send an enquiry to @business_name", ['@business_name' => $modal_form['business_name']['#value']]);
    $response->addCommand(new OpenModalDialogCommand($enquiry_title, $modal_form));

    return $response;
  }

}
