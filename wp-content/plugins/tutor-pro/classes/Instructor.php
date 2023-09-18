<?php
/**
 * Manage Instructor Related Logic for PRO
 *
 * @package TutorPro
 *
 * @since 2.1.0
 */

namespace TUTOR_PRO;

use Tutor\Models\WithdrawModel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Instructor
 *
 * @since 2.2.4
 */
class Instructor {
	/**
	 * Register hooks.
	 *
	 * @since 2.2.4
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'tutor_after_instructor_list_commission_column', array( $this, 'add_account_summary_column' ) );
		add_action( 'tutor_after_instructor_list_commission_column_data', array( $this, 'add_account_summary_data' ) );
	}

	/**
	 * Add account summary column in instructors table.
	 *
	 * @since 2.2.4
	 *
	 * @return void
	 */
	public function add_account_summary_column() {
		?>
		<th class="tutor-table-rows-sorting" width="20%">
			<?php esc_html_e( 'Account Summary', 'tutor-pro' ); ?>
		</th>
		<?php
	}

	/**
	 * Add account summary data.
	 *
	 * @since 2.2.4
	 *
	 * @param int $instructor_id instructor id.
	 *
	 * @return void
	 */
	public function add_account_summary_data( $instructor_id ) {
		$summary = WithdrawModel::get_withdraw_summary( $instructor_id );
		?>
		<td>
			<div class="tutor-d-flex tutor-align-center tutor-gap-1">
				<span class="tutor-fs-7 tutor-color-muted"><?php esc_html_e( 'Earnings:', 'tutor-pro' ); ?></span> 
				<?php echo wp_kses_post( tutor_utils()->tutor_price( $summary->total_income ) ); ?>
			</div>
			<div class="tutor-d-flex tutor-align-center tutor-gap-1">
				<span class="tutor-fs-7 tutor-color-muted"><?php esc_html_e( 'Withdrawal:', 'tutor-pro' ); ?></span> 
				<?php echo wp_kses_post( tutor_utils()->tutor_price( $summary->total_withdraw ) ); ?>
			</div>
			<div class="tutor-d-flex tutor-align-center tutor-gap-1">
				<span class="tutor-fs-7 tutor-color-muted"><?php esc_html_e( 'Balance:', 'tutor-pro' ); ?></span> 
				<!-- tooltip -->
				<div class="tooltip-wrap">
					<?php echo wp_kses_post( tutor_utils()->tutor_price( $summary->current_balance ) ); ?>
					<span class="tooltip-txt tooltip-top tutor-nowrap-ellipsis">
						<?php
							esc_html_e( 'Withdrawable: ', 'tutor-pro' );
							echo wp_kses_post( tutor_utils()->tutor_price( $summary->available_for_withdraw ) );
						?>
					</span>
				</div>
				<!-- end tooltip -->
			</div>
		</td>
		<?php
	}
}
