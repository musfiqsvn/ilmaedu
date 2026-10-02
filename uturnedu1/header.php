<?php
/**
 * UTurnEdu1 Header Template - Exact 1:1 Match with Original Design
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings     = get_option('uturnedu_settings', []);
$settings     = is_array($settings) ? $settings : [];
$phone1       = $settings['phone_primary'] ?? '01329272046';
$phone2       = $settings['phone_secondary'] ?? '01823345573';
$email        = $settings['email_primary'] ?? 'info@ilmaedubd.com';
$address      = !empty($settings['address']) ? $settings['address'] : 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';
$logo_rgb     = !empty($settings['site_logo_primary']) ? $settings['site_logo_primary'] : get_template_directory_uri() . '/assets/images/ILMA-Education-logo-rgb.png';
$favicon      = !empty($settings['site_favicon']) ? $settings['site_favicon'] : get_template_directory_uri() . '/assets/images/canada.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?php echo esc_url($favicon); ?>">
  <?php
  $meta_description = 'ILMA Education Consultancy helps students compare study destinations, understand eligibility and prepare for university applications abroad.';
  if (is_singular('destination')) {
      $meta_description = 'Study in ' . get_the_title() . ' with ILMA Education Consultancy. Explore universities, entry considerations and your next application step.';
  } elseif (is_page('contact')) {
      $meta_description = 'Contact us for practical guidance on study destinations, university applications and eligibility.';
  } elseif (is_page('apply-now')) {
      $meta_description = 'Start your study abroad application with ILMA Education Consultancy. Share your profile for practical destination and application guidance.';
  }
  ?>
  <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
  <?php wp_head(); ?>
  <!-- Schema.org JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "ILMA Education Consultancy",
    "url": "<?php echo esc_url(home_url('/')); ?>",
    "logo": "<?php echo esc_url($logo_rgb); ?>",
    "description": "International education guidance focused on clear study options, applications and next steps.",
    "telephone": "<?php echo esc_js($settings['phone_primary'] ?? '+8801848638406'); ?>",
    "email": "info@ilmaedubd.com",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "CL Tower, 772/1A, Bosila Road",
      "addressLocality": "Mohammadpur",
      "addressRegion": "Dhaka",
      "postalCode": "1207",
      "addressCountry": "BD"
    }
  }
  </script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-boxed-container">

  <!-- Sticky Header -->
  <header class="header-wrapper">
    <div class="container">
      <div class="header-inner">

        <!-- Brand Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo" title="ILMA Education Consultancy">
          <img src="<?php echo esc_url($logo_rgb); ?>" alt="ILMA Education Consultancy Logo" width="55" height="50">
          <div class="brand-text-wrap">
            <span class="brand-title">ILMA Education Consultancy</span>
            <span class="brand-sub">Study Abroad Guidance</span>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav aria-label="Primary navigation">
          <ul class="nav-menu">
            <li class="nav-item">
              <a href="<?php echo esc_url(home_url('/destinations/')); ?>" class="nav-link nav-link-destinations <?php echo (is_post_type_archive('destination') || is_singular('destination')) ? 'active' : ''; ?>">
                Study Destinations
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
              </a>
              <ul class="dropdown-menu">
                <?php foreach (uturnedu_destination_catalog() as $destination):
                    $destination_post = uturnedu_get_destination_post($destination['slug']);
                    if (!$destination_post) { continue; }
                ?>
                  <li>
                    <a href="<?php echo esc_url(get_permalink($destination_post->ID)); ?>" class="dropdown-link">
                      <img src="<?php echo esc_url(uturnedu_get_destination_flag($destination['code'])); ?>" alt="" width="20" height="14" aria-hidden="true">
                      <span>Study in <?php echo esc_html($destination['title']); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
                <li class="dropdown-more-link">
                  <a href="<?php echo esc_url(home_url('/destinations/')); ?>" class="dropdown-link">View all destinations <span aria-hidden="true">→</span></a>
                </li>
              </ul>
            </li>

            <li class="nav-item"><a href="<?php echo esc_url(home_url('/#why-ilma')); ?>" class="nav-link">Why select us</a></li>
            <li class="nav-item"><a href="<?php echo esc_url(home_url('/about/')); ?>" class="nav-link <?php echo is_page('about') ? 'active' : ''; ?>">About</a></li>

            <li class="nav-item">
              <a href="<?php echo esc_url(home_url('/services/')); ?>" class="nav-link <?php echo (is_post_type_archive('service') || is_singular('service')) ? 'active' : ''; ?>">
                Services
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
              </a>
              <ul class="dropdown-menu">
                <?php
                $serv_nav = get_posts(['post_type' => 'service', 'posts_per_page' => 6, 'post_status' => 'publish', 'orderby' => 'menu_order ID', 'order' => 'ASC']);
                foreach ($serv_nav as $service_post):
                ?>
                  <li><a href="<?php echo esc_url(get_permalink($service_post->ID)); ?>" class="dropdown-link"><?php echo esc_html($service_post->post_title); ?></a></li>
                <?php endforeach; ?>
                <li class="dropdown-more-link"><a href="<?php echo esc_url(home_url('/services/')); ?>" class="dropdown-link">All services and process <span aria-hidden="true">→</span></a></li>
              </ul>
            </li>

            <li class="nav-item"><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-link <?php echo is_page('contact') ? 'active' : ''; ?>">Contact Us</a></li>
          </ul>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">
          <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-outline btn-sm" style="font-weight: 700;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            Reserve Slot
          </a>

          <button type="button" class="btn btn-accent btn-sm open-consultancy-modal" style="font-weight: 700;">
            <span>Free Consultancy</span>
          </button>

          <!-- Mobile Toggle Button -->
          <button type="button" class="mobile-menu-toggle" aria-label="Open Mobile Menu" aria-controls="mobile-navigation" aria-expanded="false">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- Mobile Drawer Menu -->
  <div class="drawer-backdrop"></div>
  <aside id="mobile-navigation" class="mobile-drawer" aria-label="Mobile navigation">
    <div class="drawer-header">
      <div class="brand-logo">
        <img src="<?php echo esc_url($logo_rgb); ?>" alt="ILMA Education Consultancy logo" width="45" height="40">
        <div class="brand-text-wrap">
          <span class="brand-title">ILMA Education Consultancy</span>
          <span class="brand-sub">Study Abroad Guidance</span>
        </div>
      </div>
      <button type="button" class="close-drawer-btn" aria-label="Close mobile menu" style="background: none; border: none; cursor: pointer; color: var(--text-main); font-size: 1.5rem;">✕</button>
    </div>

    <ul class="mobile-nav-list">
      <li><a href="<?php echo esc_url(home_url('/destinations/')); ?>" class="mobile-nav-link">Study Destinations</a></li>
      <li><a href="<?php echo esc_url(home_url('/#why-ilma')); ?>" class="mobile-nav-link">Why select us</a></li>
      <li><a href="<?php echo esc_url(home_url('/about/')); ?>" class="mobile-nav-link">About</a></li>
      <li><a href="<?php echo esc_url(home_url('/services/')); ?>" class="mobile-nav-link">Services</a></li>
      <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mobile-nav-link">Contact Us</a></li>
      <li><a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="mobile-nav-link mobile-nav-link-priority">Reserve a consultation</a></li>
    </ul>

    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--surface-200);">
      <button type="button" class="btn btn-accent btn-block open-consultancy-modal" style="margin-bottom: 0.75rem;">
        Get Free Consultancy
      </button>
      <a href="tel:<?php echo esc_attr($phone1); ?>" class="btn btn-outline btn-block" style="font-size: 0.85rem;">
        📞 Call <?php echo esc_html($phone1); ?>
      </a>
    </div>
  </aside>
