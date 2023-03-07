const bod = document.querySelector("body");
const modal = document.createElement("div");
modal.classList.add("modal");
const email = document.querySelector(".emailTrigger");
const password = document.querySelector(".passwordTrigger");
const closeBtn = document.createElement("span");
closeBtn.classList.add("close-button");
// const closeBtn = document.querySelector(".close-button");

//New Element
const modalContainer = document.createElement("div");
const modalHeading = document.createElement("div");
const modalContent = document.createElement("div");

//Modal Heading
const h1 = document.createElement("h1");

//Form
const form = document.createElement("form");

//Form Inputs
const label = document.createElement("label");
const input = document.createElement("input");
const submit = document.createElement("input");

//Setup form
form.method = "POST";
submit.type = "submit";

function toggleModal() {
  modal.classList.toggle("show-modal");
}

function detectClick(event) {
  if (event.target === modal) {
    toggleModal();
  }
}

function createModal(type) {
  //Add classes
  modalContainer.classList.add("modal-container");
  modalHeading.classList.add("modal-heading");
  modalContent.classList.add("modal-content");
  closeBtn.innerHTML = "&times";

  //Connect to parent
  body.appendChild(modal);
  modal.appendChild(modalContainer);
  modalContainer.appendChild(modalHeading);
  modalContainer.appendChild(modalContent);

  switch (type) {
    case "email":
      h1.innerText = "Change user email";
      modalHeading.appendChild(h1);
      modalHeading.appendChild(closeBtn);

      input.name = "email";
      input.value = "";
      input.type = "email";
      input.placeholder = "jSmith1@system.edu";
      input.required = true;

      label.innerHTML = "E-mail:";
      modalContent.appendChild(form);
      form.appendChild(label);
      form.appendChild(input);
      form.appendChild(submit);
      break;
    case "password":
      h1.innerText = "Change user password";
      modalHeading.appendChild(h1);
      modalHeading.appendChild(closeBtn);

      input.name = "password";
      input.value = "";
      input.type = "password";
      input.placeholder = "StrongPass123!";
      
      label.innerHTML = "Password:";
      modalContent.appendChild(form);
      form.appendChild(label);
      form.appendChild(input);
      form.appendChild(submit);
      break;
  }
}

function chooseModalPopup(type) {
  switch (type) {
    case "email":
      modal.remove();
      createModal(type);
      toggleModal();
      break;
    case "password":
      modal.remove();
      createModal(type);
      toggleModal();
      break;
  }
}

// email.addEventListener('click', toggleModal);
if (email) {
  email.addEventListener("click", () => {
    chooseModalPopup("email");
  });
}
if (password) {
  password.addEventListener("click", () => {
    chooseModalPopup("password");
  }); 
}
closeBtn.addEventListener("click", toggleModal);
window.addEventListener("click", detectClick);