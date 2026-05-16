
=== Kaddora AI Property & Rental Management ===
Contributors: kaddoratech
Tags: property management, rent, tenants, invoices, payments, ai, whatsapp
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

AI-ready property and rental management for WordPress with tenants, payments, invoices, reminders, and multi-channel notifications.

== Description ==

Kaddora AI Property & Rental Management helps manage rental properties, tenants, invoices, payments, and communication from a clean WordPress admin interface.

Core features:

* Property management
* Tenant management
* Rent payments
* Monthly invoice generation
* Email reminders
* WhatsApp-ready notification logging
* AI-generated reminder messages
* REST API structure
* Free vs Pro architecture

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Open `Kaddora Property` from the admin menu.
4. Add properties, tenants, invoices, and payments.

== Frequently Asked Questions ==

= Does WhatsApp send real messages now? =

No. WhatsApp is currently simulated through the WordPress debug log. The integration is ready for Twilio, Meta Cloud API, Gupshup, Interakt, or another provider.

= How do I enable WhatsApp logs? =

Enable `WP_DEBUG` and `WP_DEBUG_LOG` in `wp-config.php`, then check `/wp-content/debug.log`.

= Does this include a Pro license server? =

No. The plugin includes a license-ready Pro lock architecture that can later connect to Gumroad, Freemius, or a custom license API.

== Screenshots ==

1. Dashboard overview
2. Property management
3. Tenant management
4. Payments and invoices
5. AI reminders and notification workflow

== Changelog ==

= 1.0.0 =

* Initial release.
* Added properties, tenants, payments, invoices, AI reminders, email, WhatsApp-ready logging, REST APIs, and Pro-ready architecture.
