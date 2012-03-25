<?php

require_once(dirname(__FILE__) . '/../ClassWhichIsNotFullyTested.class.php');
ClassWhichIsNotFullyTested::methodWhichWillBeCalled();

$fixtures_folder = dirname(dirname(__FILE__)) . '/';
$base_directory = dirname(dirname($fixtures_folder));
$coverage_file_path = $fixtures_folder . 'raw_coverage_file.txt';
echo $coverage_file_path;
/*
 * Test with whatever code coverage:
 */
require_once(dirname(__FILE__) . '/../../../NaithCliReport.class.php');
$report = new NaithCliReport(array(
    'coverage_file_path' => $coverage_file_path,
    'excluded_paths' => array(
        dirname(__FILE__)
    ),
    'minimum_code_coverage' => 101, // should not be possible, so always failing! :)
    'base_directory' => $base_directory
));
$report->makeCoverageOverview();
$report->makeUntestedCodeOverview();

