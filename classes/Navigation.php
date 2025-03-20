<?php
class Navigation {
    private $menuItems = array();
    private $siteNamePrimary;
    private $siteNameSecondary;

    public function __construct(
        $siteNamePrimary = "Baitul Mukarram",
        $siteNameSecondary = "Jame Mosque"
    ) {
        $this->menuItems = [
            "Home"      => "index.php",
            "About Us"  => "about.php",
            "Donation"  => "donation.php",
            "News"      => "news.php",
            "Timetables"=> "timetable.php"
        ];
        $this->siteNamePrimary = $siteNamePrimary;
        $this->siteNameSecondary = $siteNameSecondary;
    }

    public function render() {
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
        echo '<div class="container">';
        echo '<a class="navbar-brand" href="index.php">';
        echo '<div class="brand-wrapper">';
        echo '<img src="images/logo.png" alt="Mosque Logo" class="navbar-logo">';
        echo '<span class="site-name">';
        echo '<span class="site-name-primary">'.$this->siteNamePrimary.'</span>';
        echo '<span class="site-name-secondary">'.$this->siteNameSecondary.'</span>';
        echo '</span>';
        echo '</div></a>';
        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
        echo '<span class="navbar-toggler-icon"></span>';
        echo '</button>';
        echo '<div class="collapse navbar-collapse" id="navbarNav">';
        echo '<ul class="navbar-nav ms-lg-auto">';
        foreach ($this->menuItems as $name => $url) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="'.$url.'">'.$name.'</a>';
            echo '</li>';
        }
        echo '</ul></div></div></nav>';
    }
}
?>
