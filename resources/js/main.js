function getAll(selector) {
    return document.querySelectorAll(selector)
}

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
});

// Dropdowns
var $dropdowns = getAll('.dropdown:not(.is-hoverable)');

if ($dropdowns.length > 0) {

    $dropdowns.forEach(function ($el) {
        $el.addEventListener('click', function (event) {
            console.log(event)
            $el.classList.toggle('is-active');
        });
    });

    document.addEventListener('click', function (event) {
        if (event.target.closest('.dropdown')) {
            return
        }
        $dropdowns.forEach(function ($el) {
            $el.classList.remove('is-active');
        });
    });
}


window.initDropdowns = function () {
// Dropdowns
    var $dropdowns = getAll('.dropdown:not(.is-hoverable)');

    if ($dropdowns.length > 0) {
        $dropdowns.forEach(function ($el) {
            $el.addEventListener('click', function (event) {
                $el.classList.toggle('is-active');
            });
        });

        document.addEventListener('click', function (event) {
            if (event.target.closest('.dropdown')) {
                return
            }
            $dropdowns.forEach(function ($el) {
                $el.classList.remove('is-active');
            });
        });
    }
}
