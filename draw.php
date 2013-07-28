<?php

/**
 * Github Contributions renderer
 * @author Mikulas Dite
 * @license BDS-3
 *
 * @see README.md
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

if (file_exists('draw_repo')) {
	echo "directory draw_repo already exists, remove it first\n";
	die(3);
}
exec('mkdir draw_repo; cd draw_repo; git init; touch draw; git add draw');

$date = $firstDate;
$day = new DateInterval('P1D');
foreach ($serialize as $c) {
	switch ($c) {
		case '4':
			commit($date);
		case '3':
			commit($date);
		case '2':
			commit($date);
		case '1':
		case '#':
			commit($date);
		case '0':
		case '.':
			$date = $date->add($day);
		case '-':
		default:
	}
}

function commit($date, $user, $email)
{
	$d = $date->format('c');
	$e = $d . '_' . mt_rand(1e11, 1e12 - 1);
	$exec = "cd draw_repo && echo $e > draw && \
		GIT_AUTHOR_DATE=\"$d\" \
		GIT_COMMITTER_DATE=\"$d\" \
		GIT_COMMITTER_NAME=\"$user\" \
		GIT_AUTHOR_NAME=\"$user\" \
		GIT_COMMITTER_EMAIL=\"$email\" \
		GIT_AUTHOR_EMAIL=\"$email\" \
		git commit -am \"draw\"";
	exec($exec);
}
