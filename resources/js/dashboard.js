
window.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.user-menu').addEventListener('click', function (e) {
        this.classList.toggle('active');
        e.stopPropagation();
    });
    window.onclick = function () {
        document.querySelector('.user-menu').classList.remove('active');
    }

    window.openModal = function (id) {
        const modal = document.getElementById(id);
        modal.classList.remove('closing');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        modal.classList.add('closing');
        setTimeout(() => {
            modal.classList.remove('active');
            modal.classList.remove('closing');
            document.body.style.overflow = 'auto';
        }, 200);
    }
})
