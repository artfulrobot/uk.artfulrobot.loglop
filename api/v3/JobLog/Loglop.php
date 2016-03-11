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

  // Load setting.
  $result = civicrm_api3('Setting', 'get', array(
    'sequential' => 1,
    'return' => "loglop_job_log_age",
  ));
  $loglop_job_log_age = isset($result['values'][0]['loglop_job_log_age']) ? $result['values'][0]['loglop_job_log_age'] : null;
  // Check it's something valid, otherwise the strtotime might mess up and give
  // today's date which would delete all logs :-/
  if (!in_array($loglop_job_log_age, ['', '2 years', '1 year', '6 months', '1 month', '1 day'])) {
    throw new API_Exception("The cut-off date for loglop is not one of the allowed options. Please reconfigure at /civicrm/admin/loglop");
  }
  if (!$loglop_job_log_age) {
    // disabled.
    return civicrm_api3_create_success();
  }

  // one year ago @todo allow changing this.
  $ages_ago = date('Y-m-d', strtotime("today - $loglop_job_log_age"));

  $entries_to_delete = (int) civicrm_api3('JobLog', 'getcount', array(
    'run_time' => array('<' => $ages_ago),
  ));
  if ($entries_to_delete == 0) {
    // Nothing to do.
    return civicrm_api3_create_success('Nothing to do.');
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
  return civicrm_api3_create_success("Deleted $entries_to_delete log entries that were older than $loglop_job_log_age");
}

