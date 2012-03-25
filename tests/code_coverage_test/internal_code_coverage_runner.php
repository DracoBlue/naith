<?php

xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$base_directory = dirname(__FILE__) . '/../../';

require_once($base_directory . 'NaithCliRunner.class.php');
require_once($base_directory . 'NaithCliReport.class.php');


$coverage_file_path = dirname(__FILE__) . '/raw_coverage_file.txt';

register_shutdown_function('NaithCliRunner::onShutdown');

NaithCliRunner::setCoverageFilePath($coverage_file_path);
NaithCliRunner::bootstrapForTest();

$report = new NaithCliReport(array(
    'coverage_file_path' => $coverage_file_path,
    'excluded_paths' => array(
        dirname(__FILE__)
    ),
    'minimum_code_coverage' => 0,
    'base_directory' => $base_directory
));

$report->makeUntestedCodeOverview();
$report->makeCoverageOverview();