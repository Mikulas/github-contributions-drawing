<?php

/**
 * Github Contributions renderer
 * @author Mikulas Dite
 * @license BDS-3
 *
 * USAGE:
 * 1. update $pattern
 * 	 a. for each whitespace in the leftmost column, write a dash -
 * 	 b. draw in the rest of fields, dot is white, hash is colored
 * 2. specify what date is on the very first dot (going by column)
 * 3. push repo in ./draw_repo to Github
 */

$pattern = trim('
-....................####.#....#####.#.....#.#.#####.
-...................#.....#....#.....#.....#.#.#.....
-...................#.....#....#......#...#..#..#....
-...................#.....#....###.....#..#..#...##..
-...................#.....#....#.......#..#..#.....#.
....................#.....#....#........##...#.....#.
.....................####.####.#####.....#...#.#####.
');
 
// time added just to make sure it's falls into the right day
$firstDate = new DateTime('July 27 2012 00:01');

$user = '';
$email = '';


/** ************************ renderer ************************ */

// keep this as is
date_default_timezone_set('America/Los_Angeles');

$serialize = [];
$lines = explode("\n", $pattern);
for ($i = 0; $i < 53; ++$i) {
	foreach ($lines as $l) {
		$serialize[] = $l[$i];
	}
}

if (count($serialize) !== 371) {
	echo "invalid pattern, given " . count($serialize) . " chars\n";
	die(2);
}

exec('mkdir draw_repo; cd draw_repo; git init; touch draw; git add draw');

$date = $firstDate;
$day = new DateInterval('P1D');
foreach ($serialize as $c) {
	switch ($c) {
		case '#':
			commit($date);
		case '.':
			$date = $date->add($day);
		case '-':
		default:
	}
}

function commit($date, $user, $email)
{
	$d = $date->format('c');
	$exec = "cd draw_repo && echo $d > draw && \
		GIT_AUTHOR_DATE=\"$d\" \
		GIT_COMMITTER_DATE=\"$d\" \
		GIT_COMMITTER_NAME=\"$user\" \
		GIT_AUTHOR_NAME=\"$user\" \
		GIT_COMMITTER_EMAIL=\"$email\" \
		GIT_AUTHOR_EMAIL=\"$email\" \
		git commit -am \"draw\"";
	exec($exec);
}
