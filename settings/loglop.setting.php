<?php
return array (
  'loglop_job_log_age' => array(
    'group_name' => 'Log Lop Settings',
    'group' => 'loglop',
    'name' => 'loglop_job_log_age',
    'type' => 'String',
    'title' => 'Delete job logs older than',
    'html_type' => 'select',
    'html_attributes' => array(
        ''         => ts('Do not delete any logs'),
        '2 years'  => ts('2 Years'),
        '1 year'   => ts('1 Year'),
        '6 months' => ts('6 Months'),
        '1 month'  => ts('1 Month'),
        '1 day'    => ts('1 Day'),
      ),
    'quick_form_type' => 'Element',
    'default' => '2 years',
    'add' => '4.6',
    'is_domain' => '1',
    'is_contact' => 0,
    'description' => null,
    'help_text' => null,
  ),
);
