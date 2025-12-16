<?php

ini_set('memory_limit', '500M');

echo "Part 1 sample expected: 50 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 4769758290 actual: " . compute(input()) . "\n";
echo "Part 2 sample expected: 24 actual:" . compute(sample(), part_2: true) . "\n";
echo "Part 2 actual expected: 1588990708 actual: " . compute(input(), part_2: true) . "\n";



function compute(string $input, bool $part_2 = false): string {
    $lines = explode("\n", $input);
    $tiles = [];

    $boundaries = [];
    $limit_coords = [];
    $initial_coord = null;
    $previous_coord = null;
    foreach ($lines as $line) {
        $coords_x_y = explode(",", $line);
        $coords_x_y[0] = (int)$coords_x_y[0];
        $coords_x_y[1] = (int)$coords_x_y[1];

        if (!is_null($previous_coord)) {
             computeBoundaries($coords_x_y, $previous_coord, $boundaries, $limit_coords);
        }

        $initial_coord ??= $coords_x_y;
        $previous_coord = $coords_x_y;


        $tiles[] = $coords_x_y;
    }

    computeBoundaries($initial_coord, $previous_coord, $boundaries, $limit_coords);
    foreach ($limit_coords as $coord) {
        unset($boundaries[$coord]);
    }

    $rectangles = [];
    $max_area = 0;
    foreach ($tiles as $tile_a) {
        tile_b: foreach ($tiles as $tile_b) {
            if ($tile_a == $tile_b) continue;
            $candidate = [$tile_a, $tile_b];


            $area = rectArea($candidate);
            $rectangles[$area] ??= [];
            $rectangles[$area][] = $candidate;
        }
    }

    krsort($rectangles);

    if (!$part_2) {
        return array_key_first($rectangles);
    }

    $progress = 0;
    foreach ($rectangles as $area => $inner_rectangles) {

        $progress++;
        if ($progress % 100 == 0) { var_dump($progress . ' of ' . count($rectangles)); }
        foreach ($inner_rectangles as $rectangle) {
            $invalid = false;
            foreach ($boundaries as $boundary) {
                if(pointInRect($boundary, $rectangle)){
                    $invalid = true;
                    break;
                }
            }
            if (!$invalid) {return $area;}
        }
    }



    var_dump($progress);
    return $max_area;
}

function computeBoundaries(array &$coords_x_y, array &$previous_coord, array &$boundaries, array &$limit_coords): void
{
    if ($coords_x_y[0] > $previous_coord[0]) { //right
        for ($i = $previous_coord[0]; $i <= $coords_x_y[0]; $i++) {
            $boundaries[$i . ',' . ($coords_x_y[1] - 1)] = [$i, $coords_x_y[1] - 1];
            $limit_coords[] = $i . ',' . $coords_x_y[1];
        }
    } else if ($coords_x_y[0] < $previous_coord[0]) { //left
        for ($i = $previous_coord[0]; $i >= $coords_x_y[0]; $i--) {
            $boundaries[$i . ',' . ($coords_x_y[1] + 1)] = [$i, $coords_x_y[1] + 1];
            $limit_coords[] = $i . ',' . $coords_x_y[1];
        }
    } else if ($coords_x_y[1] > $previous_coord[1]) { //down
        for ($i = $previous_coord[1]; $i <= $coords_x_y[1]; $i++) {
            $boundaries[($coords_x_y[0] + 1) . ',' . $i] = [$coords_x_y[0] + 1, $i];
            $limit_coords[] = $coords_x_y[0] . ',' . $i;
        }
    } else if ($coords_x_y[1] < $previous_coord[1]) { //up
        for ($i = $previous_coord[1]; $i >= $coords_x_y[1]; $i--) {
            $boundaries[($coords_x_y[0] - 1) . ',' . $i] = [$coords_x_y[0] - 1, $i];
            $limit_coords[] = $coords_x_y[0] . ',' . $i;
        }
    }
}

function rectArea(array $rect): int
{
    return (abs($rect[1][0] - $rect[0][0]) + 1)
        * (abs($rect[1][1] - $rect[0][1]) + 1);
}

function pointInRect(array &$point, array &$rect): bool
{
    $x = $point[0];
    $y = $point[1];

    $minX = min($rect[0][0], $rect[1][0]);
    $maxX = max($rect[0][0], $rect[1][0]);
    $minY = min($rect[0][1], $rect[1][1]);
    $maxY = max($rect[0][1], $rect[1][1]);

    return (
        $x >= $minX && $x <= $maxX &&
        $y >= $minY && $y <= $maxY
    );
}

function sample(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
