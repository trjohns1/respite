<?php

function isValidDate($date) {
// Returns true if $date is a valid date string
	if(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) {
		if(checkdate($matches[2], $matches[3], $matches[1])) {
			return true;
		}
	}
   else {
      return false;
   }
}


function isValidDatetime($datetime) {
// Returns true if $datetime is a valid datetime string.
   $dateValid = false;
   $timeValid = false;
   // Check that all the elements parse
	if(preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?Z$/', $datetime, $matches)) {
      // Check that the date portion is valid
		if(checkdate($matches[2], $matches[3], $matches[1])) {
			$dateValid = true;
		}
      // Check that the time portion is valid
      if (
            $matches[4] >= 0 && $matches[4] <= 23
         && $matches[5] >= 0 & $matches[5] <= 59
         ) {
         $timeValid = true;
      }
	}
   if($dateValid && $timeValid) {
      return true;
   }
   else {
      return false;
   }
}


function isValidDatetimeLocal($datetime) {
// Returns true if $datetime is a valid datetime string.
   $dateValid = false;
   $timeValid = false;
   // Check that all the elements parse
	if(preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?$/', $datetime, $matches)) {
      // Check that the date portion is valid
		if(checkdate($matches[2], $matches[3], $matches[1])) {
			$dateValid = true;
		}
      // Check that the time portion is valid
      if (
            $matches[4] >= 0 && $matches[4] <= 23
         && $matches[5] >= 0 & $matches[5] <= 59
         ) {
         $timeValid = true;
      }
	}
   if($dateValid && $timeValid) {
      return true;
   }
   else {
      return false;
   }
}

function isValidMonth($month) {
// Returns true if $month is a valid date string
   $yearMin = - 9999;
   $yearMax = 9999;
	if(preg_match("/^(\d{4})-(\d{2})$/", $month, $matches)) {
      if($matches[1] > $yearMin && $matches[1] < $yearMax && $matches[2] > 0 && $matches[2] <= 12){
         return true;
      }
	}
   else {
      return false;
   }
}

function isValidTime($time) {
// Returns true if the time is valid, false otherwise
   if(strtotime($time)) {
      return true;
   }
   else {
      return false;
   }
}

function isValidWeek($week) {
// Returns true if $datetime is a valid datetime string.
   $yearMin = - 9999;
   $yearMax = 9999;
   // Check that all the elements parse
	if(preg_match('/^(\d{4})-W(\d{2})$/', $week, $matches)) {
      // Check that the inputs are in range
		if($matches[1] < $yearMin || $matches[1] > $yearMax || $matches[2] < 1 || $matches[2] > 52) {
         return false;
		}
      else {
         return true;
      }
   }
   else {
      return false;
   }
}
?>
