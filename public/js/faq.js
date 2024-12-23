const faqs = document.querySelectorAll('.faq');

faqs.forEach(faq => {
    faq.addEventListener('click', () => {
        faq.classList.toggle('open');

        const answer = faq.nextElementSibling; // Select the FAQ answer
        const icon = faq.querySelector('i'); // Select the icon inside the FAQ

        if (faq.classList.contains('open')) {
            answer.style.display = 'block'; // Show the answer
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-times');
        } else {
            answer.style.display = 'none'; // Hide the answer
            icon.classList.remove('fa-times');
            icon.classList.add('fa-plus');
        }
    });
});
