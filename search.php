<?php
$file = file_get_contents("json/searchProgram.json");
$file = json_decode($file, true);
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
  <link rel="icon" href="img/Sherpa_Logo2.png">
  <title>Sherpa - Pathway Search</title>
</head>
<a onClick=history.back()><img class="badge2" src="img/Sherpa_Logo2.png"></a>
<h8><--- Click SHERPA logo to go back to home screen and update classes (progress should autosave)</h8>
<body style="display: none">
  <?php
  $percentCheck = false;
  foreach ($file as $y) {
  ?>
    <div class="header" style="background-color:<?= $y[0]['color'] ?> ">
      <div class="container">
        <div class="img">
          <a href="<?= $y[0]['url'] ?> " target="_blank"><img class="img" style="border-radius: 50%; border: 5px solid black;" src="<?= $y[0]['logo'] ?>"></a>
        </div>
        <div class="text">
          <h3 style="font-size: 40px;"><?= $y[0]['name'] ?></h3>
        </div>
      </div>
    </div>
    <div class="grid-container">
      <?php
      $allClasses = file_get_contents('json/allClasses.json');
      $allClasses = json_decode($allClasses, true);
      foreach ($y[0]['id'] as $z) {
        $pathway = file_get_contents("json/" . $z . ".json");
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
        for ($i = 0; $i < count($pathway); $i++) {
          //echo $pathway[$i];
          for ($j = 0; $j < 1; $j++) {
            //echo $pathway[$i]['creditType'];
            //echo " ";
            if ($pathway[$i]['creditType'] == 'f') {
              array_push($foundation, $pathway[$i]['classId']);
            }
            if ($pathway[$i]['creditType'] == 's') {
              array_push($supporting, $pathway[$i]['classId']);
            }
            if ($pathway[$i]['creditType'] == 'F#') {
              $foundationMin = floatval($pathway[$i][('credit')]);
              //echo $foundationMin;
            }
            if ($pathway[$i]['creditType'] == 'S#') {
              $supportingMin = floatval($pathway[$i][('credit')]);
              //echo $supportingMin;
            }
          }
        }
        //This $POST command grabs the array from the previous page, index.php and passes it to this one
        //It passes both the year long classes and the semester long classes
        $foundationClasses = array();
        $supportingClasses = array();
        $recommendedFClasses = array();
        $recommendedSClasses = array();
        $pathwayName = " ";
        $foundationCount = 0.0;
        $supportingCount = 0.0;
        //checking original classes to see if they are in pathways or not
        for ($i = 0; $i < count($_POST); $i++) {
          if (!isset($_POST[$i])) continue;
          for ($j = 0; $j < count($pathway); $j++) {
            if (!isset($pathway[$j])) continue;
            if ($_POST[$i] == $pathway[$j][('classId')]) {
              if ($pathway[$j][('creditType')] == ('f')) {
                $foundationCount = $foundationCount + $pathway[$j][('credit')];
                array_push($foundationClasses, $pathway[$j][('name')]);
              }
              if ($pathway[$j][('creditType')] == ('s')) {
                $supportingCount = $supportingCount + $pathway[$j][('credit')];
                array_push($supportingClasses, $pathway[$j][('name')]);
              }
            }
          }
        }

        //iteration through list checking for 'b' flag and placing the class based in foundation or supporting
        //depending on whether or not foundation is full or not
        for ($i = 0; $i < count($_POST); $i++) {
          if (!isset($_POST[$i])) continue;
          for ($j = 0; $j < count($pathway); $j++) {
            if (!isset($pathway[$j])) continue;
            if ($_POST[$i] == $pathway[$j][('classId')]) {
              if (($pathway[$j][('creditType')] == ('b')) && (round(($foundationCount / $foundationMin) * 100) < 100)) {
                $foundationCount = $foundationCount + $pathway[$j][('credit')];
                array_push($foundationClasses, $pathway[$j][('name')]);
              } else if (($pathway[$j][('creditType')] == ('b')) && (round(($foundationCount / $foundationMin) * 100) >= 100)) {
                $supportingCount = $supportingCount + $pathway[$j][('credit')];
                array_push($supportingClasses, $pathway[$j][('name')]);
              }
            }
          }
        }
        //calculating total percentage completion of pathway
        $totalPathway = $foundationMin + $supportingMin;
        if ($foundationCount > $foundationMin) {
          $foundationCount = $foundationMin;
        }
        if ($supportingCount > $supportingMin) {
          $supportingCount = $supportingMin;
        }
        //calculating percentages for each pathway
        $percent = round((($foundationCount + $supportingCount) / $totalPathway) * 100) . "%";
        $foundationPercent = round(($foundationCount / $foundationMin) * 100) . "%";
        $supportingPercent = round(($supportingCount / $supportingMin) * 100) . "%";

        if (round((($foundationCount + $supportingCount) / $totalPathway) * 100) >= 100) {
          $percentCheck = true;
        }
        //recommended classes checking through classIds
        for ($j = 0; $j < count($pathway); $j++) {
          if (!isset($pathway[$j])) continue;
          if ($pathway[$j][('creditType')] == ('b')) {
            array_push($recommendedFClasses, $pathway[$j][('classId')]);
          }
          if ($pathway[$j][('creditType')] == ('s')) {
            array_push($recommendedSClasses, $pathway[$j][('classId')]);
          }
        }
        for ($i = 0; $i < count($_POST); $i++) {
          if (!isset($_POST[$i])) continue;
          for ($j = 0; $j < count($recommendedFClasses); $j++) {
            if (!isset($recommendedFClasses[$j])) continue;
            if ($_POST[$i] == $recommendedFClasses[$j]) {
              unset($recommendedFClasses[$j]);
              $recommendedFClasses = array_values($recommendedFClasses);
            }
          }
          for ($j = 0; $j < count($recommendedSClasses); $j++) {
            if (!isset($recommendedSClasses[$j])) continue;
            if ($_POST[$i] == $recommendedSClasses[$j]) {
              unset($recommendedSClasses[$j]);
              $recommendedSClasses = array_values($recommendedSClasses);
            }
          }
        }
        $finalRFClasses = array();
        $finalRSClasses = array();
        //parsing each recommended array Id back into name form
        for ($i = 0; $i < count($recommendedFClasses); $i++) {
          for ($j = 0; $j < count($allClasses); $j++) {
            if ($recommendedFClasses[$i] == $allClasses[$j]['id']) {
              array_push($finalRFClasses, $allClasses[$j]['name']);
            }
          }
        }
        for ($i = 0; $i < count($recommendedSClasses); $i++) {
          for ($j = 0; $j < count($allClasses); $j++) {
            if ($recommendedSClasses[$i] == $allClasses[$j]['id']) {
              array_push($finalRSClasses, $allClasses[$j]['name']);
            }
          }
        }

        //finding pathway name
        for ($j = 0; $j < count($pathway); $j++) {
          if ($pathway[$j][('creditType')] == ('NAME')) {
            $pathwayName = $pathway[$j][('name')];
          }
        }
      ?>
        <div class="path1">
          <h2>
            <p style="color: blue; font-size:20px"><u><?php echo $pathwayName ?> </u></p>
            <p style=font-size:18px><mark>Pathway Progress: <?= $percent ?> Completed</mark></p>
            <p><i>Foundation Classes: <?= $foundationPercent ?> Completed</p>
            <p>Supporting Classes: <?= $supportingPercent ?> Completed</i></p>
          </h2>
          <ul>
            <p2 style=font-size:18px;background-color:#C7C9C8;color:black;><u>Completed Foundation Classes (Listed Below): <?= $foundationCount ?> credits / <?= $foundationMin ?> credits</u></p2>
            <p><?php
                if (count($foundationClasses) > 0) {
                  foreach ($foundationClasses as $x) {
                    echo '<li>' . $x . '</li>';
                  }
                } else {
                  echo '<li>' . "No selected classes qualify here!" . '</li>';
                }
                ?></p>
            <p>
            <details>
              <summary class="recommendedClassesDrop"><b>Recommended Classes (Click Here To View)</b></summary>
              <p>
                <?php
                for ($i = 0; $i < count($finalRFClasses); $i++) {
                  echo '<li>' . $finalRFClasses[$i] . '</li>';
                }
                ?>
              </p>
            </details>
            </p>
            <p2 style=font-size:18px;background-color:#C7C9C8;color:black;><u>Completed Supporting Classes (Listed Below): <?= $supportingCount ?> credits / <?= $supportingMin ?> credits</u></p2>
            <p><?php
                if (count($supportingClasses) > 0) {
                  foreach ($supportingClasses as $x) {
                    echo '<li>' . $x . '</li>';
                  }
                } else {
                  echo '<li>' . "No selected classes qualify here!" . '</li>';
                }
                ?></p>
            <details>
              <summary class="recommendedClassesDrop"><b>Recommended Classes (Click Here To View)</b></summary>
              <p>
                <?php
                for ($i = 0; $i < count($finalRSClasses); $i++) {
                  echo '<li>' . $finalRSClasses[$i] . '</li>';
                }
                ?>
              </p>
            </details>
            </p>
          </ul>
        </div>
      <?php
      }
      ?>
    </div>
  <?php
  }
  //FOR IDS PATHWAY CODE STARTS HERE
  $file = file_get_contents("json/IDSsearchProgram.json");
  $file = json_decode($file, true);
  $percentageCheck = 0;
  $checkPrint = "";
  $checkColor = "";
  if ($percentCheck == false) {
    $checkPrint2 = "YES";
    $checkColor2 = "#04A731";
  }
  if ($percentCheck == true) {
    $checkPrint2 = "NO";
    $checkColor2 = "#bf2121";
  }
  foreach ($file as $y) {
  ?>
    <p style="font-family: Arial; color:black; font-size: 25px"><mark>Not sure what IDS is? Click <a href='https://docs.google.com/document/d/1Sb5T9UpqaVv87lefkwTaRzjJZBBoecEDOivG_zqZh9k/edit?usp=sharing' target="_blank"><b>HERE</b></a> to check wiki. Scroll to the bottom of the FRQ and find highlighted portion. </mark></p>
    <h5 style="font-family: Arial"><mark> Do I Qualify for IDS? </mark></h5>
    <h4 style="color: <?= $checkColor2 ?>"><b> <?php echo $checkPrint2 ?> </b> </h4>
    <p style="font-size: 25px"><mark> <b>NOTE:</b> While it may say you've completed IDS below, you, yourself, still need to verify the requirement above certain Academies to ensure that you still qualify! </mark></p>
    <div class="header" style="background-color:<?= $y[0]['color'] ?> ">
      <div class="container">
        <div class="img">
          <a href="<?= $y[0]['url'] ?> " target="_blank"><img class="img" style="border-radius: 50%; border: 5px solid black;" src="<?= $y[0]['logo'] ?>"></a>
        </div>
        <div class="text">
          <h3 style="font-size: 40px;"><?= $y[0]['name'] ?></h3>
        </div>
      </div>
    </div>
    <div class="grid-container">
      <?php
      $allClasses = file_get_contents('json/allClasses.json');
      $allClasses = json_decode($allClasses, true);
      foreach ($y[0]['id'] as $z) {

        $pathway = file_get_contents("json/" . $z . ".json");
        $pathway = json_decode($pathway, true);
        //array of foundation classes possible for this pathway
        $foundation = array();
        //minimum number of credits needed for foundation in this pathway
        $foundationMin = 0.0;
        $partText = "";
        for ($i = 0; $i < count($pathway); $i++) {
          for ($j = 0; $j < 1; $j++) {
            if ($pathway[$i]['creditType'] == 'f') {
              array_push($foundation, $pathway[$i]['classId']);
            }
            if ($pathway[$i]['creditType'] == 'F#') {
              $foundationMin = floatval($pathway[$i][('credit')]);
            }
            if ($pathway[$i]['creditType'] == 'r') {
              $partText = $pathway[$i][('name')];
            }
          }
        }
        //This $POST command grabs the array from the previous page, index.php and passes it to this one
        //It passes both the year long classes and the semester long classes
        $foundationClasses = array();
        $recommendedFClasses = array();
        $pathwayName = " ";
        $foundationCount = 0.0;
        //checking original classes to see if they are in pathways or not
        for ($i = 0; $i < count($_POST); $i++) {
          if (!isset($_POST[$i])) continue;
          for ($j = 0; $j < count($pathway); $j++) {
            if (!isset($pathway[$j])) continue;
            if ($_POST[$i] == $pathway[$j][('classId')]) {
              if ($pathway[$j][('creditType')] == ('f')) {
                $foundationCount = $foundationCount + $pathway[$j][('credit')];
                array_push($foundationClasses, $pathway[$j][('name')]);
              }
            }
          }
        }
        //calculating total percentage completion of pathway
        if ($foundationCount > $foundationMin) {
          $foundationCount = $foundationMin;
        }
        //calculating percentages for each pathway
        $foundationPercent = round(($foundationCount / $foundationMin) * 100) . "%";
        $percentageCheck = $percentageCheck + ($foundationCount / $foundationMin);
        //recommended classes checking through classIds
        for ($j = 0; $j < count($pathway); $j++) {
          if (!isset($pathway[$j])) continue;
          if ($pathway[$j][('creditType')] == ('f')) {
            array_push($recommendedFClasses, $pathway[$j][('classId')]);
          }
        }
        for ($i = 0; $i < count($_POST); $i++) {
          if (!isset($_POST[$i])) continue;
          for ($j = 0; $j < count($recommendedFClasses); $j++) {
            if (!isset($recommendedFClasses[$j])) continue;
            if ($_POST[$i] == $recommendedFClasses[$j]) {
              unset($recommendedFClasses[$j]);
              $recommendedFClasses = array_values($recommendedFClasses);
            }
          }
        }
        $finalRFClasses = array();
        //parsing each recommended array Id back into name form
        for ($i = 0; $i < count($recommendedFClasses); $i++) {
          for ($j = 0; $j < count($allClasses); $j++) {
            if ($recommendedFClasses[$i] == $allClasses[$j]['id']) {
              array_push($finalRFClasses, $allClasses[$j]['name']);
            }
          }
        }
        //finding pathway name
        for ($j = 0; $j < count($pathway); $j++) {
          if ($pathway[$j][('creditType')] == ('NAME')) {
            $pathwayName = $pathway[$j][('name')];
          }
        }
      ?>
        <div class="path2">
          <h2>
            <p style="color: blue;font-size:20px"><u><?php echo $pathwayName ?> </u></p>
            <p style=font-size:18px><i><mark>Classes: <?= $foundationPercent ?> Completed</mark></p>
            <p><mark> <?php echo $partText ?> </mark></i></p>
          </h2>
          <ul>
            <p2 style=font-size:18px;background-color:#C7C9C8;color:black;><u>Completed Classes (Listed Below): <?= $foundationCount ?> credits / <?= $foundationMin ?> credits</u></p2>
            <p><?php
                if (count($foundationClasses) > 0) {
                  foreach ($foundationClasses as $x) {
                    echo '<li>' . $x . '</li>';
                  }
                } else {
                  echo '<li>' . "No selected classes qualify here!" . '</li>';
                }
                ?></p>
            <p>
            <details>
              <summary class="recommendedClassesDrop"><b>Recommended Classes (Click Here To View)</b></summary>
              <p>
                <?php
                for ($i = 0; $i < count($finalRFClasses); $i++) {
                  echo '<li>' . $finalRFClasses[$i] . '</li>';
                }
                ?>
              </p>
            </details>
            </p>
          </ul>
        </div>
      <?php
      }
      ?>
    </div>
  <?php
    if ($percentageCheck >= 4) {
      $checkPrint = "IDS Completed";
      $checkColor = "lime";
    }
    if ($percentageCheck < 4) {
      $checkPrint = "IDS Not Completed";
      $checkColor = "#bf2121";
    }
  }
  ?>
  <h4 style="color: <?= $checkColor ?> ">(<?= $checkPrint ?>)</h4>
</body>
</html>
<style>
  img {
    width: 200px;
    height: auto;
    max-width: 100%;
    max-height: 100%;
  }
  .badge2 {
    max-width: 100%;
    max-height: 100%;
    height: auto;
    width: 150px;
    vertical-align: top;
    position: absolute;
    left: 1px;
  }
  .header {
    padding: 10px;
    display: flex;
    border-radius: 360px;
    margin-top: 10px;
  }
  h8{
    background-color: yellow;
    font-size: 20px;
  }
  h3 {
    flex-grow: 1;
    font-size: 25px;
    text-align: center;
    color: white;
    padding: 25px;
  }
  h4 {
    flex-grow: 1;
    font-size: 40px;
    text-align: center;
  }
  h5 {
    flex-grow: 1;
    font-size: 25px;
    text-align: center;
    color: white;
    padding: 5px;
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
    text-align: center;
    font-family: arial;
    font-size: 16px;
    color: black;
    text-indent: 25px;
  }
  .p2 {
    text-align: center;
    font-family: arial;
    font-size: 16px;
    color: black;
    text-indent: 25px;
  }
  h2 {
    text-align: center;
    color: black;
    font-family: lato;
    font-size: 20px;
  }
  .p3 {
    text-align: left;
    font-family: arial;
    font-size: 16px;
    color: black;
    text-indent: 25px;
  }
  .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 10px;
    margin-bottom: 100px;
  }
  .container {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .text {
    padding-left: 100px;
  }
  form {
    display: none;
  }
  .recommendedClassesDrop {
      cursor: pointer;
  }
</style>
<script>
  document.getElementsByTagName('body')[0].style = 'display: block';
</script>