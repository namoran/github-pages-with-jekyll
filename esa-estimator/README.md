# Phase I ESA Estimator

A simple WordPress plugin that provides a Phase I ESA estimation tool. Customers can use the tool to estimate the cost of a Phase I ESA anywhere in the state of Florida.

## Description

This plugin creates a shortcode that displays a form on your website. The form allows users to enter information about their property, and in return, they receive an estimated cost for a Phase I ESA. The user is required to enter their email address and agree to be contacted, making this a useful tool for lead generation.

The cost calculation is designed to be easily customizable by editing the plugin's main PHP file.

## Installation

1.  Download the `esa-estimator` directory as a ZIP file.
2.  In your WordPress admin panel, go to **Plugins > Add New**.
3.  Click **Upload Plugin** at the top of the page.
4.  Upload the ZIP file you downloaded.
5.  Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

To display the estimation form on a page or post, simply add the following shortcode to the content:

`[esa_estimator]`

## Customization

You can customize the cost calculation logic and the email settings by editing the `esa-estimator.php` file.

### Customizing the Cost Calculation

Open the `esa-estimator.php` file and find the `esa_estimator_calculate_cost` function. Inside this function, you will find a section marked with `--- CUSTOMIZE YOUR PRICING LOGIC HERE ---`.

You can change the following variables:

*   `$base_price`: The base price for any Phase I ESA.
*   `$price_per_acre`: The additional cost for each acre of the property.
*   `$county_surcharges`: An array of surcharges for specific counties. You can add, edit, or remove counties and their corresponding surcharges.

### Customizing Email Settings

In the `esa_estimator_get_estimate_ajax_handler` function, you can change the email address where lead notifications are sent. Find the line:

`$to_email = 'your-email@example.com';`

And change `'your-email@example.com'` to your desired email address. If you don't change it, it will default to the site administrator's email address.
