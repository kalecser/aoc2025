<?php

declare(strict_types=1);

const DIAL_SIZE = 100;
const START_POS = 50;

echo "Part 1 sample expected: 3 actual: " . countRotationsEndingWithZero(sample()) . PHP_EOL;
echo "Part 1 actual expected: 999 actual: " . countRotationsEndingWithZero(input()) . PHP_EOL;
echo "Part 2 sample expected: 6 actual: " . countRotationsPassingZero(sample()) . PHP_EOL;
echo "Part 2 actual expected: 6099 actual: " . countRotationsPassingZero(input()) . PHP_EOL;

/**
 * Part 1 — count movements that end exactly on zero.
 */
function countRotationsEndingWithZero(string $input): int
{
    $moves = parseMoves($input);
    $pos = START_POS;
    $count = 0;

    foreach ($moves as $delta) {
        $pos = wrapDial($pos + $delta);

        if ($pos === 0) {
            $count++;
        }
    }

    return $count;
}

/**
 * Part 2 — count rotations that pass zero, including upon wraps.
 */
function countRotationsPassingZero(string $input): int
{
    $moves = parseMoves($input);
    $pos = START_POS;
    $count = 0;

    foreach ($moves as $delta) {
        [$pos, $wraps] = applyMoveAndCountWraps($pos, $delta);
        $count += $wraps;
    }

    return $count;
}

/**
 * Parse input lines like "L10", "R4", …
 */
function parseMoves(string $input): array
{
    $lines = explode("\n", $input);
    $moves = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === "") continue;

        $side   = $line[0];           // 'L' or 'R'
        $clicks = (int) substr($line, 1);
        $moves[] = ($side === 'L' ? -1 : 1) * $clicks;
    }

    return $moves;
}

/**
 * Modulo that always returns 0..99
 */
function wrapDial(int $position): int
{
    return ($position % DIAL_SIZE + DIAL_SIZE) % DIAL_SIZE;
}

/**
 * Apply movement and count how many times we wrapped past zero.
 */
function applyMoveAndCountWraps(int $position, int $delta): array
{
    $position += $delta;
    $wraps = 0;

    while ($position >= DIAL_SIZE) {
        $position -= DIAL_SIZE;
        $wraps++;
    }
    while ($position < 0) {
        $position += DIAL_SIZE;
        $wraps++;
    }

    return [$position, $wraps];
}

function sample(): string
{
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-0sample.txt');
}

function input(): string
{
    return file_get_contents(pathinfo(__FILE__, PATHINFO_FILENAME) . '-input.txt');
}
