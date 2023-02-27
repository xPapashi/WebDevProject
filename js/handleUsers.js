let isActiveAuth = false;
let isActiveDelete = false;
const btnSelect = document.querySelector(".selectTrigger");
const btnDel = document.querySelector(".deleteTrigger");
const answer = document.querySelector('#user-list');
btnSelect.addEventListener('click', () => {
    getUsers('userAuth');
    isActiveDelete = false;
    isActiveCourseAdd = false;
    isActiveAuth = !isActiveAuth;
    console.log(isActiveAuth);
});
btnDel.addEventListener('click', () => {
  getUsers('userDelete');
  isActiveAuth = false;
  isActiveCourseAdd = false;
  isActiveDelete = !isActiveDelete;
  console.log(isActiveDelete);
});


function getUsers(status) {
  let xml = new XMLHttpRequest();
  xml.onreadystatechange = function() {
    if (xml.readyState === 4 && xml.status === 200 && 
        isActiveAuth && !isActiveDelete && !isActiveCourseAdd || isActiveDelete 
        && !isActiveAuth && !isActiveCourseAdd) {
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