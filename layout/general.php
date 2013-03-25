<?php echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title; ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
	<meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
	<?php echo $OUTPUT->standard_head_html(); ?>
	<script type="text/javascript">
	//<![CDATA[
		var SERVER = "<?php echo $CFG->wwwroot; ?>";
		var THEME = "<?php echo get_string('pluginname','theme_cubic'); ?>";
		var DEFAULT_VIEW_MODE = "<?php echo cubic_get_activities_view(); ?>";
	//]]>
	</script>
</head>

<?php $conditions = cubic_get_layout_conditions(); ?>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($conditions['body-classes']) ?>">
<?php echo $OUTPUT->standard_top_of_body_html(); ?>

<!-- START OF USER BAR -->
<?php if($conditions['bar']) { include 'userbar.php'; } ?>
<!-- END OF USER BAR -->

<div id="page">
<?php if ($conditions['navbar'] || $conditions['custom-menu']) { ?>
	<!-- START OF HEADER -->
	<div id="page-header">
		<?php if ($conditions['custom-menu']) { ?>
			<div id="custommenuwrap">
				<div id="custommenu">
					<?php echo $conditions['custom-menu-content']; ?>
				</div>
			</div>
		<?php } ?>

    	<?php if ($conditions['navbar']) { ?>
			<div class="navbar">
				<div class="wrapper clearfix">
					<div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
					<div class="navbutton">
						<?php echo $PAGE->button; ?>
					</div>
					<?php if($conditions['course-view']) { ?>
						<div class="activities-views">
							<div class="icons button left">
								<img src="<?php echo $OUTPUT->pix_url('buttons/icons', 'theme'); ?>" />
							</div>
							<div class="list button right">
								<img src="<?php echo $OUTPUT->pix_url('buttons/list', 'theme'); ?>" />
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- END OF HEADER -->
<?php } ?>

<!-- START OF CONTENT -->
<div id="page-content-wrapper" class="wrapper clearfix">
    <div id="page-content">
		<?php if ($conditions['blocks']) { ?>
        	<div id="region-main-box">
            	<div id="region-post-box">

                	<div id="region-main-wrap">
                    	<div id="region-main">
                        	<div class="region-content">
                            	<?php echo $OUTPUT->main_content(); ?>
                        	</div>
                    	</div>
                	</div>

                	<?php if ($conditions['side-pre']) { ?>
                		<div id="region-pre" class="block-region">
                    		<div class="region-content">
                        		<?php echo $OUTPUT->blocks_for_region('side-pre'); ?>
                    		</div>
                		</div>
                	<?php } ?>

                	<?php if ($conditions['side-post']) { ?>
                		<div id="region-post" class="block-region">
                    		<div class="region-content">
                        		<?php echo $OUTPUT->blocks_for_region('side-post'); ?>
                    		</div>
                		</div>
                	<?php } ?>
            	</div>
			</div>
		<?php } else { ?>
			<div class="region-content">
            	<?php echo $OUTPUT->main_content(); ?>
        	</div>
		<?php } ?>
    </div>
</div>
<!-- END OF CONTENT -->

<?php if ($conditions['footer']) { ?>
	<!-- START OF FOOTER -->
	<div id="page-footer" class="wrapper">
		<p class="copyright"><b>&copy;</b> 2012 <b><?php echo cubic_get_title(); ?></b></p>
		<div class="images">
			<img src="<?php echo $OUTPUT->pix_url('moodlelogo', ''); ?>" />
			<img src="<?php echo $OUTPUT->pix_url('footer', 'theme'); ?>" />
		</div>
		<p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')); ?></p>
		<?php echo $OUTPUT->standard_footer_html(); ?>
	</div>
	<!-- END OF FOOTER -->
<?php } ?>

<div class="feedback">
	<a href="https://docs.google.com/spreadsheet/viewform?formkey=dGZFeG12eWJvelEzVlpDUzNIaUN3QXc6MQ#gid=0" target="_blanck"><?php echo get_string('feedback'); ?></a>
</div>

</div>
<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>