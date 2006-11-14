<?php
/**
 * configuration-manager metadata for the arctic-template
 * 
 * @license:    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author:     Michael Klier <chi@chimeric.de>
 */

$meta['sidebar']                  = array('multichoice', '_choices' => array('left', 'right', 'none'));
$meta['pagename']                 = array('string', '_pattern' => '#[a-z]*');
$meta['toc2sidebar']              = array('onoff');
$meta['breadcrumbs']              = array('multichoice', '_choices' => array('top', 'sidebar', 'both'));
$meta['wiki_actionlinks']         = array('multichoice', '_choices' => array('links', 'buttons'));
$meta['user_sidebar']             = array('onoff');
$meta['user_sidebar_namespace']   = array('string', '_pattern' => '#^[a-z:]*#');
$meta['group_sidebar']            = array('onoff');
$meta['group_sidebar_namespace']  = array('string', '_pattern' => '#^[a-z:]*#');
$meta['namespace_sidebar']        = array('onoff');
$meta['sidebar_order']            = array('multichoice', '_choices' => array(
                                                                        'T-U-G-N-M','M-N-T-U-G','N-M-U-G-T',
                                                                        'T-N-M-U-G','N-M-T-U-G','U-G-T-N-M'
                                                                        ));

//Setup vim: ts=2 sw=2:
?>
