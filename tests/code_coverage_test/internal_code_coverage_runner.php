<?php

xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$base_directory = dirname(__FILE__) . '/../../';

require_once($base_directory . 'NaithCliRunner.class.php');
require_once($base_directory . 'NaithCliReport.class.php');
require_once($base_directory . 'NaithJunitReport.class.php');


$coverage_file_path = dirname(__FILE__) . '/raw_coverage_file.txt';
$tests_report_path = dirname(__FILE__) . '/tests_report_raw.txt';
$junit_xml_path = dirname(__FILE__) . '/junit.xml';

register_shutdown_function('NaithCliRunner::onShutdown');

$junit_report = new NaithJunitReport(array(
    'excluded_paths' => array(
        dirname(__FILE__) . '/tests/not_fully_tested.php'
    ),
    'tests_report_path' => $tests_report_path,
    'base_directory' => $base_directory
));
$junit_report->writeJunitXmlToFile($junit_xml_path);
echo file_get_contents($junit_xml_path);

NaithCliRunner::setCoverageFilePath($coverage_file_path);
NaithCliRunner::bootstrapForTest();

$report = new NaithCliReport(array(
    'coverage_file_path' => $coverage_file_path,
    'excluded_paths' => array(
        dirname(__FILE__)
    ),
    'minimum_code_coverage' => 0, /* test with 0 minimum, always works! */
    'base_directory' => $base_directory
));
$report->makeUntestedCodeOverview();
$report->makeCoverageOverview();

$report = new NaithCliReport(array(
    'coverage_file_path' => $coverage_file_path,
    'excluded_paths' => array(
        dirname(__FILE__)
    ),
    'minimum_code_coverage' => 120, /* test with 120 minimum, will NEVER work!  -> exit code 1, this is what we want! */
    'base_directory' => $base_directory
));

$report->makeUntestedCodeOverview();
$report->makeCoverageOverview();