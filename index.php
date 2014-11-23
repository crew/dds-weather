<!DOCTYPE html>
<!-- 
Yeah, I basically just modified the 
bootstrap example a little to make this.
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php require("jsonFetch.php");
          setup();
          $sunPhase = $GLOBALS['astronomy']->sun_phase;
          $sunriseTimestamp = $sunPhase->sunrise->hour . ":" . $sunPhase->sunrise->minute;
          $sunsetTimesamp = $sunPhase->sunset->hour . ":" . $sunPhase->sunset->minute;
          require("climacons.php");
          $curObv = $conditions->current_observation;?>

    <title>Boston, MA Weather</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static_svg.css" type="text/css">
    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

  </head>

  <body>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <?php include weatherStringToImage($GLOBALS['conditions']->current_observation->icon, true, $sunriseTimestamp, $sunsetTimestamp); ?>
        <h1>Boston, MA</h1>
        <p style="font-weight: normal;"><?php echo ($GLOBALS['conditions']->current_observation->temperature_string);?></p>
        <p style="font-weight: normal;"><?php echo ($GLOBALS['conditions']->current_observation->weather);?></p> 
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2><?php echo getNDateString(0); 
              ?></h2>
          <p><?php include weatherStringToImage(getNImageString(0), false);?><br /><br /><br /><?php echo getNHighString(0);?><br /><?php echo getNLowString(0); ?><br />
               <div class="foreWeath"><?php echo getNWeatherString(0);?></div></p>
     
        </div>
        <div class="col-md-4">
          <h2><?php echo getNDateString(1);?></h2>
          <p><?php include weatherStringToImage(getNImageString(1), false);?><br /><br /><br /><?php echo getNHighString(1);?><br /><?php echo getNLowString(1); ?><br />
               <div class="foreWeath"><?php echo getNWeatherString(1);?></div></p>
    
       </div>
        <div class="col-md-4">
          <h2><?php echo getNDateString(2);?></h2>
          <p><?php include weatherStringToImage(getNImageString(2), false);?><br /><br /><br /><?php echo getNHighString(2);?><br /><?php echo getNLowString(2); ?><br />
               <div class="foreWeath"><?php echo getNWeatherString(2);?></div></p>
   
        </div>
      </div>

      <hr>


    </div> <!-- /container -->
    <div class="container">
    <div class="row">
         <div class="col-md-6">
              <p style="line-height: 1.5; margin-top: 1.5em;">Humidity: <?php echo $curObv->relative_humidity;?><br />Dew Point: <?php echo $curObv->dewpoint_string;?><br />Rainfall: <?php echo $curObv->precip_today_string;?><br /> Chance of Precipitation: <?php echo $forecast->forecast->simpleforecast->forecastday[0]->pop;?>%<br />Today's Expected Rainfall: <?php echo $forecast->forecast->simpleforecast->forecastday[0]->qpf_allday->in;?> in. (<?php echo $forecast->forecast->simpleforecast->forecastday[0]->qpf_allday->mm;?> mm.)<br />Today's Estimated Average Humidity: <?php echo $forecast->forecast->simpleforecast->forecastday[0]->avehumidity;?>%</p>
         </div>
         <!--<div class="col-md-2"><p></p></div>-->
         <div class="col-md-6">
              <div style="display:block; clear:both;">
              <div style="float: left; display:inline; margin-top: 1.5em; width: 55%;"><?php include $sunrise;?><br /><span>Sunrise: <?php echo $GLOBALS['astronomy']->sun_phase->sunrise->hour;?>:<?php echo $GLOBALS['astronomy']->sun_phase->sunrise->minute;?> AM</span></div>
              <div style="float: left; display:inline; width: 55%;"><?php include $sunset;?><br /><span>Sunset: <?php echo strval(intval($GLOBALS['astronomy']->sun_phase->sunset->hour) % 12);?>:<?php echo $GLOBALS['astronomy']->sun_phase->sunset->minute;?> PM</span></div>
            <div style="float: left; display:inline; width: 55%;"><?php include $moon;?><br /><span><?php echo $GLOBALS['astronomy']->moon_phase->phaseofMoon;?></span></div></div>
         </div>
    </div>
    </div>

      <footer>
        <p style="color: #787878; text-align: center;">&copy; NEU CCIS Crew 2014-<?php echo date('Y'); ?></p>
      </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/js/ie10viewport.js"></script>
  </body>
</html>

