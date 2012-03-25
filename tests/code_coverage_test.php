<?php

error_reporting(E_ALL | E_STRICT);

$naith_executable = dirname(dirname(__FILE__)) . '/naith.php';
$fixtures_folder = dirname(__FILE__) . '/code_coverage_test/';
$base_directory = dirname(dirname($fixtures_folder));
$coverage_file_path = $fixtures_folder . 'raw_coverage_file.txt';
$test_test_file = $fixtures_folder . 'tests/not_fully_tested.php';
$test_file_with_exception = $fixtures_folder . 'tests/test_with_exception.php';
$test_file_with_assert_exception = $fixtures_folder . 'tests/test_assert_exception.php';
$test_file_with_assert_exception_without_exception = $fixtures_folder . 'tests/test_assert_exception_without_exception.php';
$test_file_with_warnings = $fixtures_folder . 'tests/test_with_warnings.php';
$internal_code_coverage_runner_file = $fixtures_folder . 'internal_code_coverage_runner.php';
$test_file_with_failing_assertion = $fixtures_folder . 'tests/test_failing_assertion.php';
chdir(dirname($test_test_file));
file_put_contents($coverage_file_path, '');

if (file_exists($coverage_file_path))
{
    unlink($coverage_file_path);
}

ob_start();
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_file_with_exception . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_test_file . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_file_with_assert_exception . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_file_with_assert_exception_without_exception . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_file_with_warnings . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $base_directory . '/naith.php run-test --test_file ' . $test_file_with_failing_assertion . ' --coverage_file_path ' . $coverage_file_path);
echo shell_exec('php ' . $internal_code_coverage_runner_file . ' ' . $coverage_file_path);
assert(file_exists($coverage_file_path));

ob_get_clean();
echo shell_exec('php /Volumes/development/workspaces/naith/naith.php make-coverage-overview --coverage_file_path ' . $coverage_file_path . ' --base_directory ' . $base_directory . ' --excluded_path ' . dirname(__FILE__));
$untested_code = shell_exec('php /Volumes/development/workspaces/naith/naith.php make-untested-code-overview --coverage_file_path ' . $coverage_file_path . ' --base_directory ' . $base_directory . ' --excluded_path ' . dirname(__FILE__));
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

assert(count($really_untested_lines) == 0);

echo " ... ok, only unimportant lines not tested!" . PHP_EOL;
