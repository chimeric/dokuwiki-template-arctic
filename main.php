<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/**
 * DokuWiki Arctic Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 * additional editing by
 * @author Michael Klier <chi@chimeric.de>
 *
 * Last update: 2006-01-18
 */

 require_once(dirname(__FILE__).'/tpl_functions.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <title><?php tpl_pagetitle()?> [<?php echo hsc($conf['title'])?>]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_BASE?>lib/images/favicon.ico" />

  <!--[if IE]>
  <style type="text/css">
    /* that IE 5+ conditional comment makes this only visible in IE 5+ */
    /* IE bugfix for transparent PNGs */
    /* img { behavior: url("<?php echo DOKU_BASE?>lib/scripts/pngbehavior.htc"); }*/
    body { behavior: url("<?php echo DOKU_TPL?>csshover.htc"); }
  </style>
  <![endif]-->

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
</head>

<body>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>
<div class="dokuwiki">

  <?php html_msgarea()?>

  <div class="stylehead">
    <div class="header">
      <div class="logo">
        <?php tpl_link(wl(),$conf['title'],'name="top" accesskey="h" title="[ALT+H]"') ?>
      </div>
    </div>
  
    <?php if($conf['tpl_arctic']['breadcrumbs'] && $conf['tpl_arctic']['breadcrumbs_top']) {?> 
    <div style="margin-left:10px;margin-bottom:3px;margin-top:3px;"><?php tpl_breadcrumbs()?> </div>
    <?php } ?>

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>
    </div>

    <div class="bar" id="bar_top">
      <?php if($conf['tpl_arctic']['position'] == 0) { ?>
      <div class="bar-right">
      <?php } else { ?>
      <div class="bar-left">
        <?php } ?>
        <?php tpl_topbar() ?>
      </div>

  </div>

  <?php flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <?php if($conf['tpl_arctic']['enable_sidebar']) { ?>
    <?php if($conf['tpl_arctic']['position'] == 0) { ?>

      <div class="left_sidebar">
        <div class="searchform">
          <?php tpl_searchform() ?>
        </div>
          <?php tpl_sidebar() ?>
      </div>
      <div class="right_page">
        <?php tpl_content()?>
      </div>

    <?php } else { ?>

      <div class="left_page">
        <?php tpl_content()?>
      </div>

      <div class="right_sidebar">
        <div class="searchform">
          <?php tpl_searchform() ?>
        </div>
          <?php tpl_sidebar() ?>
      </div>
      
    <?php } ?>

  <?php } else { ?>

    <div class="page">
      <?php tpl_content() ?>
    </div>

  <?php } ?>

  <div class="clearer">&nbsp;</div>

  <?php flush()?>

  <div class="stylefoot">
    <div class="meta">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php tpl_pageinfo()?>
      </div>
    </div>
    <?php /*old includehook*/ @include(dirname(__FILE__).'/pagefooter.html')?>
  </div>

<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>
</div>

<?php tpl_indexerWebBug();?>

</body>
</html>
