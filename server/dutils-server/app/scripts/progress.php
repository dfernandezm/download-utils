<?php

$currentMessage = "";

function updateLogLine($message)
{
        global $currentMessage;
        $currentMessageLength = strlen($currentMessage);

        for ($n = 0; $n < $currentMessageLength; $n++)
        {
            echo chr(8) . " " . chr(8);
        }

        $currentMessage = $message;
        echo $message;
}


function readBackwards($filePath) {

    $fp = fopen("$filePath", 'r');
    $pos = -2; // Skip final new line character (Set to -1 if not present)

    $currentLine = '';

    $continue = true;
    $timeText = "";

    while (-1 !== fseek($fp, $pos, SEEK_END) && $continue) {
        $char = fgetc($fp);

        if ('t' == $char && strpos($timeText,"ime") !== false) {
            $continue = false;
            $timeText = $char . $timeText;
        } else {
            $timeText = $char . $timeText;
        }

        $pos--;
    }

    return $timeText;
};

//Progress

$contents = file_get_contents("/home/david/scripts/ffmpeg_output3.log");

$matchesDuration = array();

if (preg_match('/Duration:[\s]+([0-9]+):([0-9]+):([0-9]+)/', $contents, $matchesDuration)) {

   $totalHours = $matchesDuration[1];
   $totalMinutes = $matchesDuration[2];
   $totalSeconds = $matchesDuration[3];

   $totalDuration = $totalHours*3600 + $totalMinutes*60 + $totalSeconds;

   //echo "Total duration: $totalDuration seconds \n";
}

$ffmpegLogFilePath = "/home/david/scripts/ffmpeg_output3.log";

while (true) {

 $contents = readBackwards($ffmpegLogFilePath);

 $matches = array();

 if (preg_match('/time=([0-9]+):([0-9]+):([0-9]+)/', $contents, $matches)) {

    $hours = $matches[1];
    $minutes = $matches[2];
    $seconds = $matches[3];

    // echo "Hours $hours - Minutes $minutes - Seconds $seconds \n";

    $currentDuration = $hours*3600 + $minutes*60 + $seconds;

    //echo "Total duration: $currentDuration \n";

    $percent = ($currentDuration*100)/$totalDuration;
    $percentFormatted = number_format($percent, 0, '.', '');

    $barIni = "$percentFormatted% - [";
    $bar = "";
    $barFin = "]";

    for ($j = 0; $j < 100; $j++) {

        if ($j <= $percentFormatted) {
          $bar = $bar . "=";
        }
        else {
            $bar = $bar . " ";
        }
    }

    $newBar = $barIni . $bar . $barFin;

    updateLogLine($newBar);

    //file_put_contents("/home/david/scripts/progress.progress","$percentFormatted %");

 }

 sleep(1);

}
