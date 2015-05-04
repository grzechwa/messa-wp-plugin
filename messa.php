<?php 
/*
Plugin Name: Messa
Plugin URI: grzechurek.cba.pl
Description: Messa is the application that ...
Version: 0.1
Author: GrzegorzZ
Author URI: grzechurek.cba.pl
License: GPLv2 or later
Text Domain: Messa
*/
/*
License text about GPLv2 or later ....
*/

function messa_add_page(){
    add_options_page( 'messa options' , 'messa', 10, 'messa/options.php');
}

add_action('admin_menu', 'messa_add_page');

// add_action('admin_init', 'messa_plugin_admin_init');
// function messa_plugin_admin_init(){
//     register_setting('messa_plugin_option', 'messa_plugin_option', 'messa_plugin_validate_options');
//     add_settings_section('messa_plugin_main', 'Ustawinia wtyczki', 'messa_plugin_validate_section_text', 'messa_plugin');
//     add_settings_field('messa_plugin_text_string', 'Podaj dowolny tekst', 'messa_plugin_setting_input', 'messa_plugin', 'messa_plugin_main');
// }



// $arrLocale = array( "pl_PL", "polish_pol" );
// setlocale(LC_ALL, $arrLocale );
// przetwarzanie pliku xml dla 3 wezlow
function get_xml($plik){
    $xml    = simplexml_load_file($plik);
    $query  = simplexml_load_file($plik);
    $nrWeek = date(W);          /* day of Week in Year */
    $dmY    = date('d.m.Y');    /* dmY - daymontYear of actual day*/

    $getDay=$query->xpath('tydzien[@nr='.$nrWeek.']/dzien[@data="'.$dmY.'"]');
    $nameDay=ucfirst(strftime("%A", strtotime($getDay[0][data])));

    $nowiny=$query->xpath('tydzien[@nr='.$nrWeek.']/dzien[@data="'.$dmY.'"]/anons');
    echo '<table  class="table table-bordered tabela-msze"  >
        <th colspan=2 style="text-align: center" >'.$nameDay . '<br />';
            foreach($getDay as $res){
                echo $res->wspomnienie . '<br />';
            }
            foreach($getDay as $res){
                echo $res->event;
            }
        echo '</th>'; 
        foreach($nowiny as $anons){
            echo '<tr><td>'.$anons->godz. '</td><td>';
            foreach($anons->item as $item){
                echo  $item.'<br />' ; 
            }
            echo '</td></tr>';
        }
    echo '</table>';
}
function show_messa(  ){
    get_xml(plugin_dir_path( __FILE__ ).'rozklad.xml');
}
function messa_notice() {
    ?>
    <div class="updated">
        <p><?php _e( 'Updated!', 'my-text-domain' ); ?></p>
    </div>
    <?php
}
// add_action( 'admin_notices', 'messa_notice' );

add_shortcode( 'messa', 'show_messa' );
?>


