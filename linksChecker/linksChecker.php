<?php
/**
 * @package linksChecker
 * @version 1.0
 */
/*
Plugin Name: linksChecker
Plugin URI: https://github.com/zinovchik/linksChecker
Description: This plugin determines not working links and images on the page and display information about them to the console.
Author: Maxim Zinovchik
Version: 1.0
*/

add_action('admin_menu', 'addMenuLinksChecker');

if (get_option('linksCheckerOn')) {
    add_action('wp_footer', 'functionAddLinksChecker');
}

function addMenuLinksChecker() {
    add_menu_page('Links Checker', 'Links Checker', 8, 'linksChecker', 'linksChecker');
}

function functionAddLinksChecker() {
    printf("\n<script type='text/javascript'>var linksCheckerPath = '%s';</script>\n", plugins_url());
    wp_enqueue_script('LinksChecker', plugins_url('linksChecker.js', __FILE__));
}

function linksChecker() {
    //By default
    add_option('linksCheckerOn', true, '', 'no');

    //Save settings
    if (isset($_POST['linksCheckerSaveSettings'])) {
        update_option('linksCheckerOn', $_POST['linksCheckerOn']);
    }

    printf("<h2>Links Checker Settings:</h2>
          <form method='POST' class='linksChecker'>
            <table>
                <tbody>
                    <tr>
                        <td colspan='2'>
                            <label>
                                <input name='linksCheckerOn' id='linksCheckerOn' type='checkbox' %s />
                                Links Checker Active
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input name='linksCheckerSaveSettings' id='linksCheckerSaveSettings' class='button button-primary' type='submit' value='Save' />
                        </td>
                    </tr>
                </tbody>
            </table>
         </form>", (get_option('linksCheckerOn') ? 'checked=\'checked\'' : ''));
}

