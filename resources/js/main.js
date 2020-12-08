function getAll(selector) {
    return document.querySelectorAll(selector)
}

let dropDownsWithListeners = [];
const onDropDownClick = $el => event => {
    $el.classList.toggle('is-active');
};
window.initDropdowns = function () {

    // Remove previously initiated dropdowns event listeners
    dropDownsWithListeners.forEach(function ({$el, listener}) {
        $el.removeEventListener('click', listener);
    });
    dropDownsWithListeners = [];

    const $dropDowns = getAll('.dropdown:not(.is-hoverable)');

    if ($dropDowns.length > 0) {
        $dropDowns.forEach(function ($el) {
            const onClick = onDropDownClick($el);
            $el.addEventListener('click', onClick);
            dropDownsWithListeners.push({
                $el: $el,
                listener : onClick
            });
        });

        document.addEventListener('click', function (event) {
            if (event.target.closest('.dropdown')) {
                return
            }
            $dropDowns.forEach(function ($el) {
                $el.classList.remove('is-active');
            });
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(el => {
            el.addEventListener('click', () => {

                // Get the target from the "data-target" attribute
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

            });
        });
    }

    // Dropdowns
    initDropdowns();
    Waves.attach('.secondary .menu__link', ['waves-button', 'waves-float']);
    Waves.attach('.button:not(.round):not(.button-dropdown):not(.ad-action-button):not(.is-normal), input.is-link', ['waves-button', 'waves-float', 'waves-light']);
    Waves.attach('.button__icon', ['waves-circle', 'waves-light']);
    Waves.init();
});



