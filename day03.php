<?php

echo "Part 1 sample expected: 357 actual: " . compute2(sample(), 2) . "\n";
echo "Part 1 actual expected: 17155 actual: " . compute2(input(), 2) . "\n";
echo "Part 2 sample expected: 3121910778619 actual:" . compute2(sample(), 12) . "\n";
echo "Part 2 actual expected: 169685670469164 actual: " . compute2(input(), 12) . "\n";

function compute2(string $input, int $how_many = 2): string {
    $banks = explode("\n", $input);

    $jolts = 0;
    foreach ($banks as $bank) {
        $batteries = str_split($bank);

        $digits = $how_many;
        $pack = 0;

        while ($digits > 0) {
            $splice = ($digits - 1) * -1;
            $splice = $splice === 0 ? count($batteries) : $splice;
            $remaining_banks = array_slice($batteries, 0, $splice);

            $max = max($remaining_banks);
            $index = array_search($max, $remaining_banks);
            $pack = ($pack * 10) +  $remaining_banks[$index];
            $batteries = array_slice($batteries, $index + 1);
            $digits -= 1;
        }

        $jolts += $pack;
    }

    return $jolts;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
