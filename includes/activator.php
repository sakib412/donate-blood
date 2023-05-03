<?php

function donate_blood_activate()
{
    donate_blood_post_type();
    flush_rewrite_rules();
}
