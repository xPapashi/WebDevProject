<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz Page</title>
    <link rel="stylesheet" href="./style/quiz_style.css" />
    <script src="./quizapp.js" defer></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.3.js"
			  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
			  crossorigin="anonymous"></script>
    
    <script type = "text/javascript">
         $(document).ready(function() {
			 $("#CS").click(function(){
				document.getElementById("main_heading").innerHTML='Computer Science';
			});
			 $("#Net").click(function(){
				document.getElementById("main_heading").innerHTML='Networks';
			});
			 $("#Rob").click(function(){
				document.getElementById("main_heading").innerHTML='Robotics';
			});
       $("#SE").click(function(){
				document.getElementById("main_heading").innerHTML='Software Engineering';
			});
         });		 
      </script>

  </head>
  <body onclick="closeNav(); closequizbox();">  
          <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
      <div id="sidebar-icon" onclick="openNav()">&#9776</div>
      <div class="sidebar" id="mySideNav">
        <div class="sidebar-content">
          <div class="sidebar-title">Courses</div>
          <ul>
            <li class="dropdown"><a href="#CS" id="CS" aria-haspopup="true" >Computer Science</a>
              <ul class="dropdown-content" aria-label="submenu">
                <li><a id="csq1">QUIZ 1</a></li>
                <li><a id="csq2">QUIZ 2</a></li>
                <li><a id="csq3">QUIZ 3</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#Net" id="Net" aria-haspopup="true" > Networking</a>
              <ul class="dropdown-content" aria-label="submenu">
                <li><a href="#">QUIZ 1</a></li>
                <li><a href="#">QUIZ 2</a></li>
                <li><a href="#">QUIZ 3</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#Rob" id="Rob" aria-haspopup="true" >Robotics</a>
              <ul class="dropdown-content" aria-label="submenu">
                <li><a href="#">QUIZ 1</a></li>
                <li><a href="#">QUIZ 2</a></li>
                <li><a href="#">QUIZ 3</a></li>
              </ul>
            </li>
            <li class="dropdown"><a href="#SE" id="SE" aria-haspopup="true" >Engineering</a>
              <ul class="dropdown-content" aria-label="submenu">
                <li><a href="#">QUIZ 1</a></li>
                <li><a href="#">QUIZ 2</a></li>
                <li><a href="#">QUIZ 3</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="container">
      <div class="container">
    <div class="content">
              <div class="heading"><span id='main_heading'>Computer Science</span></div>
              <div class="content-grid">
                  <div id="quiz1" class="quiz" onclick="openquizbox()" >
                      <h1 class="quiz-header" id="Q1">Quiz 1</h1>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </div>
                      <bk></bk>
                      <div class="progress-container">
                      <div class="bar" > 01%</div>
                      </div>
                      <div class="button" ><a href="#quiz1">Start</div></a>
                  </div>
                  <div id="quiz2" class="quiz" onclick="openquizbox()" >
                      <h1 class="quiz-header" id="Q2">Quiz 2</h1>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </div>
                      <bk></bk>
                      <div class="progress-container">
                      <div class="bar" >01%</div>
                      </div>
                      <div class="button"><a href="#quiz2">Start</div></a>
                  </div>
                  <div id="quiz3" class="quiz" >
                      <h1 class="quiz-header" id="Q3">Quiz 3</h1>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </div>
                      <bk></bk>
                      <div class="progress-container">
                      <div class="bar" >01%</div>
                      </div>
                      <div class="button"><a href="#quiz3">Start</div></a>
                  </div>
                  </div>
              </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
