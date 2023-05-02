<?php

function donate_blood_deactivate()
{
    unregister_post_type("donate_blood_donor");
    flush_rewrite_rules();
}
