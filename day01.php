<?php

echo "Part 1 sample expected: 3 actual: " . countRotationsEndingWithZero(sample()) . "\n";
echo "Part 1 actual expected: 999 actual: " . countRotationsEndingWithZero(input()) . "\n";
echo "Part 2 sample expected: 6: actual:" . countRotationsPassingZero(sample()) . "\n";
echo "Part 2 actual expected: 6099 actual: " . countRotationsPassingZero(input()) . "\n";

function countRotationsPassingZero(string $input) :string {
    $lines = explode("\n", $input);
    $dial_position = 50; // initial position

    $reached_zero = 0;

    foreach ($lines as $line) {
        $side = substr($line, 0, 1);
        $clicks = (int)substr($line, 1);

        $dial_position += ($clicks * ($side == 'L' ? -1 : 1));
        while ($dial_position > 99) {
            $dial_position = $dial_position - 100;
            $reached_zero++;
        }

        while ($dial_position < 0) {
            $dial_position = $dial_position + 100;
            $reached_zero++;
        }
    }
    return $reached_zero;
}

function countRotationsEndingWithZero(string $input) :string {
    $lines = explode("\n", $input);
    $dial_position = 50; // initial position

    $reached_zero = 0;

    foreach ($lines as $line) {
        $side = substr($line, 0, 1);
        $clicks = (int)substr($line, 1);

        $dial_position += ($clicks * ($side == 'L' ? -1 : 1));
        while ($dial_position > 99) {
            $dial_position = $dial_position - 100;
        }

        while ($dial_position < 0) {
            $dial_position = $dial_position + 100;
        }

        if ($dial_position == 0) {
            $reached_zero ++;
        }
    }
    return $reached_zero;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}

?>
