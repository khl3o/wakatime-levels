<?php

require('config.php');

function getLevel ($xp) {

  // RETURN LEVEL DATA FROM XP
  // ---

  // 1 xp point = 1 minute

  $XP_PER_LEVEL = 50;

  $level = ( ( 1 + sqrt( 1 + ( 28 * $xp ) / $XP_PER_LEVEL ) ) / 2 ) - 1;
  $nextLevel = floor($level) + 1;
  $minutesRequiredNextLevel = ( ( pow( ( $nextLevel * 2 + 1), 2 ) ) * ($XP_PER_LEVEL/2) - ($XP_PER_LEVEL/2) ) / 14;

  $hoursRequiredNextLevel = round( ( ( $minutesRequiredNextLevel - $xp ) / 60 ), 2  );

  return array(
    'level' => floor($level),
    'hoursRequiredNextLevel' => $hoursRequiredNextLevel,
    'progression' => round( ( $level - floor($level) ), 2)
  );

}

function getData ($year) {

  // FETCH DATA FROM WAKATIME API
  // ---

  $apikey = $GLOBALS['apikey'];

  $arrContextOptions=array(
    "ssl"=>array(
      "verify_peer"=>false,
      "verify_peer_name"=>false,
    ),
  );

  $start = $year.'-01-01';
  $end = $year.'-12-31';

  $totalLanguage = array();

  // FETCH DATA FROM WAKATIME

  $url = $GLOBALS['method_user_summaries'].'?api_key='.$apikey.'&start='.$start.'&end='.$end;

  $content = json_decode( file_get_contents($url, false, stream_context_create($arrContextOptions)) );
  $totalSeconds = 0;

  foreach ($content->data AS $day) {

    // FOR EACH DAY
    // ---

    foreach ($day->languages AS $language) {

      // CALCUL THE SECONDS SUM FOR EACH LANGUAGE
      // ---

      if ( isset($totalLanguage[ $language->name ]) )
        $totalLanguage[ $language->name ] += $language->total_seconds;
      else
        $totalLanguage[ $language->name ] = $language->total_seconds;

    }

    // TOTAL SECONDS THIS YEAR
    // ---

    $totalSeconds += $day->grand_total->total_seconds;

  }

  foreach ($totalLanguage AS $language => $seconds)
    $totalLanguage[$language] = getLevel($seconds/60);

  // GET THE LEVEL INFORMATIONS
  // ---

  $hours = round($totalSeconds/3600, 2);
  $lvl = getLevel($totalSeconds/60);

  $output = array(
    'year' => $year,
    'hours' => $hours,
    'level' => $lvl,
    'languages' => $totalLanguage
  );

  return json_decode( json_encode( $output ) );

}