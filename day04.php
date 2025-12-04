<?php

echo "Part 1 sample expected: 13 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 1320 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 43 actual:" . compute(sample(), repeat: true) . "\n";
echo "Part 2 actual expected: 8354 actual: " . compute(input(), repeat: true) . "\n";

/**
 * If $repeat is false:
 *   - Single pass: count how many '@' cells have fewer than 4 adjacent '@' cells.
 *
 * If $repeat is true:
 *   - Repeatedly "lift" (remove) all '@' cells that have fewer than 4
 *     adjacent '@' cells, until no more can be lifted.
 *   - Return the total number of lifted cells.
 */
function compute(string $input, bool $repeat = false): int {
    $grid = array_map('str_split', explode("\n", trim($input)));

    $h = count($grid);
    $w = count($grid[0]);

    // Offsets for all 8 adjacent cells
    $neighbors = [
        [-1, -1], [-1, 0], [-1, 1],
        [ 0, -1],          [ 0, 1],
        [ 1, -1], [ 1, 0], [ 1, 1],
    ];

    $result = 0;

    do {
        $changed = false;

        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                if ($grid[$y][$x] !== '@') continue;

                $count = 0;

                foreach ($neighbors as [$dy, $dx]) {
                    $ny = $y + $dy;
                    $nx = $x + $dx;

                    if (@$grid[$ny][$nx] === '@') {
                        $count++;
                    }
                }

                $can_lift_paper_roll = $count < 4;
                if ($can_lift_paper_roll) {
                    if ($repeat) {
                        $grid[$y][$x] = '.';
                        $result++;
                        $changed = true;
                    } else {
                        $result++;
                    }
                }
            }
        }
    } while ($repeat && $changed);

    return $result;
}

function sample() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input() {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
