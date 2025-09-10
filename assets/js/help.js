// /assets/js/help.js

document.addEventListener('DOMContentLoaded', () => {
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');

            // Toggle active class on the question for the '+' / '-' icon
            question.classList.toggle('active');
            // Toggle active class on the answer to show/hide
            answer.classList.toggle('active');
        });
    });
});