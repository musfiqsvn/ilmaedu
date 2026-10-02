# ILMA Education Consultancy WordPress Theme

A self-contained WordPress theme for ILMA Education Consultancy. The theme keeps the existing native WordPress architecture—custom post types, editable admin settings, AJAX lead capture and appointment booking—while organising the public site around a clearer student conversion journey.

## Public experience

- Compact, responsive hero with a visible eligibility CTA.
- Data-driven study destination journey for:
  - United Kingdom
  - New Zealand
  - Canada
  - Malaysia
  - South Korea
  - Japan
- Reusable destination cards and detail pages with:
  - Why this country
  - Universities to explore
  - Check your eligibility
  - Apply now
- Original ILMA service content covering selection, eligibility, applications, visas, scholarships, pre-departure and post-study planning.
- Dedicated Why Select ILMA, process, contact and WhatsApp conversion areas.
- Configurable WhatsApp number in **UTurnEdu Settings**. It is used by the floating action, CTA links and contact areas rather than repeated hardcoded links.
- Accessible mobile drawer, focus states, labelled forms and reduced-motion support.

## Architecture

```text
uturnedu1/
├── assets/
│   ├── css/main.css
│   ├── js/main.js
│   └── images/
├── inc/
│   ├── content-data.php       # shared destination/service catalogs and helpers
│   ├── custom-post-types.php
│   ├── meta-boxes.php
│   ├── auto-install.php       # pages, menus and starter data
│   └── ...
├── archive-destination.php
├── single-destination.php
├── archive-service.php
├── single-service.php
├── front-page.php
├── header.php
├── footer.php
└── style.css
```

Destination and service cards are rendered from reusable data. Adding another destination means adding one catalog entry and its local image, not copying a new template.

## Installation

1. Upload `uturnedu1` to `wp-content/themes/` or zip the folder for WordPress upload.
2. Activate it under **Appearance → Themes**.
3. The installer creates the core pages, custom post type starter data and menus. Existing `usa` and `australia` starter destinations migrate to South Korea and Japan when the theme updates to setup version `2.1.0`.
4. Update contact details, WhatsApp number, logos and other settings under **UTurnEdu Dashboard → Agency Settings**.

The theme uses native WordPress APIs and does not require Elementor, WPBakery or a third-party page builder.
