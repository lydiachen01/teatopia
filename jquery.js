document.addEventListener('DOMContentLoaded', function () {
    console.log("menu clicked check");
    
    // Mobile menu toggle
    var mobileButton = document.querySelector('[aria-controls="mobile-menu"]');
    var mobileMenu = document.getElementById('mobile-menu');
    mobileButton.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Profile dropdown toggle
    var profileButton = document.getElementById('user-menu-button');
    var profileMenu = document.getElementById('profile-menu');
    profileButton.addEventListener('click', function () {
        profileMenu.classList.toggle('hidden');
    });
});
