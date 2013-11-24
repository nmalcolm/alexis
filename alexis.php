<?php

/**
 * Gather top 100 Alexa ranked websites
 *
 * Simple script I hacked together to pull the top 100 Alexa ranked websites.
 *
 * Author: Nathan Malcolm
 * Date: Sunday, November 24 3013
 * License: DON'T BE A DICK PUBLIC LICENSE. See LICENSE.
 */

/**
 * EXAMPLES
 *
 * $ php alexis.php # Just print out the top 100 sites
 * $ php alexis.php -n 500# Woah, getting greedy. Print out the top 500.
 * $ php alexis.php -o domains.txt # Let's save these, cuz we love I/O.
 * $ php alexis.php -f 1 # Update the local csv file, no matter what.
 */

// Turns the machine in to a super computer, giving it unlimited memory.
ini_set('memory_limit', '-1');

$options = getopt("o:f:n:");

// We default to 100
$number = 100;
if($options['n']) {
   $number = $options['n'];
}

// Do we need to download a new csv file?
if(!file_exists('top-1m.csv') || (!isset($options['f']) && $options['f'] == 1)) {
   system('rm -rf top-1m.csv.zip top-1m.csv && wget http://s3.amazonaws.com/alexa-static/top-1m.csv.zip && unzip top-1m.csv.zip && rm -rf top-1m.csv.zip');
}

$lines = file('top-1m.csv');

// This is pretty simple.
$i = 0;
foreach($lines as $number => $line) {
   $i++;
   if($i < $number + 1) {
      $domain = explode(',', $line);
      $domain = $domain[1];
      $domains[] = $domain;
      if(!empty($options['o'])) {
         file_put_contents($options['o'], $domain, FILE_APPEND);
      }
         echo $domain;
      }
   else {
   exit;
   }
}
