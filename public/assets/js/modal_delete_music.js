const openModal = document.querySelectorAll('.btn-modal-music');

const closeModal = document.querySelectorAll('.btn-back');

Array.from(openModal).forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        let modal = btn.getAttribute('data-modal');

        document.getElementById(modal).style.display = "block";
    });
});

Array.from(closeModal).forEach(btnclose => {

    btnclose.addEventListener('click', function() {

        this.closest('.modal').style.display = "none";
    });
});
