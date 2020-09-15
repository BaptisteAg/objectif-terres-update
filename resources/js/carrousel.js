document.addEventListener('DOMContentLoaded', () => {
        let imageExtendedContainer = document.getElementById('image-extended-container');
        let imageExtended = document.getElementById('image-extended');
        let carrouselImages = document.querySelectorAll('img[data-source]');
        carrouselImages.forEach(function (image) {
            image.addEventListener('click', function (e) {
                imageExtended.src = image.src;
                if (imageExtendedContainer.className === 'overlay active') {
                    imageExtendedContainer.classList.remove(' active')
                }
                imageExtendedContainer.className = 'overlay active';
                imageExtendedContainer.addEventListener('click', function (e) {
                    imageExtendedContainer.classList.remove('active')
                });
            })
        })
    }
);