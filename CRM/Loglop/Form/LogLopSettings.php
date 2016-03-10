<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Loglop_Form_LogLopSettings extends CRM_Admin_Form_Setting {

  // This is field => group, but I'm not sure what group is.
  // Having this seems to mean the value is saved into civicrm_setting table.
  protected $_settings = ['loglop_job_log_age' => 'loglop_job_log_age'];

  public function buildQuickForm() {

    $result = civicrm_api3('Setting', 'get', array(
      'sequential' => 1,
      'return' => "loglop_job_log_age",
    ));
    // Q. how to set the value in the form?
    // A. this seems to do it...
    $this->_defaultValues['loglop_job_log_age'] = isset($result['values'][0]['loglop_job_log_age']) ? $result['values'][0]['loglop_job_log_age'] : null;
    // add form elements
    $this->add(
      'select', // field type
      'loglop_job_log_age', // field name
      'Delete logs older than', // field label
      array(
        ''         => ts('Do not delete any logs'),
        '2 years'  => ts('2 Years'),
        '1 year'   => ts('1 Year'),
        '6 months' => ts('6 Months'),
        '1 month'  => ts('1 Month'),
        '1 day'    => ts('1 Day'),
      ),
      FALSE // is required - defaults to doing nothing.
    );
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', ['loglop_job_log_age']);
  }

  public function postProcess() {
    $values = $this->exportValues();
    // Write to settings.

    CRM_Core_Session::setStatus(ts('Log Lopping settings updated'));
    parent::postProcess();
  }
}
