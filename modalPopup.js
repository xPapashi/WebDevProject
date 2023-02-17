const modal = document.querySelector('.modal');
const trigger = document.querySelector('.trigger');
const closeBtn = document.querySelector('.close-button');

function toggleModal() {
    modal.classList.toggle("show-modal");
}

function detectClick(event) {
    if (event.target === modal) {
        toggleModal();
    }
}

trigger.addEventListener('click', toggleModal);
closeBtn.addEventListener('click', toggleModal);
window.addEventListener('click', detectClick);