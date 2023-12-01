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
<a href="https://gmhspathwayprecheck.fly.dev/"><img class="badge2" src="img/Sherpa_Logo2.png"></a>
<body style="display: none">
  <?php
  foreach ($file as $y) {
  ?>
    <div style="background-color:<?= $y[0]['color'] ?> " class="header"><a href="<?= $y[0]['url'] ?> " target="_blank"><img class="badge" style = "border-radius: 50%; border: 5px solid black" src="<?= $y[0]['logo'] ?>"></a>
    <h3><?= $y[0]['name'] ?></h3>
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
        //calculating total percentage completion of pathway
        $totalPathway = $foundationMin + $supportingMin;
        if ($foundationCount > $foundationMin) {
          $foundationCount = $foundationMin;
        }
        if ($supportingCount > $supportingMin) {
          $supportingCount = $supportingMin;
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
        //calculating percentages for each pathway
        $percent = round((($foundationCount + $supportingCount) / $totalPathway) * 100) . "%";
        $foundationPercent = round(($foundationCount / $foundationMin) * 100) . "%";
        $supportingPercent = round(($supportingCount / $supportingMin) * 100) . "%";        
        //recommended classes checking through classIds
        for ($j = 0; $j < count($pathway); $j++) {
          if (!isset($pathway[$j])) continue;
          if ($pathway[$j][('creditType')] == ('f')) {
            array_push($recommendedFClasses, $pathway[$j][('classId')]);
          }
          if ($pathway[$j][('creditType')] == ('s')) {
            array_push($recommendedSClasses, $pathway[$j][('classId')]);
          }
          if (($pathway[$j][('creditType')] == ('b')) && (round(($foundationCount / $foundationMin) * 100) < 100)) {
            array_push($recommendedSClasses, $pathway[$j][('classId')]);
          }
          if (($pathway[$j][('creditType')] == ('b')) && (round(($foundationCount / $foundationMin) * 100) >= 100)) {
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
            <p style="color: blue;"><u><?php echo $pathwayName ?> </u></p>
            <p>Pathway Progress: <?= $percent ?> Completed</p>
            <p><i><mark>Foundation Classes: <?= $foundationPercent ?> Completed</mark></p>
            <p><mark>Supporting Classes: <?= $supportingPercent ?> Completed</mark></i></p>
          </h2>
          <ul>
            <p2><i><u>Completed Foundation Classes:</i></u></p2>
            <p><?php
                foreach ($foundationClasses as $x) {
                  echo '<li>' . $x . '</li>';
                }
                ?></p>
            <p>
            <details>
              <summary><b>Recommended Classes</b></summary>
              <p>
                <?php
                for ($i = 0; $i < count($finalRFClasses); $i++) {
                  echo '<li>' . $finalRFClasses[$i] . '</li>';
                }
                ?>
              </p>
            </details>
            </p>
            <p2><i><u>Completed Supporting Classes:</i></u></p2>
            <p><?php
                foreach ($supportingClasses as $x) {
                  echo '<li>' . $x . '</li>';
                }
                ?></p>
            <details>
              <summary><b>Recommended Classes</b></summary>
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
  ?>
</body>
</html>
<style>
  .badge {
    max-width: 20%;
    height: auto;
    width: auto;
  }
  .badge2 {
    max-width: 8%;
    height: auto;
    width: auto;
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
  h3 {
    flex-grow: 1;
    font-size: 25px;
    text-align: center;
    color: white;
    padding: 25px;
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
  form {
    display: none;
  }
</style>
<script>
  document.getElementsByTagName('body')[0].style = 'display: block';
</script>