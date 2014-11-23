<?php

$jsonCondFile = "jsonCondResponse.txt";
$jsonForeFile = "jsonForeResponse.txt";
$jsonAstrFile = "jsonAstrResponse.txt";
$conditions = null;
$forecast = null;
$astronomy = null;

include('config.php');

// withinLastNMinutes
// Time Number -> Boolean
// Returns true if the given time is
//   within the last n minutes
function withinLastNMinutes($t, $n){
 $comp = (time() - ($n * 60));
 return ($comp < $t);
}

// fileOkay
// File -> Boolean
// Returns true if the file does not
//   need updating
function fileOkay($f){
  return (file_exists($f) && withinLastNMinutes(filemtime($f), 10));
}
// timeToGet
// [None] -> Boolean
// Returns true if it is time to fetch
//    the JSON from Weather Underground
function timeToGet(){
  return !(fileOkay($GLOBALS['jsonCondFile'])
        && fileOkay($GLOBALS['jsonForeFile'])
        && fileOkay($GLOBALS['jsonAstrFile']));
}

// updateJSONFile
// [Void]
// Re-syncs the JSON File with Weather
//    Underground Data
function updateJSONFile(){
  $ch = curl_init("http://api.wunderground.com/api/".$GLOBALS['API_KEY']."/conditions/q/MA/Boston.json");
  $json_string = "to-json";
  $options = array(
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
  CURLOPT_POSTFIELDS => $json_string,
  CURLOPT_HEADER => false
  );
  curl_setopt_array( $ch, $options );

  $req = curl_exec($ch);
  //$file = fopen($GLOBALS['jsonCondFile'], "w");
  file_put_contents($GLOBALS['jsonCondFile'], $req);
  curl_close($ch);
  //fclose($file);

  $ch = curl_init("http://api.wunderground.com/api/".$GLOBALS['API_KEY']."/forecast/q/MA/Boston.json");
  $json_string = "to-json";
  $options = array(
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
  CURLOPT_POSTFIELDS => $json_string,
  CURLOPT_HEADER => false
  );
  curl_setopt_array( $ch, $options );

  $req = curl_exec($ch);
  //$file = fopen($GLOBALS['jsonForeFile'], "w");
  file_put_contents($GLOBALS['jsonForeFile'], $req);
  curl_close($ch);
  //fclose($file);

  $ch = curl_init("http://api.wunderground.com/api/".$GLOBALS['API_KEY']."/astronomy/q/MA/Boston.json");
  $json_string = "to-json";
  $options = array(
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
  CURLOPT_POSTFIELDS => $json_string,
  CURLOPT_HEADER => false
  );
  curl_setopt_array( $ch, $options );

  $req = curl_exec($ch);
  //echo $GLOBALS['jsonAstrFile'];
  //$file = fopen($GLOBALS['jsonAstrFile'], "w");
  file_put_contents($GLOBALS['jsonAstrFile'], $req);
  curl_close($ch);
  //fclose($file);
  }

// updateVars:
// [Void]
// Updates the Global Variables $conditions,
//    $forecast, and $astronomy
function updateVars(){
  $fCond = file_get_contents($GLOBALS['jsonCondFile']);
  $fFore = file_get_contents($GLOBALS['jsonForeFile']);
  $fAstr = file_get_contents($GLOBALS['jsonAstrFile']);
  $GLOBALS['conditions'] = json_decode($fCond);
  $GLOBALS['forecast']   = json_decode($fFore);
  $GLOBALS['astronomy']  = json_decode($fAstr);
}

// setup
// [Void]
// Runs Initial Setup
function setup(){
  if (timeToGet()){
    updateJSONFile();
  }
  updateVars();
}

// getNDateString
// Number -> String
// Returns the Date String from the n'th
//    forecast day
function getNDateString($n){
  $fday = $GLOBALS['forecast']->forecast->simpleforecast->forecastday;
  return join(" ",array($fday[$n]->date->weekday_short,
                        $fday[$n]->date->day,
                        $fday[$n]->date->monthname_short));
}

// getNHighString
// Number -> String
// Returns the Weather High String from the
//   n'th forecast day
function getNHighString($n){
  $fday = $GLOBALS['forecast']->forecast->simpleforecast->forecastday;
  return join("",array("High: ",$fday[$n]->high->fahrenheit," F (",
                        $fday[$n]->high->celsius," C)"));
}

// getNLowString
// Number -> String
// Returns the Weather Low String from the
//   n'th forecast day
function getNLowString($n){
  $fday = $GLOBALS['forecast']->forecast->simpleforecast->forecastday;
  return join("",array("Low: ",$fday[$n]->low->fahrenheit," F (",
                        $fday[$n]->low->celsius," C)"));
}

// getNImageString
// Number -> ImageString
// Returns the icon string for the given
//    forecast day
function getNImageString($n){
  $fday = $GLOBALS['forecast']->forecast->simpleforecast->forecastday;
  return $fday[$n]->icon;
}

// getNWeatherString
// Number -> String
// Returns the weather string for the given
//     forecast day
function getNWeatherString($n){
  $fday = $GLOBALS['forecast']->forecast->simpleforecast->forecastday;
  return $fday[$n]->conditions;
}
?>
