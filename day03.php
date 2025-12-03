<?php

echo "Part 1 sample expected: 357 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 17155 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: xxx actual:" . compute2(sample()) . "\n";
//echo "Part 2 actual expected: xxx actual: " . compute(input()) . "\n";

function compute(string $input): string {
    $banks = explode("\n", $input);

    $jolts = 0;
    foreach ($banks as $bank) {
        $batteries = str_split($bank);

        $clone = $batteries;
        $clone = array_splice($clone, 0, -1);
        $max = max($clone);
        $index_first = array_search($max, $clone);

        $clone = $batteries;
        $clone = array_splice($clone, 0, -1);
        $clone = $batteries;
        $batteries_second = array_splice($clone, $index_first + 1);

        $max = max($batteries_second);
        $index_second = array_search($max, $batteries_second);

        $jolts += (int)($batteries[$index_first] . $batteries[$index_first + 1 + $index_second]);
    }

    return $jolts;
}


function compute2(string $input): string {
    $banks = explode("\n", $input);

    $jolts = 0;

    foreach ($banks as $bank) {
        $batteries = str_split($bank);


    }

    return $jolts;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
