<?php

xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$base_directory = dirname(__FILE__) . '/../../';

require_once($base_directory . 'NaithCliRunner.class.php');

$coverage_file_path = dirname(__FILE__) . '/raw_coverage_file.txt';
$tests_report_path = dirname(__FILE__) . '/tests_report_raw.txt';
$junit_xml_path = dirname(__FILE__) . '/junit.xml';

register_shutdown_function('NaithCliRunner::onShutdown');

NaithCliRunner::setCoverageFilePath($coverage_file_path);
NaithCliRunner::setTestsReportPath($tests_report_path, __FILE__);
NaithCliRunner::bootstrapForTest();

assert(true);