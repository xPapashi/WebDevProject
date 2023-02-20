function getUsers() {
    const answer = document.querySelector('.user-list');
    let xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
      if (xml.readyState === 4 && xml.status === 200) {
        document.getElementById('user-list').innerHTML = xml.responseText;
      }
    };
    xml.open("GET", "get_users.php", true);
    xml.send();
  }