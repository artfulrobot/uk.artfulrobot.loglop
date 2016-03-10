<?php

/**
 * JobLog.Loglop API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_job_log_Loglop_spec(&$spec) {
  //$spec['magicword']['api.required'] = 1;
}

/**
 * JobLog.Loglop API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_job_log_Loglop($params) {
  //if (array_key_exists('magicword', $params) && $params['magicword'] == 'sesame') {
  // civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL, &$dao = NULL, $extraReturnValues = array()) {

  // one year ago @todo allow changing this.
  $ages_ago = date('Y-m-d', strtotime("today - 2 year"));

  $result = (int) civicrm_api3('JobLog', 'getcount', array(
    'run_time' => array('<' => $ages_ago),
  ));
  if ($result == 0) {
    // Nothing to do.
    return civicrm_api3_create_success();
  }
  // We need to do a bulk delete. CiviCRM's API does not let us do this. Too
  // dangerous. Quite sensible. Let's go for it!
  $sql = "DELETE FROM civicrm_job_log WHERE run_time < %1";
  $params = array(
    1 => array($ages_ago, 'String'),
  );
  $dao = CRM_Core_DAO::executeQuery($sql, $params);

  // @todo it would be nice to record how many records were deleted in the job
  // log but I haven't figured out how to do this.
  return civicrm_api3_create_success();
}

