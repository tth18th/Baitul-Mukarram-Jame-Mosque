<?php
class Navigation {
    private $menuItems = array();
    private $siteNamePrimary;
    private $siteNameSecondary;
    private $structuredData;
    private $currentPageTitle;

    public function __construct(
        $siteNamePrimary = "Baitul Mukarram",
        $siteNameSecondary = "Jame Mosque"
    ) {
        $this->menuItems = [
            "Home"      => [
                "url" => "index.php", 
                "title" => "Home - Dundee Mosque",
                "page_title" => "Home | Baitul Mukarram Mosque"
            ],
            "About Us"  => [
                "url" => "about.php", 
                "title" => "About Our Mosque",
                "page_title" => "About Us | History & Mission"
            ],
            "Donation"  => [
                "url" => "donation.php", 
                "title" => "Support Our Mosque",
                "page_title" => "Donations | Support Our Community"
            ],
            "News"      => [
                "url" => "news.php", 
                "title" => "Mosque News & Events",
                "page_title" => "News & Events | Community Updates"
            ],
            "Timetables"=> [
                "url" => "timetable.php", 
                "title" => "Prayer Timetable",
                "page_title" => "Prayer Timetable | Daily Salah Times"
            ]
        ];
        
        $this->siteNamePrimary = $siteNamePrimary;
        $this->siteNameSecondary = $siteNameSecondary;
        
        // Set default page title
        $this->currentPageTitle = $siteNamePrimary . " " . $siteNameSecondary;
        
        // Generate structured data for SEO
        $this->generateStructuredData();
    }

    private function generateStructuredData() {
        $this->structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => $this->siteNamePrimary . " " . $this->siteNameSecondary,
            "url" => "https://dmjmdundee.com/",
            "logo" => "https://dmjmdundee.com/images/logo.png",
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+44-1382-123456",
                "contactType" => "Customer service"
            ],
            "sameAs" => [
                "https://www.facebook.com/dmjmdundee",
                "https://www.instagram.com/bmjmdundee/",
                "https://www.threads.net/@bmjmdundee"
            ]
        ];
    }

    // Set current page title based on page name
    public function setPageTitle($pageName) {
        if (isset($this->menuItems[$pageName])) {
            $this->currentPageTitle = $this->menuItems[$pageName]['page_title'];
        }
        return $this;
    }

    // Get the current page title
    public function getPageTitle() {
        return $this->currentPageTitle;
    }

    public function render() {
        $html = '<nav class="navbar navbar-expand-lg navbar-light bg-light" itemscope itemtype="https://schema.org/SiteNavigationElement">';
        $html .= '<div class="container">';
        $html .= '<a class="navbar-brand d-flex align-items-center" href="index.php" itemprop="url">';
        $html .= '<img src="images/logo.png" alt="Baitul Mukarram Mosque Logo" class="navbar-logo me-2" itemprop="logo" width="50" height="50">';
        $html .= '<div class="site-name-wrapper">';
        $html .= '<span class="site-name-primary d-block" itemprop="name">'.$this->siteNamePrimary.'</span>';
        $html .= '<span class="site-name-secondary d-block" itemprop="name">'.$this->siteNameSecondary.'</span>';
        $html .= '</div>';
        $html .= '</a>';
        
        $html .= '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>';
        
        $html .= '<div class="collapse navbar-collapse" id="navbarNav">';
        $html .= '<ul class="navbar-nav ms-lg-auto">';
        
        foreach ($this->menuItems as $name => $data) {
            $html .= '<li class="nav-item" itemprop="name">';
            $html .= '<a class="nav-link" href="'.$data['url'].'" itemprop="url" title="'.$data['title'].'">'.$name.'</a>';
            $html .= '</li>';
        }
        
        $html .= '</ul></div></div></nav>';
        
        // Add structured data JSON-LD
        $html .= '<script type="application/ld+json">'.json_encode($this->structuredData).'</script>';
        
        return $html;
    }
}
?>