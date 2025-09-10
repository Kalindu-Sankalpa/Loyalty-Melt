let navToggle = document.querySelector('.nav-toggle');
let navLinks = document.querySelector('.nav-links');
let navItems = document.querySelectorAll('.nav-item');

navToggle.addEventListener('click', () => {
    navToggle.classList.toggle('active');
    navLinks.classList.toggle('show');
});

navItems.forEach(item => {
    item.addEventListener('click', () => {
        setTimeout(() => {
            navToggle.classList.remove('active');
            navLinks.classList.remove('show');
        }, 500);
    });
});

let sections = document.querySelectorAll('section');

sections.forEach(section => {
    section.addEventListener('click', () => {
        navToggle.classList.remove('active');
        navLinks.classList.remove('show');
    });
});
