<?php
$file = file_get_contents("json/searchProgram.json");
$file = json_decode($file, true);



//Year long classes are marked with a -2 instead of -1 in classes.json
//$yearLong = array(3, 6, 17);
//$semesterLong = array(4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15);
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
  <title>Sherpa - Pathway Search</title>
</head>

<body style="display: none">
  <?php
foreach($file as $y){
    ?>
    
      <div style="background-color:<?= $y[0]['color'] ?> " class="header"><a href="<?= $y[0]['url'] ?>"><img class="badge" src="<?= $y[0]['logo'] ?>"></a>
    <h3><?= $y[0]['name'] ?></h3>
  </div>
  <div class="grid-container">
      
    <?php

foreach($y[0]['id'] as $z){
$pathway = file_get_contents("json/". $z .".json");
$pathway = json_decode($pathway, true);


//array of foundation classes possible for this pathway
$foundation = array();
//minimum number of credits needed for foundation in this pathway
$foundationMin = 0.0;
//array of supporting classes possible for this pathway
$supporting = array();
//minimum number of credits needed for supporting in this pathway
$supportingMin = 0.0;
//echo $pathway[0]['classId'];
for($i=0; $i<count($pathway); $i++){
  //echo $pathway[$i];
  for($j=0; $j<1; $j++){
    //echo $pathway[$i]['creditType'];
    //echo " ";
    if ($pathway[$i]['creditType']=='f'){
      array_push($foundation, $pathway[$i]['classId']);
    }
    if ($pathway[$i]['creditType']=='s'){
      array_push($supporting, $pathway[$i]['classId']);
    }
    if ($pathway[$i]['creditType']=='F#'){
      $foundationMin = floatval($pathway[$i][('credit')]);
      //echo $foundationMin;
    }
    if ($pathway[$i]['creditType']=='S#'){
      $supportingMin = floatval($pathway[$i][('credit')]);
      //echo $supportingMin;
    }
  }
}
/*for($i=0; $i<count($foundation); $i++){
  echo $foundation[$i];
  echo " ";
}
for($i=0; $i<count($supporting); $i++){
  echo $supporting[$i];
  echo " ";
}*/


//This $POST command grabs the array from the previous page, index.php and passes it to this one
//It passes both the year long classes and the semester long classes
array_shift($_POST);
array_shift($_POST);
$completedClasses = array();
$foundationCount = 0.0;
$supportingCount = 0.0;
for($i=0; $i<count($_POST); $i++){
  for($j=0; $j<count($pathway); $j++){
    if($_POST[$i]==$pathway[$j][('classId')]){
      if($pathway[$j][('creditType')]==('f')){
        $foundationCount = $foundationCount + $pathway[$j][('credit')];
      }
      if($pathway[$j][('creditType')]==('s')){
        $supportingCount = $supportingCount + $pathway[$j][('credit')];
      }
      array_push($completedClasses, $pathway[$j][('name')]);
    }
  }
}

/*echo ("Foundation Credits: $foundationCount");
echo ("_________");
echo ("Supporting Credits: $supportingCount");*/


//calculating total percentage completion of pathway
$totalPathway = $foundationMin + $supportingMin;
$percent = (($foundationCount + $supportingCount)/$totalPathway)*100;


?>





<!--$required = $pathway['credits'][0];
$credFoundation = $required['foundation'];
$credSupporting = $required['supporting'];

$completedClasses = array();

// foundation 
foreach($yearLong as $x ) {
    if(isset($foundation[$x])){
        array_push($completedClasses, $foundation[$x][0]['name']);
        unset($foundation[$x]);
        $credFoundation = $credFoundation - 1;
    }
}
foreach($semesterLong as $x ) {
    if(isset($foundation[$x])){
        array_push($completedClasses, $foundation[$x][0]['name']);
        unset($foundation[$x]);
        $credFoundation = $credFoundation - 0.5;
    }
}
// supporting
foreach($yearLong as $x ) {
    if(isset($supporting[$x])){
        array_push($completedClasses, $supporting[$x][0]['name']);
        unset($supporting[$x]);
        $credSupporting = $credSupporting - 1;
    }
}
foreach($semesterLong as $x ) {
    if(isset($supporting[$x])){
        array_push($completedClasses, $supporting[$x][0]['name']);
        unset($supporting[$x]);
        $credSupporting = $credSupporting - 0.5;
    }
}

// both
foreach($yearLong as $x ) {
    if(isset($both[$x])){
        array_push($completedClasses, $both[$x][0]['name']);
        unset($both[$x]);
        if($credSupporting > $credFoundation){
            $credSupporting = $credSupporting - 1;
        }
        else {
            $credFoundation = $credFoundation - 1;
        }
    }
}
foreach($semesterLong as $x ) {
    if(isset($both[$x])){
        array_push($completedClasses, $both[$x][0]['name']);
        unset($both[$x]);
        if($credSupporting > $credFoundation){
            $credSupporting = $credSupporting - 0.5;
        }
        else {
            $credFoundation = $credFoundation - 0.5;
        }
    }
}
    $credFoundation = max($credFoundation, 0);
    $credSupporting = max($credSupporting, 0);
  $percent = round(100*(1-(($credFoundation + $credSupporting)/($required['foundation'] + $required['supporting'])))) . '%';
    ?>
-->
    <div class="path1">
      <h2><?= $pathway['pathway'] ?>
      <p>Pathway <?= $percent ?>% Completed</p>
      </h2>
      <ul>
        <?php
            foreach($completedClasses as $x){
                echo '<li>'. $x .'</li>';
            }
            
        ?>
      </ul>
    </div>
    <?php
    
}
?>

  </div>

<?php
}
  ?>
</body>
</html>


<style>
.badge {
    max-width: 15%;
    height: auto;
    width: auto;
}
.header {
  padding: 10px;
  display: flex;
    border-radius: 360px;
    margin-top: 10px;
}
.header h3 {
  flex-grow: 1;
  text-align: right;
  color: white;
  padding: 16px;
}

body {
  background-color: white;
  max-width: 1250px;
  width: 90%;
  margin: 0 auto;
}
h1 {
  text-align: left;
  text-decoration: underline;
  color: #ce9dd9;
  font-family: lato;
  font-size: 35px;
}
p {
  text-align: left;
  font-family: arial;
  font-size: 16px;
  color: black;
  text-indent: 25px;
}
p2 {
  text-align: right;
  font-family: arial;
  font-size: 16px;
  color: black;
  text-indent: 25px;
}
h2 {
  text-align: left;
  color: black;
  font-family: lato;
  font-size: 20px;
}

.grid-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 10px;
  margin-bottom: 100px;
}
form {
    display: none;
}
</style>
<script>
    document.getElementsByTagName('body')[0].style = 'display: block';
</script> 