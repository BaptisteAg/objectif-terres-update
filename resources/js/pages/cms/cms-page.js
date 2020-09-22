document.addEventListener('DOMContentLoaded', () => {

    let cmsParagraph = document.querySelector('.cms-page');

    if (cmsParagraph) {
        let cmsParagraphContent = cmsParagraph.querySelectorAll('p');
        for (let item of cmsParagraphContent) {
            if (item.firstChild.nodeValue.startsWith('<iframe')) {
                let figure = document.createElement('figure');
                figure.className = 'image is-16by9'
                figure.innerHTML = item.firstChild.nodeValue
                figure.firstElementChild.className = "has-ratio"
                item.parentNode.insertBefore(figure, item);
                item.remove();
            }
        }
    }


});