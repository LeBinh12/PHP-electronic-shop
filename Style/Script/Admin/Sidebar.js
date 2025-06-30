document.addEventListener('DOMContentLoaded', function () {
    const recycleLink = document.querySelector('a[href="#recycleCollapse"]');
    const collapseElement = document.querySelector('#recycleCollapse');
    const arrowIcon = recycleLink.querySelector('.arrow-icon');

    if (collapseElement && arrowIcon) {
        collapseElement.addEventListener('show.bs.collapse', function () {
            arrowIcon.classList.add('rotate');
            console.log('Collapse opened');
        });

        collapseElement.addEventListener('hide.bs.collapse', function () {
            arrowIcon.classList.remove('rotate');
            console.log('Collapse closed');
        });
    } else {
        console.error('Elements not found: collapseElement or arrowIcon');
    }
});