<?php


//function for pulling classes from google sheet
function csvToArray($file, $delimiter){
  if (($handle = fopen($file, 'r')) !== FALSE){
    $i = 0;
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
      for ($j = 0; $j < count($lineArray); $j++){
        $arr[$i][$j] = $lineArray[$j];
      }
      $i++;
    }
    fclose($handle);
  }
  return $arr;
}







$file2 = file_get_contents("json/sheetUrls.json");
$file2 = json_decode($file2, true);

foreach($file2 as $yy){
foreach($yy[0]['url'] as $zz){
  
//main issue at the moment. Can't seem to pass url from json to $feed variable below successfully


//array grabber adapted from: https://www.ravelrumba.com/blog/json-google-spreadsheets/

$feed = $zz;
$keys = array();
$newArray = array();

//function for csvToArray was moved above foreach loop

// Do it
$data = csvToArray($feed, ',');
 
// Set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1;
 
//Use first row for names  
$labels = array_shift($data);  
 
foreach ($labels as $label) {
  $keys[] = $label;
}
 
// Add Ids, just in case we want them later
$keys[] = 'id';
 
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}
 
// Bring it all together
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  
  $newArray[$j] = $d;
}
 
// Print it out as JSON
//echo json_encode($newArray);
// writeJson adapted from: https://stackoverflow.com/questions/57731341/how-to-push-a-new-object-into-a-json-file-using-php
$writeJson = file_put_contents('json/'. $yy[0]['jsonName'] .'.json', json_encode($newArray));
}
}


//new array grabber to grab all possible classes.
//array grabber adapted from: https://www.ravelrumba.com/blog/json-google-spreadsheets/
$feed = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQowsFTPvKhT-1F2bg8yHsGZLWMW924YhMZbFrWOP-AdpEiXsx9ywsGYj6aDJhM57xDO8caEeflDzat/pub?output=csv';
$keys = array();
$newArray = array();

function csvToArray2($file, $delimiter){
  if (($handle = fopen($file, 'r')) !== FALSE){
    $i = 0;
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
      for ($j = 0; $j < count($lineArray); $j++){
        $arr[$i][$j] = $lineArray[$j];
      }
      $i++;
    }
    fclose($handle);
  }
  return $arr;
}

// Do it
$data = csvToArray2($feed, ',');
 
// Set number of elements (minus 1 because we shift off the first row)
$count = count($data) - 1;
 
//Use first row for names  
$labels = array_shift($data);  
 
foreach ($labels as $label) {
  $keys[] = $label;
}
 
// Add Ids, just in case we want them later
/*$keys[] = 'id';
 
for ($i = 0; $i < $count; $i++) {
  $data[$i][] = $i;
}*/
 
// Bring it all together
for ($j = 0; $j < $count; $j++) {
  $d = array_combine($keys, $data[$j]);
  
  $newArray[$j] = $d;
}
 
// Print it out as JSON
//echo json_encode($newArray);

// writeJson adapted from: https://stackoverflow.com/questions/57731341/how-to-push-a-new-object-into-a-json-file-using-php
$writeJson = file_put_contents("json/allClasses.json", json_encode($newArray));

?>