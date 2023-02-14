const sidebar = document.querySelector('#mySideNav');
const sidebarIcon = document.querySelector('#sidebar-icon');
const body = document.querySelector('body');

function openNav() {
    sidebar.style.width = '250px';
    sidebar.style.padding = '16px';
    sidebar.style.borderRight = '3px solid hsla(0, 0%, 42%, 0.4)';
}

function closeNav() {
    body.addEventListener('click', function (e) {
        if (!(e.target.id === "mySideNav" || 
        e.target.className === "sidebar-content" ||
        e.target.className === "sidebar-title" ||
        e.target.localName === "ul" ||
        e.target.localName === "li" ||
        e.target.localName === "a")) {
            sidebarIcon.style.display = 'block';
            sidebar.style.width = '0px';
            sidebar.style.padding = '0px';
            sidebar.style.borderRight = '0';
        };
    }, true);
}