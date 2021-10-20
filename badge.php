<?php 

include('fetch.php');

$year = getData( date("Y") );

function getAvatar ($level) {

  // RETURNS A X POSITION ON img/characters.png SPRITE
  // ---

  if ($level < 10) {
    $output = 756;
  } elseif ($level < 20) {
    $output = 677;
  } elseif ($level < 30) {
    $output = 591;
  } elseif ($level < 40) {
    $output = 495;
  } elseif ($level < 50) {
    $output = 412;
  } elseif ($level < 65) {
    $output = 323;
  } elseif ($level < 80) {
    $output = 213;
  } else {
    $output = 111;
  }

  return $output;

}

function sortBestLanguages ($languages) {

  foreach ($languages AS $language => $data) {
    $toBeSorted[ $language ] = $data -> level;
  }

  asort($toBeSorted);

  return array_slice( array_reverse( $toBeSorted ), 0, 3 );

}

$bestLanguages = sortBestLanguages($year->languages);

$hoursToNextLevel = floor($year->level->hoursRequiredNextLevel);
$minutesToNextLevel = round( ( $year->level->hoursRequiredNextLevel - floor( $year->level->hoursRequiredNextLevel ) ) * 60 );

?>

<html>

  <head>
    <style>
      @font-face {
        font-family: "Upheaval";
        src: url('font/upheavtt.ttf') format("truetype");
      }
      @font-face {
        font-family: "vcr";
        src: url('font/vcr.ttf') format("truetype");
      }
    </style>

  </head>
  <body>
    
    <div style="float:left; font-family:'Upheaval'; width:350px; padding:10px; padding-top:5px; border:solid 3px #000; border-radius:10px; background-color:#353535">
  
      <div style="float:left; width:100%; margin-bottom:5px; justify-content:space-between; color:#f4e15e">
        <div style="float:left; font-size:52px; font-weight:bold; line-height:48px;"><?php echo $year->year ?></div>
        <div style="float:right; font-size:32px; font-family:'vcr'; line-height:48px;">Lv.<b><?php echo $year->level->level ?></b></div>
      </div>

      <div style="float:left; width:100%; margin-bottom:5px; justify-content:center; color:#f4e15e">
        <div style="height:115px; margin-left:auto; margin-right:auto; width:100px; background:url('img/characters.png') <?php echo getAvatar($year->level->level) ?>px 116px;"></div>
      </div>

      <div style="float:left; background-color:#EEE; border:solid 2px #000; border-radius:5px; width:80%; margin-left:calc(10% - 2px);">
        <div style="float:left; padding:10px;">
          <?php foreach ( $bestLanguages AS $language => $level ) { ?>
            <div style="float:left; width:100%;">
              <div style="float:left; width:50%"><?php echo $language ?></div>
              <div style="float:left; width:20%; border-radius:3px; height:10px; background-color:#999; margin-top:3px;">
                <div style="border-radius:3px; width:<?php echo $year->languages->{$language}->progression * 100 ?>%; background-color:#f4e15e; height:10px;"></div>
              </div>
              <div style="float:left; text-align:right; width:30%; font-family:'vcr';">Lv.<b><?php echo $level ?></b></div>
            </div>
          <?php } ?>
        </div>
      </div>

      <?php if ( $year->year == date("Y") ) { // Progress bar ?>
      
        <div style="float:left; margin-left:10%; border-radius:3px; width:80%; margin-right:10%; margin-bottom:5px; height:15px; margin-top:15px; background-color:#BBB">
          <div style="color:#353535; border-radius:3px; width:<?php echo $year->level->progression * 100 ?>%; background-color:#f4e15e; height:15px;">&nbsp;&nbsp;<?php echo round( $year->level->progression * 100 ) ?>%</div>
        </div>

      <?php } ?>

      <?php if ( $year->year == date("Y") ) { ?>
        <div style="float:left; font-family:'vcr'; font-size:12px; text-transform:uppercase; text-align:center; width:100%; color:#BBB;"><?php echo $hoursToNextLevel ?>h<?php echo $minutesToNextLevel ?> to next level</div>
      <?php } ?>

      <div style="float:left; font-family:'vcr'; font-size:16px; text-transform:uppercase; text-align:center; width:100%; color:#BBB; margin-top:10px;">total <?php echo round($year->hours) ?> hours</div>
      <div style="float:left; font-family:'vcr'; font-size:10px; text-transform:uppercase; text-align:center; width:100%; color:#BBB; margin-top:25px;">powered by wakatime</div>
      <div style="float:left; font-family:'vcr'; font-size:8px; text-transform:uppercase; text-align:center; width:100%; color:#BBB; margin-top:3px;"><?php echo date("Y-m-d H:i:s") ?></div>

    </div>
  
  </body>

</html>