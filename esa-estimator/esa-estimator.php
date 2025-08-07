<?php
/**
 * Plugin Name:       Phase I ESA Estimator
 * Plugin URI:        https://example.com/
 * Description:       A simple tool to estimate the cost of a Phase I ESA in Florida.
 * Version:           1.0.0
 * Author:            Your Name
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       esa-estimator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'ESA_ESTIMATOR_VERSION', '1.0.0' );

function esa_estimator_form_shortcode() {
    ob_start();
    ?>
    <form id="esa-estimator-form" class="esa-estimator-form">
        <div id="esa-estimator-result" class="esa-estimator-result" style="display: none;"></div>
        <p>
            <label for="property_size">Property Size (in acres)</label>
            <input type="number" id="property_size" name="property_size" required>
        </p>
        <p>
            <label for="parcel_id">Parcel ID</label>
            <input type="text" id="parcel_id" name="parcel_id" required>
        </p>
        <p>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
        </p>
        <p>
            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
        </p>
        <p>
            <label for="county">County</label>
            <select id="county" name="county" required>
                <option value="">Select a County</option>
                <option value="Alachua">Alachua</option>
                <option value="Baker">Baker</option>
                <option value="Bay">Bay</option>
                <option value="Bradford">Bradford</option>
                <option value="Brevard">Brevard</option>
                <option value="Broward">Broward</option>
                <option value="Calhoun">Calhoun</option>
                <option value="Charlotte">Charlotte</option>
                <option value="Citrus">Citrus</option>
                <option value="Clay">Clay</option>
                <option value="Collier">Collier</option>
                <option value="Columbia">Columbia</option>
                <option value="DeSoto">DeSoto</option>
                <option value="Dixie">Dixie</option>
                <option value="Duval">Duval</option>
                <option value="Escambia">Escambia</option>
                <option value="Flagler">Flagler</option>
                <option value="Franklin">Franklin</option>
                <option value="Gadsden">Gadsden</option>
                <option value="Gilchrist">Gilchrist</option>
                <option value="Glades">Glades</option>
                <option value="Gulf">Gulf</option>
                <option value="Hamilton">Hamilton</option>
                <option value="Hardee">Hardee</option>
                <option value="Hendry">Hendry</option>
                <option value="Hernando">Hernando</option>
                <option value="Highlands">Highlands</option>
                <option value="Hillsborough">Hillsborough</option>
                <option value="Holmes">Holmes</option>
                <option value="Indian River">Indian River</option>
                <option value="Jackson">Jackson</option>
                <option value="Jefferson">Jefferson</option>
                <option value="Lafayette">Lafayette</option>
                <option value="Lake">Lake</option>
                <option value="Lee">Lee</option>
                <option value="Leon">Leon</option>
                <option value="Levy">Levy</option>
                <option value="Liberty">Liberty</option>
                <option value="Madison">Madison</option>
                <option value="Manatee">Manatee</option>
                <option value="Marion">Marion</option>
                <option value="Martin">Martin</option>
                <option value="Miami-Dade">Miami-Dade</option>
                <option value="Monroe">Monroe</option>
                <option value="Nassau">Nassau</option>
                <option value="Okaloosa">Okaloosa</option>
                <option value="Okeechobee">Okeechobee</option>
                <option value="Orange">Orange</option>
                <option value="Osceola">Osceola</option>
                <option value="Palm Beach">Palm Beach</option>
                <option value="Pasco">Pasco</option>
                <option value="Pinellas">Pinellas</option>
                <option value="Polk">Polk</option>
                <option value="Putnam">Putnam</option>
                <option value="Santa Rosa">Santa Rosa</option>
                <option value="Sarasota">Sarasota</option>
                <option value_com">Seminole</option>
                <option value="St. Johns">St. Johns</option>
                <option value="St. Lucie">St. Lucie</option>
                <option value="Sumter">Sumter</option>
                <option value="Suwannee">Suwannee</option>
                <option value="Taylor">Taylor</option>
                <option value="Union">Union</option>
                <option value="Volusia">Volusia</option>
                <option value="Wakulla">Wakulla</option>
                <option value="Walton">Walton</option>
                <option value="Washington">Washington</option>
            </select>
        </p>
        <p>
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" required>
        </p>
        <p>
            <input type="checkbox" id="agree_to_contact" name="agree_to_contact" required>
            <label for="agree_to_contact">I agree to be contacted by your company.</label>
        </p>
        <p>
            <?php wp_nonce_field( 'esa_estimator_nonce', 'esa_estimator_nonce_field' ); ?>
            <button type="submit">Get Estimate</button>
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode( 'esa_estimator', 'esa_estimator_form_shortcode' );

/**
 * Calculate the estimated cost of a Phase I ESA.
 *
 * @param array $data The form data.
 * @return float The estimated cost.
 */
function esa_estimator_calculate_cost( $data ) {
    // --- CUSTOMIZE YOUR PRICING LOGIC HERE ---

    // 1. Base price for any Phase I ESA.
    $base_price = 1800.00;

    // 2. Price per acre.
    // The cost will increase for larger properties.
    // For example, add $10 for every acre.
    $price_per_acre = 10.00;

    // 3. County surcharges.
    // You can add a surcharge for specific counties.
    // For example, counties that are far away or have higher costs.
    // The key is the county name (as it appears in the form), and the value is the surcharge.
    $county_surcharges = array(
        'Miami-Dade' => 200.00,
        'Broward'    => 150.00,
        'Palm Beach' => 150.00,
        'Monroe'     => 300.00, // Keys are far
    );

    // --- END OF CUSTOMIZABLE LOGIC ---

    $estimated_cost = $base_price;

    // Calculate cost based on property size.
    $property_size = floatval( $data['property_size'] );
    if ( $property_size > 1 ) {
        $estimated_cost += ( $property_size - 1 ) * $price_per_acre;
    }

    // Add county surcharge if applicable.
    $county = sanitize_text_field( $data['county'] );
    if ( array_key_exists( $county, $county_surcharges ) ) {
        $estimated_cost += $county_surcharges[ $county ];
    }

    return $estimated_cost;
}

function esa_estimator_enqueue_scripts() {
    // Enqueue the stylesheet
    wp_enqueue_style(
        'esa-estimator-css',
        plugin_dir_url( __FILE__ ) . 'css/esa-estimator.css',
        array(),
        ESA_ESTIMATOR_VERSION
    );

    // Enqueue the javascript file
    wp_enqueue_script(
        'esa-estimator-js',
        plugin_dir_url( __FILE__ ) . 'js/esa-estimator.js',
        array(),
        ESA_ESTIMATOR_VERSION,
        true
    );

    // Pass the ajax_url to our script
    wp_localize_script(
        'esa-estimator-js',
        'esa_estimator_ajax',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'wp_enqueue_scripts', 'esa_estimator_enqueue_scripts' );


function esa_estimator_get_estimate_ajax_handler() {
    // Check for nonce security
    if ( ! check_ajax_referer( 'esa_estimator_nonce', 'esa_estimator_nonce_field', false ) ) {
        wp_send_json_error( array( 'message' => 'Nonce verification failed.' ), 403 );
    }

    // --- CUSTOMIZE EMAIL SETTINGS ---
    $admin_email = get_option( 'admin_email' ); // Default to admin email
    $to_email = 'your-email@example.com'; // <--- CHANGE THIS to the email address where you want to receive leads.
    if ($to_email === 'your-email@example.com') {
        $to_email = $admin_email;
    }
    $email_subject = 'New Phase I ESA Estimate Request';
    // --- END OF CUSTOMIZABLE EMAIL SETTINGS ---

    // Sanitize and validate input
    $required_fields = array( 'property_size', 'parcel_id', 'address', 'city', 'county', 'email', 'agree_to_contact' );
    foreach ( $required_fields as $field ) {
        if ( empty( $_POST[ $field ] ) ) {
            wp_send_json_error( array( 'message' => 'Please fill out all required fields.' ), 400 );
        }
    }

    $form_data = array(
        'property_size' => sanitize_text_field( $_POST['property_size'] ),
        'parcel_id'     => sanitize_text_field( $_POST['parcel_id'] ),
        'address'       => sanitize_text_field( $_POST['address'] ),
        'city'          => sanitize_text_field( $_POST['city'] ),
        'county'        => sanitize_text_field( $_POST['county'] ),
        'email'         => sanitize_email( $_POST['email'] ),
    );

    // Calculate the cost
    $estimated_cost = esa_estimator_calculate_cost( $form_data );

    // Prepare email content
    $email_body = "A new Phase I ESA estimate has been requested.\n\n";
    $email_body .= "Property Size: " . $form_data['property_size'] . " acres\n";
    $email_body .= "Parcel ID: " . $form_data['parcel_id'] . "\n";
    $email_body .= "Address: " . $form_data['address'] . "\n";
    $email_body .= "City: " . $form_data['city'] . "\n";
    $email_body .= "County: " . $form_data['county'] . "\n";
    $email_body .= "Contact Email: " . $form_data['email'] . "\n\n";
    $email_body .= "Estimated Cost: $" . number_format( $estimated_cost, 2 ) . "\n";

    // Send email
    wp_mail( $to_email, $email_subject, $email_body );

    // Prepare success message for the user
    $success_message = '<h3>Your Estimated Cost: $' . number_format( $estimated_cost, 2 ) . '</h3>';
    $success_message .= '<p>Thank you for your request. We will be in touch with you shortly.</p>';
    $success_message .= '<p><strong>Disclaimer:</strong> This is only an estimate. The actual cost may vary.</p>';

    wp_send_json_success( array( 'message' => $success_message ) );
}
add_action( 'wp_ajax_nopriv_esa_estimator_get_estimate', 'esa_estimator_get_estimate_ajax_handler' );
add_action( 'wp_ajax_esa_estimator_get_estimate', 'esa_estimator_get_estimate_ajax_handler' );
