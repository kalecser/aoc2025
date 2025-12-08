<?php

echo "Part 1 sample expected: 4277556 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 4449991244405 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 3263827 actual:" . compute2(sample()) . "\n";
echo "Part 2 actual expected: 9348430857627 actual: " . compute2(input()) . "\n";


function compute(string $input): string {
    return (string) sum_of_groups(parse_table_groups($input));
}

function compute2(string $input): string {
    return (string) sum_of_groups(parse_cephalopod_groups($input));
}

function parse_table_groups(string $input): iterable {
    $lines = preg_split('/\R/', trim($input));
    $rows  = array_map(fn($l) => preg_split('/\s+/', trim($l)), $lines);

    $rowCount = count($rows);
    $colCount = count($rows[0]);

    for ($col = 0; $col < $colCount; $col++) {
        $column = [];
        for ($r = 0; $r < $rowCount - 1; $r++) {
            $column[] = (int) $rows[$r][$col];
        }
        $op = $rows[$rowCount - 1][$col];

        yield [$column, $op];
    }
}

function parse_cephalopod_groups(string $input): iterable {
    $lines  = preg_split('/\R/', trim($input));
    $matrix = array_map('str_split', $lines);

    $numbers = [];
    $width   = count($matrix[0]);

    for ($col = $width - 1; $col >= 0; $col--) {
        $column = array_column($matrix, $col);
        $numbers[] = (int) implode($column);
        $op = end($column);

        if ($op === '+' || $op === '*') {
            yield [$numbers, $op];
            $numbers = [];
        }
    }
}

function sum_of_groups(iterable $groups): int {
    $total = 0;

    foreach ($groups as [$numbers, $op]) {
        $total += apply_operation($numbers, $op);
    }

    return $total;
}


function apply_operation(array $numbers, string $op): int {
    if (($numbers[0] ?? null) === 0) {
        array_shift($numbers); // drop sentinel 0 (cephalopod operator column)
    }

    $first = array_shift($numbers);

    return match ($op) {
        '+' => array_reduce(
            $numbers,
            fn(int $carry, int $n) => $carry + $n,
            $first
        ),
        '*' => array_reduce(
            $numbers,
            fn(int $carry, int $n) => $carry * $n,
            $first
        ),
        default => throw new \InvalidArgumentException("Unknown operator '$op'"),
    };
}


function sample(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
