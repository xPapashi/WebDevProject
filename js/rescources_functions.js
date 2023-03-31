const buttonAdd = document.querySelector(".addContentButton");

buttonAdd.addEventListener("click", AddNew);
const content = document.getElementById("content");

function AddNew(){
    const newDiv = document.createElement("div");
    newDiv.classList.add("resourceContainer");
    content.appendChild(newDiv)
}

const courseDropdown = document.getElementById("course");

courseDropdown.addEventListener("change", () => {
    console.log("changed!");
  const courseId = courseDropdown.value.split(",")[0]; // get the ID from the selected option

  // send an AJAX request to fetch the weeks for the selected course
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `get_weeks.php?courseId=${courseId}`, true);
  xhr.onload = () => {
    if (xhr.status === 200) {
      const weeksDropdown = document.getElementById("week");

      // replace the options in the weeks dropdown with the fetched weeks
      weeksDropdown.innerHTML = xhr.responseText;
    }
  };
  xhr.send();
});