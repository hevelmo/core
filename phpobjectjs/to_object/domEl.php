<?php

function domEl() {
    $main_compiler_app = 'content-main-compiler-projects';
    return array(
        'recurrent_head' => 'head',
        'recurrent_body' => 'body',
        //GENERAL HI DIVS
        'div_hidden_inputs_session' => 'div#hidden-inputs-session',
        'div_hidden_inputs_temporal' => 'div#hidden-inputs-temporal',
        'div_recurrent' => 'div#content-temporal-interactive',
        //
        '_main_compiler_app' => $main_compiler_app,
        '_main_compiler_app_name' => '#' . $main_compiler_app,
    );
}
