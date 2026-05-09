        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center" href="index.php">
                        <img src="includes/assets/images/logo.png" class="navbar-brand-image img-fluid" alt="Tiya Golf Club">
                        <span class="navbar-brand-text">
                            Tiya
                            <small>Golf Club</small>
                        </span>
                    </a>

                    <div class="d-lg-none ms-auto me-3">
                        <a class="btn custom-btn custom-border-btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Member Login</a>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_1">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_2">About</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_3">Membership</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_4">Events</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_5">Contact Us</a>
                            </li>
                            <?php
                            if (isset($_SESSION['user_login'])) {
                                ?>
                             <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="event-listing.php">Event Listing</a></li>

                                    <li><a class="dropdown-item" href="event-detail.php">Event Detail</a></li>
                                </ul>
                                </li>
                                <?php 
                            } 
                             ?>
                           
                        </ul>

                        <div class="d-none d-lg-block ms-lg-3">
                            <?php
                            if (isset($_SESSION['user_login'])) {
                                echo '<a href="logout.php" class="btn custom-btn custom-border-btn">Logout</a>';
                            } else {

                                echo '<a href="login.php" class="btn custom-btn custom-border-btn">Login</a>';

                                echo '<a href="register.php" class="btn custom-btn custom-border-btn">Register</a>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </nav>