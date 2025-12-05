<?php

echo "Part 1 sample expected: 3 actual: " . compute(sample())[0] . "\n";
echo "Part 1 actual expected: 798 actual: " . compute(input())[0] . "\n";
echo "Part 2 sample expected: 14 actual:" . compute(sample())[1] . "\n";
echo "Part 2 actual expected: 366181852921027 actual: " . compute(input())[1] . "\n";

function compute(string $input): array {

    [$fresh_ingredients_ranges, $available_ingredients] = preg_split("/\n\s*\n/", $input);

    $available_ingredients = explode("\n", $available_ingredients);
    $fresh_ingredients_ranges = explode("\n", $fresh_ingredients_ranges);

    $fresh_ingredients_map = [];
    foreach ($fresh_ingredients_ranges as $range) {
        [$from, $to] = explode("-", $range);
        $fresh_ingredients_map[$from] = max($to, @$fresh_ingredients_map[$from]);
    }

    $fresh_count = 0;
    foreach ($available_ingredients as $ingredient) {
        $is_fresh = false;
        foreach ($fresh_ingredients_map as $from => $to) {
            if ($ingredient >= $from && $ingredient <= $to) {
                $is_fresh = true;
            }
        }

        if ($is_fresh) $fresh_count++;
    }

    ksort($fresh_ingredients_map);
    $max_fresh_id = -1;
    $total_fresh_count = 0;

    foreach ($fresh_ingredients_map as $from => $to) {
        $from = max($from, $max_fresh_id + 1);
        $total_fresh_slot = max(0, $to - $from + 1);
        $total_fresh_count += ($total_fresh_slot);

        $max_fresh_id = $to;
    }

    return [$fresh_count, $total_fresh_count];
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
