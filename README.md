# Advent of Code 2025 – PHP Solutions

This repository contains my personal solutions for [Advent of Code 2025](https://adventofcode.com/2025), implemented in PHP.

The goal is to share my approach with colleagues so you can:
- Read through the solutions day by day
- Run them locally with your own inputs
- Compare ideas, trade-offs, and alternative implementations

---

## Repository structure

Each day’s puzzle lives in a single PHP file:

- `day00.php` – template / scratch file used to start new days
- `day01.php` – solution for Day 1
- `dayNN.php` – general pattern for later days

Each `dayNN.php` expects two text files next to it:

- `dayNN-0sample.txt` – sample input (usually copied from the problem statement)
- `dayNN-input.txt` – your personal puzzle input downloaded from the Advent of Code website

These `.txt` files are **ignored by git** (`*.txt` is in `.gitignore`) so that everyone can use their own inputs without committing them.

## How to run a day's solution (example: Day 1, PHP 8)

1. Open the Day 1 puzzle:  
   https://adventofcode.com/2025/day/1

2. Create a file named **day01-0sample.txt** and paste the example input from the problem statement into it.

3. Create a file named **day01-input.txt** and paste your personal input (available when logged in at Advent of Code).

4. Run the Day 1 solution using PHP 8:

   ```bash
   php day01.php
