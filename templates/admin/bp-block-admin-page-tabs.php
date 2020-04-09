<?php foreach($tabs as $tab) : ?>

	<a class="nav-tab <?php echo $tab['active_class']; ?>" href="<?php echo $tab['link']; ?>">
		<?php echo $tab['title']; ?>
	</a>

<?php endforeach; ?>