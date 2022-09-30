<?php

namespace src\Unit;

use Drupal\node\Entity\Node;
use Drupal\test_helpers\EntityStubFactory;
use Drupal\test_helpers_benefits\Controller\TestHelpersBenefitsController;
use Drupal\Tests\UnitTestCase;

/**
 * Class tests TestHelpersBenefitsController.
 *
 * @coversDefaultClass \Drupal\test_helpers_benefits\Controller\TestHelpersBenefitsController
 * @group test_helpers_benefits
 */
class TestHelpersBenefitsControllerClassicTest extends UnitTestCase {

  /**
   * @covers ::build
   */
  public function testBuild() {
    $entityStubFactory = new EntityStubFactory();
    $node1 = $entityStubFactory->create(Node::class, ['title' => 'Article 1']);
    $node1->save();
    $node2 = $entityStubFactory->create(Node::class, ['title' => 'Article 2']);
    $node2->save();

    \Drupal::service('entity.query.sql')
      ->stubAddExecuteFunction('node', 'AND', function () use ($node1, $node2) {
        // Check conditions here using Query::stubCheckConditionsMatch().
        return [$node1->id(), $node2->id()];
      }
    );

    $controller = new TestHelpersBenefitsController();
    $result = $controller->build();

    $this->assertEquals('Article 1 (1)', $result['#items'][0]->getText());
    $this->assertEquals('Article 2 (2)', $result['#items'][1]->getText());
  }

}
