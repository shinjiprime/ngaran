const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    const sidebar = document.querySelector("#sidebar");
    sidebar.classList.toggle("expand");

    // Ensure correct logo visibility
    const expandedLogo = document.querySelector('.sidebar-logo-expanded');
    const collapsedLogo = document.querySelector('.sidebar-logo-collapsed');
    if (sidebar.classList.contains('expand')) {
        expandedLogo.style.display = 'block';
        collapsedLogo.style.display = 'none';
    } else {
        expandedLogo.style.display = 'none';
        collapsedLogo.style.display = 'block';
    }
});

// Active state for sidebar
document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function () {
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
    });
});

// Preloader removal
window.addEventListener('load', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.display = 'none';
    }
});
