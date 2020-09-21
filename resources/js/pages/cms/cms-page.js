document.addEventListener('DOMContentLoaded', () => {
    let cmsParagraphContent = document.querySelector('.cms-page').querySelectorAll('p');
    for (var item of cmsParagraphContent) {
        if (item.firstChild.nodeValue.startsWith('<iframe')) {
            var figure = document.createElement('figure');
            figure.className = 'image is-16by9'
            figure.innerHTML = item.firstChild.nodeValue
            figure.firstElementChild.className = "has-ratio"
            item.parentNode.insertBefore(figure, item);
            item.remove();
        }
    }
});