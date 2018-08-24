<?php

namespace Civi\Api4\Service\Spec\Provider;

use Civi\Api4\Service\Spec\RequestSpec;

class ContactCreationSpecProvider implements SpecProviderInterface {

  /**
   * @param RequestSpec $spec
   */
  public function modifySpec(RequestSpec $spec) {
    $spec->getFieldByName('contact_type')
      ->setRequired(TRUE)
      ->setDefaultValue('Individual');

    $spec->getFieldByName('first_name')->setRequiredIf('$contact_type eq \'Individual\' && !$email');
    $spec->getFieldByName('last_name')->setRequiredIf('$contact_type eq \'Individual\' && !$email');
    $spec->getFieldByName('organization_name')->setRequiredIf('$contact_type eq \'Organization\' && !$email');
    $spec->getFieldByName('household_name')->setRequiredIf('$contact_type eq \'Household\' && !$email');

    $spec->getFieldByName('is_opt_out')->setRequired(FALSE);
    $spec->getFieldByName('is_deleted')->setRequired(FALSE);

  }

  /**
   * @param string $entity
   * @param string $action
   *
   * @return bool
   */
  public function applies($entity, $action) {
    return $entity === 'Contact' && $action === 'create';
  }

}
