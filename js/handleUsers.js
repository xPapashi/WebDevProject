let isActiveAuth = false;
let isActiveEnrol = false;
let isActiveDelete = false;
const btnAuth = document.querySelector(".authTrigger");
const btnEnrol = document.querySelector(".enrolTrigger");
const btnDel = document.querySelector(".deleteTrigger");
const answer = document.querySelector('#user-list');
let userEmail = "";

btnAuth.addEventListener('click', () => {
    getUsers('userAuth');
    isActiveDelete = false;
    isActiveCourseAdd = false;
    isActiveCourseDelete = false;
    isActiveEnrol = false;
    isActiveAuth = !isActiveAuth;
});
btnEnrol.addEventListener('click', () => {
  getUsers('userEnrol');
  isActiveAuth = false;
  isActiveCourseAdd = false;
  isActiveCourseDelete = false;
  isActiveDelete = false;
  isActiveEnrol = !isActiveEnrol;
  console.log(isActiveEnrol);
});
btnDel.addEventListener('click', () => {
  getUsers('userDelete');
  isActiveAuth = false;
  isActiveCourseAdd = false;
  isActiveCourseDelete = false;
  isActiveEnrol = false;
  isActiveDelete = !isActiveDelete;
});


function getUsers(status) {
  let xml = new XMLHttpRequest();
  xml.onreadystatechange = function() {
    if (xml.readyState === 4 && xml.status === 200 && 
        isActiveAuth && !isActiveDelete && !isActiveCourseAdd && !isActiveCourseDelete && !isActiveEnrol || 
        isActiveDelete && !isActiveAuth && !isActiveCourseAdd && !isActiveCourseDelete &&  !isActiveEnrol ||
        isActiveEnrol && !isActiveAuth && !isActiveDelete && !isActiveCourseAdd && !isActiveCourseDelete) {
      answer.innerHTML = xml.responseText;
    } else {
      answer.innerHTML = "Display Informations";
    }
  };
  xml.open("POST", "get_users.php", true);
  xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xml.send(`selection=${status}`);
}

function userDel() {
  const delBtns = document.querySelectorAll('.del-btn');
    delBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            const userId = this.getAttribute('data-user-id');
            const xml = new XMLHttpRequest();
            xml.onreadystatechange = function() {
                if (xml.readyState === 4 && xml.status === 200) {
                    const authorizedRow = event.target.closest('tr');
                    authorizedRow.remove();
                }
            };
            xml.open('POST', 'userDel.php', true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.send(`userId=${userId}`);
        })
    });
}

function userAuth() {
    const authBtns = document.querySelectorAll('.auth-btn');
    authBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            const userId = this.getAttribute('data-user-id');
            const xml = new XMLHttpRequest();

            xml.onreadystatechange = function() {
                if (xml.readyState === 4 && xml.status === 200) {
                    const authorizedRow = event.target.closest('tr');
                    authorizedRow.remove();
                }
            };
            xml.open('POST', 'userAuth.php', true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.send(`userId=${userId}`);
        })
    });
}

function showCourses() {
  const selBtn = document.querySelectorAll('.select-btn');
  const coursesList = document.querySelector('#courses-list');
  selBtn.forEach(btn => {
    btn.addEventListener('click', function() {
      userEmail = this.getAttribute('data-user-email');
      coursesList.style.display = 'block';
    });
  });
}



function userEnrol() {
  const enrolBtns = document.querySelectorAll('.enrol-btn');
  console.log(userEmail);
  enrolBtns.forEach(btn => {
      btn.addEventListener('click', function(event) {
          const courseId = this.getAttribute('data-course-id');
          const xml = new XMLHttpRequest();

          xml.onreadystatechange = function() {
              if (xml.readyState === 4 && xml.status === 200) {
                answer.innerHTML = xml.responseText;
              } else {
                answer.innerHTML = "Error when enrolling user!";
              }
          };
          xml.open('POST', 'userEnrol.php', true);
          xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xml.send('userEmail='+encodeURIComponent(userEmail)+
                '&courseID=' + encodeURIComponent(courseId));
      })
  });
}
