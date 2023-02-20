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