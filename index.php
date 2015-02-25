<?php
session_start();
$_SESSION["user"];
$_SESSION["assignmentID"];
$assignmentID = $_SESSION["assignmentID"];

//To be set by configuration file
$assignmentName = "H-212: Rotational Kinetic Energy and Angular Momentum";
$userFullName = "Eric Volpert";
$pretext = "This is a homework assignment. Answer all questions online and in your notebook. (Get all answers correct in one attempt - not one attempt per question, but one attempt for then ENTIRE assignment - to earn a prize!). <a href='https://drive.google.com/a/asl.org/file/d/0BxqMEow9CvdRb2ZHWkJWZ2dnNFE/view?usp=sharing'>Diagram of angular inertias</a>.";
$assignmentID = "H-212";
date_default_timezone_set('GMT');
$date = date('d/m/Y h:i a ');

function getQuestions(){
  global $assignmentID;
  $configFile = fopen($assignmentID . ".cfg", "r") or die("Unable to open file!");
  $fullConfigString = "";

  while(!feof($configFile)) {
    $fullConfigString .= (fgets($configFile));
  }
  $questions = explode(";", $fullConfigString);

  for($i = 0; $i < count($questions); $i++){
    $tempQuestion = explode(":", $questions[$i]);
    echo "<tr>";
      for($j = 0; $j < 4; $j++){
        echo "<td>";
        if($j == 2){
          echo "<input type='text' class='form-control' id='Answer-".($i + 1)."'>";

        //This was a massive pain in the ass to program so I'll go over each thing carefully
        //Checking if it's the 'Question' part of the configuration
        }else if($j == 1){
          //Splits the string into an array of strings for every time it sees '%%' (Meaning a random number wants to be made)
          $tempArray =  explode("%%", $tempQuestion[$j]);
          $roundArray = parseTotalRands($tempArray, $l, $i);
          
          $roundString = implode($roundArray);
          $roundArray2 = explode("$$", $roundString);
          parseRoundRands($roundArray2, $l, $i);
          
          
        }
        else{
          echo $tempQuestion[$j];
        }
        
        echo "</td>";
      }
      echo "<td><button class='btn btn-warning check-button' data-questionnum='".($i +1)."'>Check</button></td>";
    echo "</tr>";
  }


  fclose($configFile);
}

function frand($passedArray) {
  $min = intval($passedArray[0]);
  $max = intval($passedArray[1]);
  $decimals = intval($passedArray[2]);
  $scale = pow(10, $decimals);
  return mt_rand($min * $scale, $max * $scale) / $scale;
}

function storeRand($rand, $qnum, $varnum){
//Store the randomly generated number in the user's database for given assignment and question number and variable number
$user = $_SESSION["user"];
$assignment = $_SESSION["assignmentID"];
$sql = "Insert into variables (user, assignment, rand, qnum, varnum) values (:user, :assignment, :rand, :qnum, :varnum);";


}

function parseTotalRands($tempArray, $l, $i){
      //Starts a for loop to run through this array of exploded strings, starting with text and changing to a number every time it sees %%, then back to text again
          for($l = 0; $l < count($tempArray); $l ++){
            //Checking if l is odd, if so, it will do the random number generation
            if($l % 2 != 0){
              //Explode the string into a new array (of integers styled 'min,max,decimals')
            $tempArray2 = explode(",",$tempArray[$l]);
            //Generate the random number for this set of inputs
            $randomNumber = frand($tempArray2);
            //Pass the generated random number into the user's database
            storeRand($randomNumber, $i, (($l-1)/2));
            //Echo that random number into the page
            $tempArray[$l] = $randomNumber;
            }
            
          }
           return $tempArray;
}

function parseRoundRands($roundArray, $l, $i){
  //Starts a for loop to run through this array of exploded strings, starting with text and changing to a number every time it sees $$, then back to text again
        for($l = 0; $l < count($roundArray); $l ++){
            //Checking if l is odd, if so, it will do the random number generation
            if($l % 2 != 0){
              //Explode the string into a new array (of integers styled 'min,max,decimals')
            $roundArray2 = explode(",",$roundArray[$l]);
            //Generate the random number for this set of inputs
            $randomNumber = frand($roundArray2);
            //Pass the generated random number into the user's database
            storeRand($randomNumber, $i, (($l-1)/2));
            //Echo that random number into the page
            echo $randomNumber;
            }else{
            echo $roundArray[$l];
            }
            
          }
  
}



?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Assign 2.0</title>

    <!-- Bootstrap -->
    <link href="styles/bootstrap.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <style>
    body{
      background-image:url('resources/p5.png');
      backgrond-repeat:repeat;
    }
    .panel-body{

    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <br>
        <div class="jumbotron">
          <h2 class="pageTitle" style="text-align: center;"><?php echo "Assignment:" . $assignmentName; ?></h2>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            
            <h4 class="pageSubtitle" style="text-align:center;"><?php echo "You are logged in as: " . $userFullName . " | <span style='opacity:.75;'>" . $date ."</span>";?></h4>
            <center>
             
              <button class="btn btn-danger" onclick="logOut();">Log Out</button>
            </center>
          </div>
          <div class="panel-body">
            <div class="well well-sm" style="width:90%; margin:auto;">
              <div class="pretext" >
                <h4><?php echo $pretext; ?></h4>
              </div>
            </div>

            <br><br>
            <table class="table table-hover table-bordered" style="width:90%; margin:auto;">

              <thead>
              <tr>
                <th>
                  #
                </th>
                <th style="width:75%">
                  Question Text
                </th>
                <th style="width:10%">
                  Your Answer
                </th>
                <th style="width:8%">
                  Units
                </th>
                <th>
                  Check
                </th>
              </tr>
              </thead>
              <tbody>
                <?php getQuestions() ?>
              </tbody>


            </table>

          </div>
          <div class="panel-footer">
            <center>
            <div class="submit-frame" style="">
              <div class="btn-group" style="">
                <button type="button" class="btn btn-warning" onclick="checkAll();">
                  Check All
                </button>
                <button type="button" class="btn btn-default" onclick="resetAnswers();">
                  Reset
                </button>

                <button type="button" class="btn btn-success" onclick="submitAnswers();">
                  Submit
                </button>
              </div>
            </div>
          </center>
          </div>
        </div>

      </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
    $(function(){
      $("check-button").on("click", function(){
        checkAnswer($(this).data("questionnum"));
      });
    });
    
    function checkAnswer(questionNumber){
      $.post( "checkAnswer.php", { question:questionNumber, answer:$("#Answer-"+questionNumber).val() })
        .done(function( data ) {
          
        });
      }


    </script>
  </body>
</html>
