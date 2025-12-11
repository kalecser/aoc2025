<?php

echo "Part 1 sample expected: 40 actual: " . compute(sample()) . "\n";
echo "Part 1 actual expected: 57970 actual: " . compute(input(), 1000) . "\n";
//echo "Part 2 sample expected: xxx actual:" . compute(sample()) . "\n";
//echo "Part 2 actual expected: xxx actual: " . compute(input()) . "\n";

function compute(string $input, int $max_connections = 10): string {
    $junction_boxes = parseJunctionBoxes($input);

    list($junction_boxes_distances, $i, $key) = sortBySmallestDistance($junction_boxes);


    //initialize circuits
    $circuits = [];
    $circuitIndices = [];  // box index => circuitId

    for ($i = 0; $i < count($junction_boxes); $i++) {
        $circuits[$i] = [$i];
        $circuitIndices[$i] = $i;
    }

    //make N shortest connections
    $how_many = 0;
    foreach ($junction_boxes_distances as $key => $dist) {
        if ($how_many >= $max_connections) {
            break;
        }

        [$a, $b] = array_map('intval', explode('_', $key));

        $indexA = $circuitIndices[$a];
        $indexB = $circuitIndices[$b];

        if ($indexA != $indexB) {
            $circuitA =& $circuits[$indexA];
            $circuitB =& $circuits[$indexB];

            // Merge circuitB into circuitA
            while (!empty($circuitB)) {
                $node = array_shift($circuitB);
                $circuitA[] = $node;
                $circuitIndices[$node] = $indexA;
            }
        }

        $how_many++;
    }

    usort($circuits, function (array $a, array $b) {
        return count($b) <=> count($a);
    });

    //multiply three initial values
    $result = count(array_shift($circuits)) * count(array_shift($circuits)) * count(array_shift($circuits));

    return (string) $result;
}

function sortBySmallestDistance(array $junction_boxes): array
{
    $junction_boxes_distances = []; // key "i_j" => distance
    $n = count($junction_boxes);
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $key = $i . '_' . $j;
            $junction_boxes_distances[$key] = euclidean_distance_3d($junction_boxes[$i], $junction_boxes[$j]);
        }
    }

    asort($junction_boxes_distances);
    return array($junction_boxes_distances, $i, $key); // ascending by distance
}

function parseJunctionBoxes(string $input): array
{
    $lines = preg_split('/\R/', trim($input));
    $junction_boxes = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        $parts = explode(',', $line);
        $parts = array_map('intval', $parts);
        $junction_boxes[] = $parts;
    }
    return $junction_boxes;
}


function euclidean_distance_3d(array $a, array $b): float
{
    $dx = (float)($a[0] - $b[0]);
    $dy = (float)($a[1] - $b[1]);
    $dz = (float)($a[2] - $b[2]);

    $ax = abs($dx);
    $ay = abs($dy);
    $az = abs($dz);

    $m = max($ax, $ay, $az);
    if ($m == 0.0) {
        return 0.0;
    }

    $dx /= $m;
    $dy /= $m;
    $dz /= $m;

    return $m * sqrt($dx*$dx + $dy*$dy + $dz*$dz);
}



function sample(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string {
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
