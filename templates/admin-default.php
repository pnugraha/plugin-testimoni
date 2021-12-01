<div class="wrap">	
		<h1 class="wp-heading-inline">SS Testimoni</h1>
	<div class="row">
		<div class="col-12">
		<?php 

			global $wpdb;

			$table = new SS_Testimoni_Table();

			// Fetch, prepare, sort, and filter our data...
			if( isset($_REQUEST['s']) ){
				$table->prepare_items($_REQUEST['s']);
			} else {
				$table->prepare_items();
			}

			$message = '';
			if( 'delete' === $table->current_action() ){
				$ids = explode(',', $_REQUEST['ids']);
				$message = '<div id="message" class="updated notice notice-success is-dismissible"><p>' . sprintf( __( 'Items deleted: %d', 'hipwee' ), count($ids) ) . '</p></div>';
			}
		?>

		<div class="">
		<form id="ss-testimoni" method="GET" action="<?php echo admin_url().'?page=ss-testimoni'; ?>">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
			<?php $table->display() ?>
		</form>
		</div>
		</div>
	</div>
</div>


