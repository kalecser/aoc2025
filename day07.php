<?php

echo "Part 1 sample expected: 21 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 1633 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 40 actual:" . compute(sample(), part_1: false) . "\n";
echo "Part 2 actual expected: 34339203133559 actual: " . compute(input(), part_1: false) . "\n";

function compute(string $input, $part_1 = true): string {
    $lines  = preg_split('/\R/', trim($input));
    $matrix = array_map('str_split', $lines);

    $start_y_x = findStartYX($matrix);

    $matrix[$start_y_x[0]][$start_y_x[1]] = '.';
    if ($part_1)
        $count = renderTachionAndReturnSplittlerCount($matrix, $start_y_x);
    else
        $count = renderTachionAndReturnEndCount($matrix, $start_y_x);
    return $count;
}

function renderTachionAndReturnSplittlerCount(array &$matrix, array $start_y_x): int
{
    $matrix[$start_y_x[0]][$start_y_x[1]] = '|';

    $next_position_y_x = [$start_y_x[0] + 1, $start_y_x[1]];
    if (@$matrix[$next_position_y_x[0]][$next_position_y_x[1]] == '^') {
        @$matrix[$next_position_y_x[0]][$next_position_y_x[1]] = 'v';
        return 1 +
            /* left */  renderTachionAndReturnSplittlerCount($matrix, [$next_position_y_x[0] + 1, $next_position_y_x[1] - 1]) +
            /* right */ renderTachionAndReturnSplittlerCount($matrix, [$next_position_y_x[0] + 1, $next_position_y_x[1] + 1]);
    } else if (@$matrix[$next_position_y_x[0]][$next_position_y_x[1]] == null) {
        return 0;
    } else if (@$matrix[$next_position_y_x[0]][$next_position_y_x[1]] == 'v') {
        return 0;
    }


    $start_y_x[0] += 1;
    return renderTachionAndReturnSplittlerCount($matrix, $start_y_x);
}


function renderTachionAndReturnEndCount(array &$matrix, array $start_y_x, array &$memo = []): int
{
    // Memo key for this starting position
    $key = $start_y_x[0] . ',' . $start_y_x[1];

    if (array_key_exists($key, $memo)) {
        // We still increment only the current cell so some visual info is kept,
        // but we skip walking the whole subtree.
        $matrix[$start_y_x[0]][$start_y_x[1]] =
            $matrix[$start_y_x[0]][$start_y_x[1]] == '.'
                ? 1
                : $matrix[$start_y_x[0]][$start_y_x[1]] + 1;

        return $memo[$key];
    }

    // Original increment
    $matrix[$start_y_x[0]][$start_y_x[1]] =
        $matrix[$start_y_x[0]][$start_y_x[1]] == '.'
            ? 1
            : $matrix[$start_y_x[0]][$start_y_x[1]] + 1;

    $next_position_y_x = [$start_y_x[0] + 1, $start_y_x[1]];

    if (@$matrix[$next_position_y_x[0]][$next_position_y_x[1]] == '^') {
        $result =
            /* left  */ renderTachionAndReturnEndCount($matrix, [$next_position_y_x[0] + 1, $next_position_y_x[1] - 1], $memo) +
            /* right */ renderTachionAndReturnEndCount($matrix, [$next_position_y_x[0] + 1, $next_position_y_x[1] + 1], $memo);
    } elseif (@$matrix[$next_position_y_x[0]][$next_position_y_x[1]] == null) {
        $result = 1;
    } else {
        $start_y_x[0] += 1;
        $result = renderTachionAndReturnEndCount($matrix, $start_y_x, $memo);
    }

    $memo[$key] = $result;
    return $result;
}


function findStartYX(array $matrix): array
{
    $start = null;

    foreach ($matrix as $r => $row) {
        $c = array_search('S', $row);
        if ($c !== false) {
            $start = [$r, $c];
            break;
        }
    }

    return $start;
}

function sample(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
