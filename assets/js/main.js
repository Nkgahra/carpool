// Sidebar Elements
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");
const closeSidebar = document.getElementById("closeSidebar");

// Open Sidebar
if (menuToggle && sidebar && overlay) {

    menuToggle.addEventListener("click", () => {

        sidebar.classList.add("active");
        overlay.classList.add("active");

    });

}

// Close Button
if (closeSidebar && sidebar && overlay) {

    closeSidebar.addEventListener("click", () => {

        sidebar.classList.remove("active");
        overlay.classList.remove("active");

    });

}

// Click Overlay
if (overlay && sidebar) {

    overlay.addEventListener("click", () => {

        sidebar.classList.remove("active");
        overlay.classList.remove("active");

    });

}

// ESC Key
document.addEventListener("keydown", (e) => {

    if (e.key === "Escape") {

        sidebar?.classList.remove("active");
        overlay?.classList.remove("active");

    }

});

// Fullscreen
const fullscreenBtn = document.getElementById("fullscreenBtn");

if (fullscreenBtn) {

    fullscreenBtn.addEventListener("click", () => {

        if (!document.fullscreenElement) {

            document.documentElement.requestFullscreen();

        } else {

            document.exitFullscreen();

        }

    });

}