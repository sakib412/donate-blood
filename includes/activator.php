<?php


function donate_blood_post_type()
{
    // Create donor post type
    register_post_type('donate_blood_donor', array(
        "label" => array(
            "name" => "Donors",
            "singular_name" => "Donor",
        ),
        "show_in_menu" => true,
    ));
}

add_action("init", "donate_blood_post_type");

function donate_blood_activate()
{
    donate_blood_post_type();
    flush_rewrite_rules();
}
