<?php

echo "Part 1 sample expected: 1227775554 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 53420042388 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 4174379265 actual:" . compute(sample(), is_part_2: true) . "\n";
echo "Part 2 actual expected: 69553832684 actual: " . compute(input(), is_part_2: true) . "\n";

function compute(string $input, bool $is_part_2 = false): string {
    $numeric_ranges = explode(",", $input);
    $numeric_ranges = array_map(fn(string $range) => explode('-', $range), $numeric_ranges);

    $sum_of_repeated_patterns = 0;
    foreach ($numeric_ranges as $range) {
        $start = (int)$range[0];
        $end = (int)$range[1];
        for($i = $start; $i <= $end; $i++) {
            if ($is_part_2 ? is_repeated_n_times_pattern($i) : is_repeated_2_times_pattern($i)) {
                $sum_of_repeated_patterns += $i;
            }
        }
    }

    return $sum_of_repeated_patterns;
}

//part 1, pattern repeated twice, 1212, 1111, 22, 12341234
function is_repeated_2_times_pattern(int $i): bool {
    return preg_match('/^(.+)\1$/', (string) $i) === 1;
}

//part 2, pattern repeated n times, part 1 + 121212, 111, 323232, 123123123123
function is_repeated_n_times_pattern(int $i): bool {
    return preg_match('/^(.+)\1+$/', (string) $i) === 1;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}

?>
