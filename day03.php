<?php

echo "Part 1 sample expected: 357 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 17155 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 3121910778619 actual:" . compute2(sample()) . "\n";
echo "Part 2 actual expected: 169685670469164 actual: " . compute2(input()) . "\n";

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

        $digits = 12;
        $pack = '';

        while ($digits > 0) {
            $splice = ($digits - 1) * -1;
            $splice = $splice === 0 ? count($batteries) : $splice;
            $remaining_banks = array_slice($batteries, 0, $splice);
//            var_dump('b' . implode($batteries));
//            var_dump('r' . implode($remaining_banks));
//            var_dump('d' . $digits);
//            var_dump('s' . $splice);
            if (empty($remaining_banks)) {
                $pack .= $batteries[0];
                break;
            }
            $max = max($remaining_banks);
            $index = array_search($max, $remaining_banks);
            $pack .= $remaining_banks[$index];
            $batteries = array_slice($batteries, $index + 1);
            $digits -= 1;
        }

        $jolts += (int)$pack;
    }

    return $jolts;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
