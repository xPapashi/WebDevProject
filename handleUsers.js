let isActive = false;
const btn = document.querySelector(".selectTrigger");
const answer = document.querySelector('#user-list');
btn.addEventListener('click', () => {
    getUsers()
    isActive = !isActive;
    console.log(isActive);
});


function getUsers() {
    let xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
      if (xml.readyState === 4 && xml.status === 200 && isActive) {
        answer.innerHTML = xml.responseText;
      } else {
        answer.innerHTML = "Display Informations";
      }
    };
    xml.open("GET", "get_users.php", true);
    xml.send();
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