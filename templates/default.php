<form id="testimoniForm" action="<?php esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
	<input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">
	<p>
		Your Name (required) <br/>
		<input type="text" name="ss-name" pattern="[a-zA-Z0-9 ]+" value="<?php isset( $_POST["ss-name"] ) ? esc_attr( $_POST["ss-name"] ) : '' ?>" size="40" />
	</p>
	<p>
		Your Email (required) <br/>
		<input type="email" name="ss-email" value="<?php isset( $_POST["ss-email"] ) ? esc_attr( $_POST["ss-email"] ) : '' ?>" size="40" />
	</p>
	<p>
		Phone Number (required) <br/>
		<input type="text" name="ss-phone-number" value="<?php isset( $_POST["ss-phone_number"] ) ? esc_attr( $_POST["testimoni-subject"] ) : '' ?>" size="40" />
	</p>
	<p>
		Your Message (required) <br/>
		<textarea rows="10" cols="35" name="ss-testimoni"> <?php isset( $_POST["-testimoni"] ) ? esc_attr( $_POST["-testimoni"] ) : '' ?></textarea>
	</p>
	<p><input type="submit" name="ss-submitted" value="Send"></p>
</form>