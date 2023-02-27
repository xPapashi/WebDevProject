const buttonAdd = document.querySelector(".addContentButton");

buttonAdd.addEventListener("click", AddNew);
const content = document.getElementById("content");

function AddNew(){
    const newDiv = document.createElement("div");
    newDiv.classList.add("resourceContainer");
    content.appendChild(newDiv)
}