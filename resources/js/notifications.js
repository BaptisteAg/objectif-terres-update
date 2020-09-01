document.addEventListener('DOMContentLoaded', () => {
    let deleteButton = document.querySelector('.close-notification');
    if (deleteButton !== null) {
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';
        })
    }
});

