<?php

/**
 * @file
 * Contains \Drupal\commerce_cart\Form\CartSettingsForm.
 */

namespace Drupal\commerce_cart\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * General configuration form for the shopping cart.
 */
class CartSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'commerce_cart_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['commerce_cart.settings',];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get all settings
    $config = $this->configFactory->get('commerce_cart.settings');

    $form['cart_page'] = array(
      '#type' => 'fieldset',
      '#title' => t('Cart page settings'),
    );
    // To do : build the options for Commerce Order Views that could be used
    // as Shopping cart block.
    $options = array(
      'commerce_cart_form' => $this->t('Shopping cart form (default)'),
    );
    $form['cart_page']['view'] = array(
      '#type' => 'select',
      '#title' => $this->t('Shopping cart view to be used'),
      '#options' => $options,
      '#default_value' => $config->get('cart_page.view'),
      '#description' => $this->t("Select the order view you want to use for Shopping cart page."),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get config factory.
    $config = $this->configFactory->getEditable('commerce_cart.settings');
    $config->set('cart_page.view',  $form_state->getValue('view'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
