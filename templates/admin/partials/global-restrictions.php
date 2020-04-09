<?php global $wp_roles; ?>

<?php 

if(isset($_POST) && isset($_POST['bp-block-global-restrictions-submit'])) {
	
	$global_restrictions = [];

	if(isset($_POST['bp-block-global-restrictions-can-block'])) {
		foreach($_POST['bp-block-global-restrictions-can-block'] as $role => $can_block) {
			$global_restrictions['can-block'][$role] = $can_block;
		}
	}

	if(isset($_POST['bp-block-global-restrictions-cant-be-blocked'])) {
		foreach($_POST['bp-block-global-restrictions-cant-be-blocked'] as $role => $cant_be_blocked) {
			$global_restrictions['cant-be-blocked'][$role] = $cant_be_blocked;
		}
	}

	if(count($global_restrictions)) {
		update_option('bp_block_global_restrictions', $global_restrictions);
	}
}

$global_restrictions = get_option('bp_block_global_restrictions', []);

?>

<form id="bp-block-global-restrictions-form" method="POST" action="" >

	<input id="submit-top" class="button button-primary" type="submit" value="Save changes" name="bp-block-global-restrictions-submit" />

	<p>Roles that can block</p>

	<table class="form-table">
		<tbody>

			<?php foreach($wp_roles->role_objects as $role): ?>
				
				<?php $checked_can_block = isset($global_restrictions['can-block']) && isset($global_restrictions['can-block'][$role->name]) ? ' checked="checked" ' : ''; ?>

				<tr>
					<th><?php echo ucfirst($role->name); ?></th>
					<td>
						<input 
							id="bp-block-global-restrictions-can-block-<?php echo $role->name; ?>" 
							name="bp-block-global-restrictions-can-block[<?php echo $role->name; ?>]" 
							type="checkbox" 
							value="1" 
							<?php echo $checked_can_block; ?>
						/>
					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

	<p>Roles that cannot be blocked</p>

	<table class="form-table">
		<tbody>

			<?php foreach($wp_roles->role_objects as $role): ?>
			
				<?php $checked_cant_be_blocked = isset($global_restrictions['cant-be-blocked']) && isset($global_restrictions['cant-be-blocked'][$role->name]) ? ' checked="checked" ' : ''; ?>

				<tr>
					<th><?php echo ucfirst($role->name); ?></th>
					<td>
						<input 
							id="bp-block-global-restrictions-cant-be-blocked-<?php echo $role->name; ?>" 
							name="bp-block-global-restrictions-cant-be-blocked[<?php echo $role->name; ?>]" 
							type="checkbox" 
							value="1" 
							<?php echo $checked_cant_be_blocked; ?>
						/>
					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

	<input id="submit-bottom" class="button button-primary" type="submit" value="Save changes" name="bp-block-global-restrictions-submit" />

</form>