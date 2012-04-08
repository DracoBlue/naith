<?php

error_reporting(E_ALL | E_STRICT);

$naith_executable = dirname(dirname(__FILE__)) . '/naith.php';
$fixtures_folder = dirname(__FILE__) . '/code_coverage_test/';
$base_directory = dirname(dirname($fixtures_folder));
$coverage_file_path = $fixtures_folder . 'raw_coverage_file.txt';
$tests_report_path = $fixtures_folder . 'tests_report_raw.txt';
$junit_xml_path = $fixtures_folder . 'junit.xml';
$internal_code_coverage_runner_file = $fixtures_folder . 'internal_code_coverage_runner.php';
$internal_code_coverage_runner_file2 = $fixtures_folder . 'internal_code_coverage_runner_part2.php';
chdir($fixtures_folder . 'tests/');

if (file_exists($coverage_file_path))
{
    unlink($coverage_file_path);
}

if (file_exists($junit_xml_path))
{
    unlink($junit_xml_path);
}

if (file_exists($tests_report_path))
{
    unlink($tests_report_path);
}

file_put_contents($coverage_file_path, '');
file_put_contents($tests_report_path, '');

ob_start();

$test_files = array(
    'not_fully_tested.php',
    'test_with_exception.php',
    'test_assert_exception.php',
    'test_assert_exception_without_exception.php',
    'test_with_warnings.php',
    'test_failing_assertion.php',
);

foreach ($test_files as $test_file)
{
    echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file "' . $fixtures_folder . 'tests/' . $test_file . '" --coverage_file_path ' . $coverage_file_path . ' --tests_report_path ' . $tests_report_path);
}

echo shell_exec('php ' . $internal_code_coverage_runner_file . ' ' . $coverage_file_path);
echo shell_exec('php ' . $internal_code_coverage_runner_file2 . ' ' . $coverage_file_path);
ob_get_clean();

assert(file_exists($coverage_file_path));
assert(file_exists($tests_report_path));
assert(file_exists($junit_xml_path));

echo shell_exec('php ' . $naith_executable . ' make-coverage-overview --coverage_file_path ' . $coverage_file_path . ' --base_directory ' . $base_directory . ' --excluded_path ' . dirname(__FILE__));
$untested_code = shell_exec('php ' . $naith_executable . ' make-untested-code-overview --coverage_file_path ' . $coverage_file_path . ' --base_directory ' . $base_directory . ' --excluded_path ' . dirname(__FILE__));

echo $untested_code;
$untested_lines = array_slice(explode(PHP_EOL, $untested_code), 4, -1);
$really_untested_lines = array();
foreach ($untested_lines as $untested_line)
{
    list($file_name, $code) = explode('>', $untested_line);
    if (trim($code) != '}')
    {
        $really_untested_lines[] = $untested_line;
    }    
}

unlink($coverage_file_path);
unlink($tests_report_path);
unlink($junit_xml_path);

assert(count($really_untested_lines) == 0);

echo " ... ok, only unimportant lines not tested!" . PHP_EOL;
