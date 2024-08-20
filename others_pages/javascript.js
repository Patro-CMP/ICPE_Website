var myCarousel = document.querySelector('#myCarousel')
    var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 2000,
    wrap: false
});


// -------------------SCRIPT MANAGE BLOG---------------

// document.getElementById('blogForm').addEventListener('submit', function(e) {
//     let title = document.getElementById('title').value;
//     let comment = document.getElementById('comment').value;

//     if (title.trim() === '' || comment.trim() === '') {
//         alert('Le titre et le commentaire ne peuvent pas être vides.');
//         e.preventDefault(); // Empêche l'envoi du formulaire
//     }
// });