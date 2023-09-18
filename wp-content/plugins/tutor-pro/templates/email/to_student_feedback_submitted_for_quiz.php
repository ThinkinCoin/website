<?php
/**
 * E-mail template for student when feedback submitted for quiz.
 *
 * @package TutorPro
 * @subpackage Templates\Email
 *
 * @since 2.0.0
 */

$bg_image_url = apply_filters( 'tutor_email_bg', TUTOR_EMAIL()->default_bg );
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
	<?php require TUTOR_EMAIL()->path . 'views/email_styles.php'; ?>
</head>

<body>
	<div class="tutor-email-body">
		<div class="tutor-email-wrapper" style="background-color: #fff;">


			<?php require TUTOR_PRO()->path . 'templates/email/email_header.php'; ?>
			<div class="tutor-email-content"
				<?php if ( ! empty( $bg_image_url ) ) : ?>
				style="background: url(<?php echo esc_url( $bg_image_url ); ?>) top right no-repeat;"
				<?php endif; ?>>
				<?php require TUTOR_PRO()->path . 'templates/email/email_heading_content.php'; ?>

				<div class="tutor-email-buttons">
					<a target="_blank" class="tutor-email-button" href="{review_url}"><?php esc_html_e( 'Go to Quiz Review', 'tutor-pro' ); ?></a>
				</div>

			</div>
		</div>
	</div>
</body>
</html>
