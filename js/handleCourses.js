let isActiveCourseAdd = false;
let isActiveCourseDelete = false;
const btnCourseAdd = document.querySelector(".addCourseTrigger");
const btnCourseDel = document.querySelector(".delCourseTrigger");

// const answer = document.querySelector('#user-list');
btnCourseAdd.addEventListener('click', () => {
    getCourses('courseAdd');
    isActiveAuth = false;
    isActiveEnrol = false;
    isActiveDelete = false;
    isActiveCourseDelete = false;
    isActiveEnrolAuth = false;
    isActiveCourseAdd = !isActiveCourseAdd;
});
btnCourseDel.addEventListener('click', () => {
  getCourses('courseDelete');
  isActiveAuth = false;
  isActiveEnrol = false;
  isActiveDelete = false;
  isActiveCourseAdd = false;
  isActiveEnrolAuth = false;
  isActiveCourseDelete = !isActiveCourseDelete;
  console.log(isActiveDelete);
});


function getCourses(status) {
  let xml = new XMLHttpRequest();
  xml.onreadystatechange = function() {
    if (xml.readyState === 4 && xml.status === 200 && 
        isActiveCourseAdd && !isActiveAuth && !isActiveDelete && !isActiveCourseDelete && !isActiveEnrol &&
        !isActiveEnrolAuth || isActiveCourseDelete && !isActiveAuth && !isActiveDelete && !isActiveCourseAdd && 
        !isActiveEnrol && !isActiveEnrolAuth) {
      answer.innerHTML = xml.responseText;
    } else {
      answer.innerHTML = "Display Informations";
    }
  };
  xml.open("POST", "get_courses.php", true);
  xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xml.send(`selection=${status}`);
}

function addCourse() {
    const courseName = document.getElementById("course-name").value;

    let xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        answer.innerHTML = xml.responseText;
      } else {
        answer.innerHTML = "Display Informations";
      }
    };
    xml.open("POST", "create_course.php", true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("course-name=" + courseName);
  }

function courseDel() {
  const delCourseBtns = document.querySelectorAll('.course-del-btn');
  delCourseBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            const courseId = this.getAttribute('data-course-id');
            const xml = new XMLHttpRequest();
            xml.onreadystatechange = function() {
                if (xml.readyState === 4 && xml.status === 200) {
                    const authorizedRow = event.target.closest('tr');
                    authorizedRow.remove();
                } else {
                  answer.innerHTML = xml.responseText;
                }
            };
            xml.open('POST', 'course_del.php', true);
            xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xml.send(`courseId=${courseId}`);
        })
    });
}