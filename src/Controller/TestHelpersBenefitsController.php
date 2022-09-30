<?php

namespace Drupal\test_helpers_benefits\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for TestHelpersBenefits routes.
 */
class TestHelpersBenefitsController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $articlesIds = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'article')
      ->sort('created', 'DESC')
      ->execute();

    $articles = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadMultiple($articlesIds);

    $articlesList = [];
    foreach($articles as $article) {
      $linkText = $article->label() . ' (' . $article->id() . ')';
      $articlesList[] = $article->toLink($linkText);
    }

    $build = [
        '#theme' => 'item_list',
        '#items' => $articlesList,
      ];

    return $build;
  }

}
