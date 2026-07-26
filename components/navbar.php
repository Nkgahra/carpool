<nav class="navbar-custom">

    <!-- Left Section -->
    <div class="navbar-left">

        <button
            id="menuToggle"
            class="icon-btn"
            type="button">

            <i class="bi bi-list"></i>

        </button>

        <div class="page-info">

            <h4>Dashboard</h4>

            <span>CarPool Admin Panel</span>

        </div>

    </div>

    <!-- Right Section -->

    <div class="navbar-right">

        <!-- Search -->

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                placeholder="Search..." />

        </div>

        <!-- Theme -->

        <div class="dropdown">

            <button
                class="icon-btn"
                data-bs-toggle="dropdown"
                type="button">

                <i class="bi bi-palette"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li><a class="dropdown-item theme-option" data-theme="purple" href="#">🟣 Purple</a></li>

                <li><a class="dropdown-item theme-option" data-theme="blue" href="#">🔵 Blue</a></li>

                <li><a class="dropdown-item theme-option" data-theme="green" href="#">🟢 Green</a></li>

                <li><a class="dropdown-item theme-option" data-theme="dark" href="#">⚫ Dark</a></li>

                <li><a class="dropdown-item theme-option" data-theme="light" href="#">⚪ Light</a></li>

            </ul>

        </div>

        <!-- Fullscreen -->

        <button
            class="icon-btn"
            id="fullscreenBtn"
            type="button">

            <i class="bi bi-arrows-fullscreen"></i>

        </button>

        <!-- Notifications -->

        <button
            class="icon-btn"
            type="button">

            <i class="bi bi-bell"></i>

        </button>

        <!-- Profile -->

        <div class="dropdown">

            <button
                class="profile-btn"
                data-bs-toggle="dropdown"
                type="button">

                <img
                    src="https://ui-avatars.com/api/?background=7C3AED&color=fff&name=A"
                    alt="Admin">

                <div>

                    <strong>Admin</strong>

                    <small>Administrator</small>

                </div>

                <i class="bi bi-chevron-down"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-person"></i>
                        My Profile
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-gear"></i>
                        Settings
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <a class="dropdown-item text-danger" href="#">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>