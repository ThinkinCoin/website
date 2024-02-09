<?php
/**
 * Assignment Controller
 *
 * Manage API for assignment
 *
 * @package TutorPro\RestAPI
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 2.6.0
 */

namespace TutorPro\RestAPI\Controllers;

use Exception;
use Tutor\Helpers\ValidationHelper;
use TUTOR\Input;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assignment Controller
 */
class AssignmentController extends BaseController {

	/**
	 * Assignment options short hand
	 *
	 * @since 2.6.0
	 *
	 * @var string
	 */
	const ASS_OPT = 'assignment_options';

	/**
	 * Operation codes
	 *
	 * @since 2.6.0
	 *
	 * @var string
	 */
	public $operation = 'assignment';

	/**
	 * Fillable fields
	 *
	 * @since 2.6.0
	 *
	 * @var array
	 */
	private $fillable_fields = array(
		'topic_id',
		'assignment_title',
		'assignment_content',
		'assignment_author',
		'attachments',
		self::ASS_OPT,
	);

	/**
	 * Required fields
	 *
	 * @since 2.6.0
	 *
	 * @var array
	 */
	private $required_fields = array(
		'topic_id',
		'assignment_title',
		'assignment_author',
		self::ASS_OPT,
	);

	/**
	 * Assignment options with default value
	 *
	 * @since 2.6.0
	 *
	 * @var array
	 */
	private $allowed_options = array(
		'time_duration'          => array(
			'value' => 1,
			'time'  => 'weeks',
		),
		'total_mark'             => 10,
		'pass_mark'              => 2,
		'upload_files_limit'     => 1,
		'upload_file_size_limit' => 2,
	);

	/**
	 * Assignment allowed time options
	 *
	 * @since 2.6.0
	 *
	 * @var array
	 */
	private $allowed_time_options = array( 'weeks', 'days', 'hours' );

	/**
	 * Assignment post type
	 *
	 * @since 2.6.0
	 *
	 * @var string
	 */
	private $post_type;

	/**
	 * Initialize props
	 *
	 * @since 2.6.0
	 */
	public function __construct() {
		parent::__construct();

		$this->post_type = tutor()->assignment_post_type;
	}

	/**
	 * Handle assignment create API request
	 *
	 * @since 2.6.0
	 *
	 * @param WP_REST_Request $request request obj.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function create( WP_REST_Request $request ) {
		$errors = array();

		// Get params and sanitize it.
		$params = Input::sanitize_array(
			$request->get_params(),
			array(
				'assignment_content' => 'wp_kses_post',
			)
		);

		// Extract fillable fields.
		$params = array_intersect_key( $params, array_flip( $this->fillable_fields ) );

		$params['post_type'] = $this->post_type;

		// Set empty value if required fields not set.
		foreach ( $this->required_fields as $field ) {
			if ( ! isset( $params[ $field ] ) ) {
				$params[ $field ] = '';
			}
		}

		// Validate request.
		$validation = $this->validate( $params );
		if ( ! $validation->success ) {
			$errors = $validation->errors;
		}

		if ( ! empty( $errors ) ) {
			return $this->response(
				$this->code_create,
				__( 'Assignment create failed', 'tutor-pro' ),
				$errors,
				$this->client_error_code
			);
		}

		$assignment_data = array(
			'post_type'    => $this->post_type,
			'post_status'  => 'publish',
			'post_author'  => $params['assignment_author'],
			'post_parent'  => $params['topic_id'],
			'post_title'   => $params['assignment_title'],
			'post_name'    => $params['assignment_title'],
			'post_content' => $params['assignment_content'] ?? '',
		);

		$post_id = wp_insert_post( $assignment_data );
		if ( is_wp_error( $post_id ) ) {
			return $this->response(
				$this->code_create,
				__( 'Assignment create failed', 'tutor-pro' ),
				$post_id->get_error_message(),
				$this->server_error_code
			);
		} elseif ( ! $post_id ) {
			return $this->response(
				$this->code_create,
				__( 'Assignment create failed', 'tutor-pro' ),
				$post_id,
				$this->client_error_code
			);
		} else {
			$this->update_post_meta( $post_id, $params );
			return $this->response(
				$this->code_create,
				__( 'Assignment created successfully', 'tutor-pro' ),
				$post_id
			);
		}
	}

	/**
	 * Handle assignment update API request
	 *
	 * @since 2.6.0
	 *
	 * @param WP_REST_Request $request request obj.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function update( WP_REST_Request $request ) {
		$errors = array();

		// Get params and sanitize it.
		$params = Input::sanitize_array(
			$request->get_params(),
			array(
				'assignment_content' => 'wp_kses_post',
			)
		);

		// Extract fillable fields.
		$params       = array_intersect_key( $params, array_flip( $this->fillable_fields ) );
		$params['ID'] = $request->get_param( 'id' );

		// Validate request.
		$validation = $this->validate( $params );
		if ( ! $validation->success ) {
			$errors = $validation->errors;
		}

		if ( ! empty( $errors ) ) {
			return $this->response(
				$this->code_update,
				__( 'Assignment updated failed', 'tutor-pro' ),
				$errors,
				$this->client_error_code
			);
		}

		$assignment_data = array(
			'ID' => $params['ID'],
		);

		if ( isset( $params['assignment_title'] ) ) {
			$assignment_data['post_title'] = $params['assignment_title'];
		}
		if ( isset( $params['assignment_content'] ) ) {
			$assignment_data['post_content'] = $params['assignment_content'];
		}
		if ( isset( $params['assignment_author'] ) ) {
			$assignment_data['post_author'] = $params['assignment_author'];
		}
		if ( isset( $params['topic_id'] ) ) {
			$assignment_data['post_parent'] = $params['post_parent'];
		}

		$post_id = wp_update_post( $assignment_data );
		if ( is_wp_error( $post_id ) ) {
			return $this->response(
				$this->code_update,
				__( 'Assignment update failed', 'tutor-pro' ),
				$post_id->get_error_message(),
				$this->server_error_code
			);
		} else {
			$this->update_post_meta( $post_id, $params );
			return $this->response(
				$this->code_update,
				__( 'Assignment updated successfully', 'tutor-pro' ),
				$post_id
			);
		}
	}

	/**
	 * Prepare assignment meta data for update
	 *
	 * @since 2.6.0
	 *
	 * @param int   $post_id post id.
	 * @param array $params params.
	 *
	 * @throws Exception Throw new exception.
	 *
	 * @return void
	 */
	private function update_post_meta( int $post_id, array $params ) {
		if ( isset( $params[ self::ASS_OPT ] ) ) {
			if ( ! empty( $params[ self::ASS_OPT ] ) ) {
				$this->allowed_options['time_duration']['value'] = $params[ self::ASS_OPT ]['time_duration']['value'] ?? $this->allowed_options['time_duration']['value'];

				$this->allowed_options['time_duration']['time'] = $params[ self::ASS_OPT ]['time_duration']['unit'] ?? $this->allowed_options['time_duration']['unit'];

				$this->allowed_options['total_mark'] = $params[ self::ASS_OPT ]['total_mark'] ?? $this->allowed_options['total_mark'];

				$this->allowed_options['pass_mark'] = $params[ self::ASS_OPT ]['pass_mark'] ?? $this->allowed_options['pass_mark'];

				$this->allowed_options['upload_files_limit'] = $params[ self::ASS_OPT ]['upload_files_limit'] ?? $this->allowed_options['upload_files_limit'];

				$this->allowed_options['upload_file_size_limit'] = $params[ self::ASS_OPT ]['upload_file_size_limit'] ?? $this->allowed_options['upload_file_size_limit'];

				update_post_meta( $post_id, 'assignment_option', $this->allowed_options );

				update_post_meta( $post_id, '_tutor_assignment_total_mark', $this->allowed_options['total_mark'] );

				update_post_meta( $post_id, '_tutor_assignment_pass_mark', $this->allowed_options['pass_mark'] );
			}
		}

		if ( isset( $params['attachments'] ) ) {
			if ( ! empty( $params['attachments'] ) ) {
				update_post_meta( $post_id, '_tutor_assignment_attachments', $params['attachments'] );
			} else {
				delete_post_meta( $post_id, '_tutor_assignment_attachments' );
			}
		}

		// Get parent of parent.
		$course_id = get_post_parent( get_post_parent( $post_id ) );
		update_post_meta( $post_id, '_tutor_course_id_for_assignments', $course_id );
	}

	/**
	 * Delete assignment
	 *
	 * @since 2.6.0
	 *
	 * @param WP_REST_Request $request params.
	 *
	 * @return WP_REST_Response|WP_Error
	 */
	public function delete( WP_REST_Request $request ) {
		$assignment_id = $request->get_param( 'id' );
		try {
			$delete = wp_delete_post( $assignment_id, false );
			if ( $delete ) {
				return $this->response(
					$this->code_delete,
					__( 'Assignment deleted successfully', 'tutor-pro' ),
					$assignment_id
				);
			} else {
				return $this->response(
					$this->code_delete,
					__( 'Assignment delete failed', 'tutor-pro' ),
					'',
					$this->client_error_code
				);
			}
		} catch ( \Throwable $th ) {
			return $this->response(
				$this->code_delete,
				__( 'Assignment delete failed', 'tutor-pro' ),
				$th->getMessage(),
				$this->server_error_code
			);
		}
	}

	/**
	 * Validate data
	 *
	 * @since 2.6.0
	 *
	 * @param array $data form data.
	 *
	 * @return object
	 */
	protected function validate( array $data ): object {
		$topic_type = tutor()->topics_post_type;

		$validation_rules = array(
			'ID'                 => 'required|numeric',
			'topic_id'           => "required|numeric|post_type:{$topic_type}",
			'assignment_title'   => 'required',
			'assignment_author'  => 'required|user_exists',
			'assignment_options' => 'required|is_array',
			'attachments'        => 'is_array',
		);

		// Skip validation rules for not available fields in data.
		foreach ( $validation_rules as $key => $value ) {
			if ( ! array_key_exists( $key, $data ) ) {
				unset( $validation_rules[ $key ] );
			}
		}

		return ValidationHelper::validate( $validation_rules, $data );
	}

}

