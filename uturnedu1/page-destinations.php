<?php
/**
 * Template Name: Study Destinations Page
 *
 * Page template fallback for the Study Destinations page.
 *
 * The custom post type archive uses archive-destination.php; this wrapper keeps
 * the auto-created /destinations/ page working on installs where a page route
 * takes precedence over the post type archive.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

require get_template_directory() . '/archive-destination.php';
