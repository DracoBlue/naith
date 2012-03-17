# naith

Naith is a small (~100 loc) php test runner and report generator for the command line.

## Usage

Executing `naith run` in a directory, will execute all tests within `tests/`
folder and requires the file `_before_naith.php` (if it's available).

If you want to to run your tests as soon as a file changes, just type
`naith run-constant`.

## License

This work is copyright by DracoBlue (<http://dracoblue.net>) and licensed under the terms of MIT License.