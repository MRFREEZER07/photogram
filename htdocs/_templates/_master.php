<!DOCTYPE html>
<html lang="en">
<?php Session::loadTemplate("_head"); ?>

<body>
	<?php Session::loadTemplate("_header");?>

	<main>
		<?php
            if (Session::$isError) {
                Session::loadTemplate('_error');
            } else {
                Session::loadTemplate(Session::currentScript());
            }
?>
	</main>
	<?php Session::loadTemplate('_footer'); ?>
	<script
		src="<?=$_SERVER['DOCUMENT_ROOT']?>/assets/dist/js/bootstrap.bundle.min.js">
	</script>

</body>