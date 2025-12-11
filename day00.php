<?php

echo "Part 1 sample expected: xxx actual: " . compute(sample()) . "\n";
//echo "Part 1 actual expected: xxx actual: " . compute(input()) . "\n";
//echo "Part 2 sample expected: xxx actual:" . compute(sample()) . "\n";
//echo "Part 2 actual expected: xxx actual: " . compute(input()) . "\n";

function compute(string $input): string {
    return 'foobar';
}

function sample(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
