const sidebar = document.querySelector('#mySideNav');
const sidebarIcon = document.querySelector('#sidebar-icon');
const body = document.querySelector('body');
const quiz1 =document.querySelector('#quiz1')
const quiz2 =document.querySelector('#quiz2')
const quiz3 =document.querySelector('#quiz3')
const allquiz = document.querySelector('.quiz')
var csa = document.getElementById('CS')


function openNav() {
    sidebar.style.width = '250px';
    sidebar.style.padding = '16px';
    sidebar.style.borderRight = '3px solid hsla(0, 0%, 42%, 0.4)';
    sidebarIcon.style.display = 'none';

}

function closeNav() {
    body.addEventListener('click', function (e) {
        if (!(e.target.id === "mySideNav" || 
        e.target.className === "sidebar-content" ||
        e.target.className === "sidebar-title" ||
        e.target.localName === "ul" ||
        e.target.localName === "li" ||
        e.target.localName === "a")) {
            sidebarIcon.style.display = 'block';
            sidebar.style.width = '0px';
            sidebar.style.padding = '0px';
            sidebar.style.borderRight = '0';
        };
    }, true);
}

function openquizbox(){
    body.addEventListener('click', function (e){
        if (e.target.id === 'quiz1'||
        e.target.id === 'Q1'){
            quiz1.style.height= '400px';
        };
        if (e.target.id==='quiz2' ||
        e.target.id === 'Q2' ){
            quiz2.style.height= '400px';  
        };
        if (e.target.id==='quiz3' ||
        e.target.id === 'Q3') {
            quiz3.style.height= '400px';
        };
    } ,false);
            
}

function closequizbox(){
    body.addEventListener('click', function (e){
        if (!(e.target.id === 'quiz1')){
            quiz1.style.height = '40px';
        };
        if (!(e.target.id === 'quiz2')){
            quiz2.style.height = '40px';
        };
        if (!(e.target.id === 'quiz3')){
            quiz3.style.height = '40px';
        };
    }, true)
}


document.getElementById("quizForm").addEventListener("submit", function(event) {
    event.preventDefault(); // prevent form submission
    var formData = new FormData(document.getElementById("quizForm")); // create form data object
    // make AJAX request to upload.php file
    var request = new XMLHttpRequest();
    request.open("POST", "upload.php");
    request.send(formData);
    request.onreadystatechange = function() {
      if (request.readyState === 4 && request.status === 200) {
        alert(request.responseText); // show response message
      }
    }
  });


const mysql = require('mysql');
const fs = require('fs');

// Connect to the MySQL database
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'acetraining'
});


