import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])



const deleteBtns = document.querySelectorAll('.delete-btn');
const showDeleteBtn = document.getElementById('show-delete-btn');

deleteBtns.forEach((btn) => {
    showTheModal(btn);
})


if (showDeleteBtn) {
    showTheModal(showDeleteBtn);
}



function showTheModal(element) {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        let projectTitle = element.getAttribute('button-project-name');
        const modal = new bootstrap.Modal(document.getElementById('delete-modal'));
        document.getElementById('modal-title').innerText = `Sei sicuro di voler eliminare ${projectTitle}?`;
        modal.show();
        document.getElementById('delete').addEventListener('click', () => {
            element.parentElement.submit();
        })
    })
}
