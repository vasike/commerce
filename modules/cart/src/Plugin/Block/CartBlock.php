<?php

/**
 * @file
 * Contains \Drupal\commerce_cart\Plugin\Block\CartBlock.
 */

namespace Drupal\commerce_cart\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Shopping cart block.
 *
 * @Block(
 *   id = "cart",
 *   admin_label = @Translation("Shopping Cart"),
 *   category = @Translation("Commerce")
 * )
 */
class CartBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'cart_view' => "commerce_cart_block",
    );
  }

  /**
   * {@inheritdoc}
   */
  function blockForm($form, FormStateInterface $form_state) {
    // To do : build the options for Commerce Order Views that could be used
    // as Shopping cart block
    $options = array(
      'commerce_cart_block' => $this->t('Shopping cart block (default)'),
    );
    $form['cart_view'] = array(
      '#type' => 'select',
      '#title' => $this->t('Shopping cart view to be used'),
      '#options' => $options,
      '#default_value' => $this->configuration['cart_view'],
      '#description' => $this->t("Select the order view you want to use for Shopping cart block."),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['cart_view'] = $form_state->getValue('cart_view');
  }

  /**
   * Display a list of line items added to cart.
   *
   * @return array
   *   A view with cart form content.
   */
  public function build() {
    // Get the Cart Order id.
    $cart_order_id = 1;
    // Use the block cart settings for the View to bse used for this block.
    return views_embed_view($this->configuration['cart_view'], 'default', array($cart_order_id));
  }

}
