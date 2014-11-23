<?php

// getSVG
// String -> Image (SVG string)
// Returns an <img> tag containing
// the given svg file
// (NOTE: Input should NOT have ".svg" extenstion)
function getSVG($s){
  // SVG location
  $SVG_DIR = 'SVG/';
  return $SVG_DIR . $s . ".svg";
  // Produce appropriate SVG <img> tag
  //return '<img src="' . $SVG_DIR . $s . '.svg" alt="' . $s . '">';
}

// within
// Int Int Int -> Boolean
// Tests whether the first two numbers are within the given
// threshold of each other
function within($num1, $num2, $threshold){
  return abs($num1 - $num2) < $threshold;
}

// minutes
// Int -> Int
// Convenience function for converting minutes into
// timestamp units
function minutes($m){
  return $m * 60;
}

// getTOD
// String String -> String
// Returns the time of day, based on the given
// sunrise and sunset times
function getTOD($strSunrise, $strSunset){
  $curTime = time();
  $sunrise = strtotime($strSunrise, $curTime);
  $sunset  = strtotime($strSunset,  $curTime);
  // For dawn vs. dusk, etc.
  $morning = $curTime < strtotime("12:00:00", $curTime);
  // For day vs. night
  $earlyMorning = ($curTime < $sunrise);
  $night = ($curTime > $sunset);
  $withinEither = function($t){ 
    return within($sunrise, curTime, minutes($t)) || 
      within($sunset, curTime, minutes($t));
    };
  if ($withinEither(20)) {
    return ($morning) ? "dawn" : "dusk";
  }
  elseif ($withinEither(40)) {
    return ($morning) ? "sunrise" : "sunset";
  }
  elseif ($earlyMorning) {
    return "early-morning";
  }
  elseif ($night) {
    return "night";
  }
  else {
    return "day";
  }
}

// todSVG
// String String String String String -> Image (SVG string)
// Convenience function for time-dependent
// SVG returning
function todSVG($tod, $nightAndEarlyMorning, $dawnAndDusk, $sunriseAndSunset, $daytime){
  switch($tod){
    case "early-morning":
    case "night":
      return getSVG($nightAndEarlyMorning);
      break;
    case "dawn":
    case "dusk":
      return getSVG($dawnAndDusk);
      break;
    case "sunrise":
    case "sunset":
      return getSVG($sunriseAndSunset);
      break;
    case "day":
    default:
      return getSVG($daytime);
  }
}

// getClear
// String -> Image (SVG string)
// Returns the appropriate image for clear conditions
// using the given time of day
function getClear($tod){
  return todSVG($tod, 'Moon', 'Sun-Lower', 'Sun-Low', 'Sun'); 
}

// getPartlyCloudy
// String -> Image (SVG string)
// Returns the appropriate partly cloudy
// image based on the given time of day
function getPartlyCloudy($tod){
  return todSVG($tod, 'Cloud-Moon', 'Cloud', 'Cloud-Sun', 'Cloud-Sun');
}

// getMostlyCloudy
// String -> Image (SVG string)
// Returns the appropriate mostly cloudy
// image based on the given time of day
function getMostlyCloudy($tod){
  return todSVG($tod, 'Cloud-Fog-Moon-Alt', 'Cloud-Fog-Alt', 'Cloud-Fog-Sun-Alt', 'Cloud-Fog-Sun-Alt');
}



// weatherStringToImage
// String Boolean String String -> Image (SVG string)
// Returns the SVG string corresponding
//    to the given weather string, with
//    time dependent images if the second
//    argument is true (If the second parameter
//    is true, the third and fourth are expected
//    to be the sunrise and sunset times)
function weatherStringToImage($s, $timeDep, $sunrise = "", $sunset = ""){
  $tod = ($timeDep) ? getTOD($sunrise, $sunset) : "";
  switch($s){
    case "clear":
    case "sunny":
      return ($timeDep) ? getClear($tod) : getSVG('Sun');
      break;
    case "cloudy":
      return getSVG('Cloud');
      break;
    case "mostlysunny":
    case "partlycloudy":
      return ($timeDep) ? getPartlyCloudy($tod) : getSVG('Cloud-Sun');
      break;
    case "mostlycloudy":
    case "hazy":
    case "partlysunny":
      return ($timeDep) ? getMostlyCloudy($tod) : getSVG('Cloud-Sun');
      break;
    case "rain":
      return getSVG('Cloud-Drizzle');
      break;
    case "tstorms":
      return getSVG('Cloud-Lightning');
      break;
    case "sleet":
      return getSVG('Cloud-Hail');
      break;
    case "snow":
      return getSVG('Cloud-Snow');
      break;
    case "flurries":
      return getSVG('Cloud-Snow-Alt');
      break;
    case "fog":
      return getSVG('Cloud-Fog');
      break;
    case "hail":
      return getSVG('Cloud-Hail-Alt');
      break;
    // Who knows what it is? But I doubt it's good...
    default:
      return getSVG('Cloud-Rain');
  }
}

// sunrise, sunset
// Sunrise and Sunset Icons
$sunrise = getSVG('Sunrise');
$sunset  = getSVG('Sunset');
$moon    = getSVG('Moon');
