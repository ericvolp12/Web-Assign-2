<?php
session_start();
include 'sqlData.php';
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$_SESSION["user"] = "Eric Volpert";
if(isset($_SESSION["assignmentID"])){
$assignmentID = $_SESSION["assignmentID"];
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Assign 2.0</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
    <?php
  //Sets the loggedIn variable to determine if modal should be shown
  if(isset($_SESSION["fromLogin"])){
    if($_SESSION["fromLogin"] == true){
    echo '<script>var loggedIn=true;</script>';
  }
  }else{
    echo'<script>var loggedIn=false;</script>';
  }
  ?>
  <script charset="utf-8">
  function getAssignments(){
          $.get('scripts/getAssignments.php', function(response) {
              $("#assignSelect").html(response);
         });
  }
  </script>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <br>
        <div class="jumbotron">
          <h2 class="pageTitle" style="text-align: center;"></h2>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">

            <h4 class="pageSubtitle" style="text-align:center;"></h4>
            <center>

              <button class="btn btn-danger" onclick="logOut();">Log Out</button>
            </center>
          </div>
          <div class="panel-body">
            <div class="well well-sm" style="width:90%; margin:auto;">
              <div class="pretext" >
                <h4></h4>
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

              </tbody>


            </table>

          </div>
          <div class="panel-footer">
            <center>
            <div class="submit-frame" style="">
              <div class="btn-group" style="">
                <button type="button" class="btn btn-warning">
                  Check All
                </button>
                <button type="button" class="btn btn-default resetButton" >
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
    <!-- Sign-In Modal -->
 <div class="modal fade" id="signInModal" role="dialog" aria-labelledby="signInModal" aria-hidden="true">
           <div class="modal-dialog">
             <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="signinModalTitle">Sign In</h4>
                   </div>

                   <div class="modal-body">
                      <form id="loginform" class="form-horizontal" role="form">

                           <div style="margin-bottom: 25px" class="input-group">
                                       <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                       <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
                                   </div>

                           <div style="margin-bottom: 25px" class="input-group">
                                       <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                       <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                                   </div>

                           <div style="margin-bottom: 25px" class="input-group">
                                       <label for="sel1">Assignments</label>

                                       <select class="form-control" id="assignSelect">
                                         <script>getAssignments();</script>
                                       </select>
                                       <br><br>
                                       <br><br>

                                   </div>



                           <div class="input-group">
                                     <div class="checkbox">
                                       <label>
                                         <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                       </label>
                                     </div>
                                   </div>
                               <div style="margin-top:10px" class="form-group">
                                   <!-- Button -->
                                   <div class="col-sm-12">
                                     <button id="loginButton" onclick="logIn();" class="btn btn-success">Login  </button>
                                     <!--<a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a>-->
                                   </div>
                               </div>
                               <div class="form-group">
                                   <div class="col-md-12 control">
                                       <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                           Don't have an account?
                                       <a href="register.php">
                                           Sign Up Here
                                       </a>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
                   </div>
                   </div>
 <!-- /Sign-In Modal -->


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
    $(window).load(function() {
   //Checks if user is yet logged in (Set by php script at top of page)
   if(loggedIn!=true){

     //Shows modal if user hasn't logged in yet
     $('#signInModal').modal({
         backdrop: 'static',
         keyboard: true
     })
     $('#signInModal').modal('show');

     //Prevents modal from default dismissal.
     //Only way to dismiss is by logging in.
     $("#loginButton").on("click", function(e) {
         e.preventDefault();
     });
   }else{

     //If user already logged in, refresh the data for their team
     //pageRefresh();
   }

 });

 //Function called by login Modal to verify user credientials
 function logIn() {
     'use strict';

     //Checks to see if user filled the fields
     if ($("#login-username").val() != "" && $("#login-password").val() !=
         "") {
         //Post request to the login script to check if credentials match up
         $.post("scripts/login.php", {
             id: $("#login-username").val(),
             password: $("#login-password").val(),
             assignment: $("#assignSelect").children(":selected").attr("id")
         }, function(response) {

             //Successful Login
             if (response == "confirmed") {
                 //Refresh goals for their team
                 loadAssignment();
                 //Hide the signin modal
                 $("#signInModal").modal("hide");
             }
         });

     } else {

         //User did not enter username or password
         alert("Error: Please enter a username and password.");
     }
 }

    $(function(){

      $(".check-button").on("click", function(){
        checkAnswer($(this).data("questionnum"));
      });

      $(".resetButton").on("click", function(){
        $.get( "reset.php", function( data ) {
          location.reload();
        });
      });
    });

    function checkAnswer(questionNumber){
      $.post( "checkAnswer.php", { question:questionNumber, answer:$("#Answer-"+questionNumber).val() })
        .done(function( data ) {

        });
      }
      //Function to log a user out and destroy the php session
      function logOut(){
        window.location.replace("scripts/logout.php");
      }
      function loadAssignment(){


      }

    </script>
  </body>
</html>
