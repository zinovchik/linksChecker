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
    printf("\n<script type='text/javascript'>var linksCheckerPath = '%s'; var linksSelector = '%s'; var imgSelector = '%s';</script>\n",
        plugins_url(),
        get_option('linksCheckerSelectorLinks') ? get_option('linksCheckerSelectorLinks') : 'a',
        get_option('linksCheckerSelectorImg') ? get_option('linksCheckerSelectorImg') : 'img'
    );
    wp_enqueue_script('LinksChecker', plugins_url('linksChecker.js', __FILE__));
}

function linksChecker() {
    //By default
    add_option('linksCheckerOn', true, '', 'no');
    add_option('linksCheckerSelectorLinks', 'a', '', 'no');
    add_option('linksCheckerSelectorImg', 'img', '', 'no');

    //Save settings
    if (isset($_POST['linksCheckerSaveSettings'])) {
        update_option('linksCheckerOn', $_POST['linksCheckerOn']);
        update_option('linksCheckerSelectorLinks', $_POST['linksCheckerSelectorLinks']);
        update_option('linksCheckerSelectorImg', $_POST['linksCheckerSelectorImg']);
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
                        <td>
                            <label>
                            Link Selector:
                            </label>
                        </td>
                        <td>
                            <input name='linksCheckerSelectorLinks' id='linksCheckerSelectorLinks' value='" . get_option('linksCheckerSelectorLinks') . "' type='text' />
                        </td>
				    </tr>
				    <tr>
                        <td>
                            <label>
                            Images Selector:
                            </label>
                        </td>
                        <td>
                            <input name='linksCheckerSelectorImg' id='linksCheckerSelectorImg' value='" . get_option('linksCheckerSelectorImg') . "' type='text' />
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

