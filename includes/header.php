<?php
// includes/header.php
require_once __DIR__ . '/../classes/Navigation.php';

// Create navigation instance
$nav = new Navigation();

// Detect current page for SEO optimization
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$isHomepage = ($currentPage === 'index.php');

// Set page title based on current page
$pageTitles = [
    'index.php' => 'Home',
    'about.php' => 'About Us',
    'donation.php' => 'Donation',
    'news.php' => 'News',
    'timetable.php' => 'Timetables'
];

if (isset($pageTitles[$currentPage])) {
    $nav->setPageTitle($pageTitles[$currentPage]);
}

// Get the final page title
$pageTitle = $nav->getPageTitle();
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/PlaceOfWorship">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $pageTitle; ?></title>
  
  <!-- SEO Meta Tags -->
  <meta name="description" content="Baitul Mukarram Mosque in Dundee, Scotland. Serving the Muslim community with daily prayers, Islamic education, and community events.">
  <meta name="keywords" content="dundee mosque, islamic center, muslim community, prayer times, islam in scotland">
  <meta name="author" content="Dundee Muslim Community Trust">
  <meta itemprop="name" content="Baitul Mukarram Mosque">
  <meta itemprop="description" content="Mosque and Islamic community center in Dundee, Scotland">
  <meta itemprop="image" content="https://dmjmdundee.com/images/mosque-exterior.jpg">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://dmjmdundee.com/">
  <meta property="og:title" content="<?php echo $pageTitle; ?>">
  <meta property="og:description" content="Community mosque serving Muslims in Dundee, Scotland">
  <meta property="og:image" content="https://dmjmdundee.com/images/mosque-social.jpg">
  
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://dmjmdundee.com/">
  <meta property="twitter:title" content="<?php echo $pageTitle; ?>">
  <meta property="twitter:description" content="Community mosque serving Muslims in Dundee, Scotland">
  <meta property="twitter:image" content="https://dmjmdundee.com/images/mosque-social.jpg">
  
  <!-- Canonical URL -->
  <link rel="canonical" href="https://dmjmdundee.com/<?php echo $currentPage; ?>">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
  
  <!-- Google Site Verification -->
  <meta name="google-site-verification" content="your_verification_code">
</head>
<body>
  <?php echo $nav->render(); ?>
  
  <main id="main-content">