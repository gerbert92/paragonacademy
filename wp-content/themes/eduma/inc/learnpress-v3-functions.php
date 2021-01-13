<?php
/**
 * Custom functions for LearnPress 3.x
 *
 * @package thim
 */


if ( ! function_exists( 'thim_remove_learnpress_hooks' ) ) {
	function thim_remove_learnpress_hooks() {
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_begin_meta', 10 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_price', 20 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_instructor', 25 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_courses_loop_item_end_meta', 30 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_buttons', 35 );
		remove_action( 'learn-press/after-courses-loop-item', 'learn_press_course_loop_item_user_progress', 40 );
		remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb', 10 );
		remove_action( 'learn-press/before-main-content', 'learn_press_search_form', 15 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_start_wrapper', 5 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_students', 10 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_meta_end_wrapper', 15 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_price', 25 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_buttons', 30 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_instructor', 35 );
		remove_action( 'learn-press/course-section-item/before-lp_lesson-meta', 'learn_press_item_meta_duration', 5 );
		remove_action( 'learn-press/course-section-item/before-lp_quiz-meta', 'learn_press_item_meta_duration', 10 );
		remove_action( 'learn-press/course-section-item/before-lp_quiz-meta', 'learn_press_quiz_meta_questions', 5 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_meta_start_wrapper', 10 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_remaining_time', 30 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_students', 15 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_meta_end_wrapper', 20 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_progress', 25 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_buttons', 40 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_instructor', 45 );
		//		remove_action( 'learn-press/course-buttons', 'learn_press_course_continue_button', 25 );
		remove_action( 'learn-press/parse-course-item', 'learn_press_control_displaying_course_item' );
		remove_action( 'learn-press/before-profile-nav', 'learn_press_profile_mobile_menu', 5 );
		//		remove_action( 'learn-press/quiz-buttons', 'learn_press_course_finish_button', 50 );

		remove_action( 'learn-press/section-summary', 'learn_press_curriculum_section_content', 10 );

		add_action(
			'learn-press/parse-course-item', function () {
			remove_action( 'wp_print_scripts', 'learn_press_content_item_script' );
		}, 10
		);
		add_action(
			'wp_enqueue_scripts', function () {
			wp_dequeue_style( 'learn-press' );
		}, 10000
		);

		add_action(
			'init', function () {
			if ( thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) && class_exists( 'LP_Addon_Wishlist' ) && is_user_logged_in() && thim_is_version_addons_wishlist( '3' ) ) {
				$instance_addon = LP_Addon_Wishlist::instance();
				remove_action( 'learn-press/after-course-buttons', array( $instance_addon, 'wishlist_button' ), 100 );
				add_action( 'thim_after_course_info', array( $instance_addon, 'wishlist_button' ), 10 );
				add_action( 'thim_inner_thumbnail_course', array( $instance_addon, 'wishlist_button' ), 10 );
			}
			if ( thim_plugin_active( 'learnpress-bbpress/learnpress-bbpress.php' ) && class_exists( 'LP_Addon_bbPress' ) && thim_is_version_addons_bbpress( '3' ) ) {
				$instance_addon = LP_Addon_bbPress::instance();
				remove_action( 'learn-press/single-course-summary', array( $instance_addon, 'forum_link' ), 0 );
			}
			if ( thim_plugin_active( 'learnpress-woo-payment/learnpress-woo-payment.php' ) && class_exists( 'LP_Addon_Woo_Payment' ) && thim_is_version_addons_woo( 3 ) ) {
				$instance_addon = LP_Addon_Woo_Payment::instance();
				remove_action(
					'learn-press/before-course-buttons', array(
					$instance_addon,
					'purchase_course_notice'
				)
				);
				remove_action( 'learn-press/after-course-buttons', array( $instance_addon, 'after_course_buttons' ) );
				//add_action( 'learn-press/before-single-course', array( $instance_addon, 'purchase_course_notice' ) );
				//add_action( 'learn-press/before-single-course', array( $instance_addon, 'after_course_buttons' ) );
			}
			if ( thim_plugin_active( 'learnpress-paid-membership-pro/learnpress-paid-memberships-pro.php' ) && thim_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) && class_exists( 'LP_Addon_Paid_Memberships_Pro' ) ) {
				$instance_addon = LP_Addon_Paid_Memberships_Pro::instance();
				remove_action(
					'learn-press/before-course-buttons', array(
					$instance_addon,
					'add_buy_membership_button'
				), 10
				);
				add_action(
					'thim_single_course_payment', array(
					$instance_addon,
					'learn_press_before_course_buttons'
				), 8
				);
			}
			if ( thim_plugin_active( 'learnpress-assignments/learnpress-assignments.php' ) && class_exists( 'LP_Addon_Assignment' ) ) {
				$instance_addon = LP_Addon_Assignment::instance();
				remove_action(
					'learn-press/course-section-item/before-lp_assignment-meta', array(
					$instance_addon,
					'learnpress_assignment_show_duration'
				), 10
				);
				add_action( 'learn-press/course-section-item/before-lp_assignment-meta', 'thim_assignment_show_duration', 10 );
				if ( ! function_exists( 'thimthim_assignment_show_duration_assignment_show_duration' ) ) {
					function thim_assignment_show_duration( $item ) {
						$duration = get_post_meta( $item->get_id(), '_lp_duration', true );
						if ( absint( $duration ) > 1 ) {
							$duration .= 's';
						}
						$duration_number = absint( $duration );
						$time = trim( str_replace( $duration_number,'',$duration ) );
						switch($time){
							case 'minutes' :
								$time = _x("minutes",'duration','eduma');
								break;
							case 'hours' :
								$time = _x("hours",'duration','eduma');
								break;
							case 'days' :
								$time = _x("days",'duration','eduma');
								break;
							case 'weeks':
								$time = _x("weeks",'duration','eduma');
								break;
							case 'minute' :
								$time = _x("minute",'duration','eduma');
								break;
							default:
								$time = _x("week",'duration','eduma');
						}
						echo '<span class="meta duration">' . $duration_number.' '.$time  . '</span>';
 					}
				}
			}

		}, 99
		);

		//remove_action( 'learn-press/course-section-item/before-lp_lesson-meta', 'learn_press_item_meta_duration', 5 );
		//add_action( 'learn-press/course-section-item/after-lp_lesson-meta', 'learn_press_item_meta_duration', 5 );

		add_action( 'thim_single_course_payment', 'learn_press_course_price', 5 );
		add_action( 'thim_single_course_payment', 'learn_press_course_external_button', 10 );
		add_action( 'thim_single_course_payment', 'learn_press_course_purchase_button', 15 );
		add_action( 'thim_single_course_payment', 'learn_press_course_enroll_button', 20 );
		add_action( 'thim_single_course_payment', 'learn_press_course_continue_button', 25 );
		add_action( 'thim_single_course_meta', 'learn_press_course_instructor', 5 );
		add_action( 'thim_single_course_meta', 'learn_press_course_categories', 15 );
		add_action( 'thim_single_course_meta', 'thim_course_forum_link', 20 );
		add_action( 'thim_single_course_meta', 'thim_course_ratings', 25 );
		add_action( 'thim_single_course_meta', 'learn_press_course_progress', 30 );
		add_action( 'thim_begin_curriculum_button', 'learn_press_course_remaining_time', 1 );
		add_action( 'thim_begin_curriculum_button', 'learn_press_course_buttons', 10 );
		remove_action( 'learn-press/course-buttons', 'learn_press_course_external_button', 5 );
		remove_action( 'learn-press/course-buttons', 'learn_press_course_purchase_button', 10 );
		remove_action( 'learn-press/course-buttons', 'learn_press_course_enroll_button', 15 );
		remove_action( 'learn-press/course-buttons', 'learn_press_course_continue_button', 25 );
		remove_action( 'learn-press/after-checkout-order-review', 'learn_press_order_comment', 5 );
		remove_action( 'learn-press/after-checkout-order-review', 'learn_press_order_payment', 10 );
		add_action( 'learn-press/checkout-order-review', 'learn_press_order_comment', 10 );
		add_action( 'learn-press/checkout-order-review', 'learn_press_order_payment', 15 );
		remove_action( 'learn-press/before-checkout-form', 'learn_press_checkout_form_login', 5 );
		remove_action( 'learn-press/before-checkout-form', 'learn_press_checkout_form_register', 10 );

		//action for new demo
		if ( get_theme_mod( 'thim_layout_content_page', 'normal' ) == 'new-1' ) {
			remove_action( 'learn_press_before_main_content', '_learn_press_print_messages', 50 );
			add_action( 'thim_before_sidebar_course', '_learn_press_print_messages', 5 );
			remove_action( 'thim_begin_curriculum_button', 'learn_press_course_remaining_time', 1 );
			add_action( 'thim_before_sidebar_course', 'learn_press_course_remaining_time', 10 );

		}
	}
}

add_action( 'after_setup_theme', 'thim_remove_learnpress_hooks', 15 );

/**
 * Display price html
 */

if ( ! function_exists( 'thim_course_loop_price_html' ) ) {
	function thim_course_loop_price_html( $course ) {
		$class = ( $course->has_sale_price() ) ? ' has-origin' : '';
		if ( $course->is_free() ) {
			$class .= ' free-course';
		}
		?>
		<div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
			<?php if ( $price_html = $course->get_price_html() ) { ?>
				<div class="value <?php echo $class; ?>" itemprop="price">
					<?php if ( $course->get_origin_price() != $course->get_price() ) { ?>
						<?php $origin_price_html = $course->get_origin_price_html(); ?>
						<span class="course-origin-price"><?php echo $origin_price_html; ?></span>
					<?php } ?>
					<?php echo $price_html; ?>
				</div>
				<meta itemprop="priceCurrency" content="<?php echo learn_press_get_currency(); ?>"/>
			<?php } ?>
		</div>
		<?php
	}
}

if ( get_theme_mod( 'thim_layout_content_page', 'normal' ) != 'new-1' ) {
	add_action( 'learn-press/single-course-summary', 'thim_course_thumbnail_item', 2 );
}

/**
 * Add some meta data for a course
 *
 * @param $meta_box
 */
if ( ! function_exists( 'thim_add_course_meta' ) ) {
	function thim_add_course_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Duration Info', 'eduma' ),
			'id'   => 'thim_course_duration',
			'type' => 'text',
			'desc' => esc_html__( 'Display duration info', 'eduma' ),
			'std'  => esc_html__( '50 hours', 'eduma' )
		);
		$fields[]           = array(
			'name' => esc_html__( 'Skill Levels', 'eduma' ),
			'id'   => 'thim_course_skill_level',
			'type' => 'text',
			'desc' => esc_html__( 'A possible level with this course', 'eduma' ),
			'std'  => esc_html__( 'All levels', 'eduma' )
		);
		$fields[]           = array(
			'name' => esc_html__( 'Languages', 'eduma' ),
			'id'   => 'thim_course_language',
			'type' => 'text',
			'desc' => esc_html__( 'Language\'s used for studying', 'eduma' ),
			'std'  => esc_html__( 'English', 'eduma' )
		);
		$fields[]           = array(
			'name' => esc_html__( 'Media Intro', 'eduma' ),
			'id'   => 'thim_course_media_intro',
			'type' => 'textarea',
			'desc' => esc_html__( 'Enter media intro', 'eduma' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}

}

add_filter( 'learn_press_course_settings_meta_box_args', 'thim_add_course_meta' );


if ( ! function_exists( 'thim_add_lesson_meta' ) ) {
	function thim_add_lesson_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Media', 'eduma' ),
			'id'   => '_lp_lesson_video_intro',
			'type' => 'textarea',
			'desc' => esc_html__( 'Add an embed link like video, PDF, slider...', 'eduma' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}
}
add_filter( 'learn_press_lesson_meta_box_args', 'thim_add_lesson_meta' );

/**
 * Display feature certificate
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_course_certificate' ) ) {
	function thim_course_certificate( $course_id ) {

		if ( thim_plugin_active( 'learnpress-certificates/learnpress-certificates.php' ) && thim_is_version_addons_certificates( '3' ) ) {
			?>
			<li class="cert-feature">
				<i class="fa fa-rebel"></i>
				<span class="label"><?php esc_html_e( 'Certificate', 'eduma' ); ?></span>
				<span
					class="value"><?php echo ( get_post_meta( $course_id, '_lp_cert', true ) ) ? esc_html__( 'Yes', 'eduma' ) : esc_html__( 'No', 'eduma' ); ?></span>
			</li>
			<?php
		}
	}
}

/**
 * Display course review
 */
if ( ! function_exists( 'thim_course_review' ) ) {
	function thim_course_review() {
		if ( ! thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) || ! thim_is_version_addons_review( '3' ) ) {
			return;
		}

		$course_id     = get_the_ID();
		$course_review = learn_press_get_course_review( $course_id, isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 1, 5, true );
		$course_rate   = learn_press_get_course_rate( $course_id );
		$total         = learn_press_get_course_rate_total( $course_id );
		$reviews       = $course_review['reviews'];

		?>
		<div class="course-rating">
			<h3><?php esc_html_e( 'Reviews', 'eduma' ); ?></h3>

			<div class="average-rating" itemprop="aggregateRating" itemscope=""
				 itemtype="http://schema.org/AggregateRating">
				<p class="rating-title"><?php esc_html_e( 'Average Rating', 'eduma' ); ?></p>

				<div class="rating-box">
					<div class="average-value"
						 itemprop="ratingValue"><?php echo ( $course_rate ) ? esc_html( round( $course_rate, 1 ) ) : 0; ?></div>
					<div class="review-star">
						<?php thim_print_rating( $course_rate ); ?>
					</div>
					<div class="review-amount" itemprop="ratingCount">
						<?php $total ? printf( _n( '%1$s rating', '%1$s ratings', $total, 'eduma' ), number_format_i18n( $total ) ) : esc_html_e( '0 rating', 'eduma' ); ?>
					</div>
				</div>
			</div>
			<div class="detailed-rating">
				<p class="rating-title"><?php esc_html_e( 'Detailed Rating', 'eduma' ); ?></p>

				<div class="rating-box">
					<?php thim_detailed_rating( $course_id, $total ); ?>
				</div>
			</div>
		</div>

		<div class="course-review">
			<div id="course-reviews" class="content-review">
				<ul class="course-reviews-list">
					<?php foreach ( $reviews as $review ) : ?>
						<li>
							<div class="review-container" itemprop="review" itemscope
								 itemtype="http://schema.org/Review">
								<div class="review-author">
									<?php echo get_avatar( $review->ID, 70 ); ?>
								</div>
								<div class="review-text">
									<h4 class="author-name"
										itemprop="author"><?php echo esc_html( $review->display_name ); ?></h4>

									<div class="review-star">
										<?php thim_print_rating( $review->rate ); ?>
									</div>
									<p class="review-title"><?php echo esc_html( $review->title ); ?></p>

									<div class="description" itemprop="reviewBody">
										<p><?php echo esc_html( $review->content ); ?></p>
									</div>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php if ( empty( $course_review['finish'] ) && $total ) : ?>
			<div class="review-load-more">
                <span id="course-review-load-more" data-paged="<?php echo esc_attr( $course_review['paged'] ); ?>"><i
						class="fa fa-angle-double-down"></i></span>
			</div>
		<?php endif; ?>
		<?php thim_review_button( $course_id ); ?>
		<?php
	}
}

/**
 * Display review button
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_review_button' ) ) {
	function thim_review_button( $course_id ) {
		if ( ! thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) || ! thim_is_version_addons_review( '3' ) ) {
			return;
		}

		if ( ! get_current_user_id() ) {
			return;
		}
		$user = learn_press_get_current_user();
		if ( $user->has_course_status( $course_id, array( 'enrolled', 'completed', 'finished' ) ) ) {
			if ( ! learn_press_get_user_rate( $course_id ) ) {
				?>
				<div class="add-review">
					<h3 class="title"><?php esc_html_e( 'Leave A Review', 'eduma' ); ?></h3>

					<p class="description"><?php esc_html_e( 'Please provide as much detail as you can to justify your rating and to help others.', 'eduma' ); ?></p>
					<?php do_action( 'learn_press_before_review_fields' ); ?>
					<form method="post">
						<div>
							<label for="review-title"><?php esc_html_e( 'Title', 'eduma' ); ?>
								<span class="required">*</span></label>
							<input required type="text" id="review-title" name="review-course-title"/>
						</div>
						<div>

							<label><?php esc_html_e( 'Rating', 'eduma' ); ?>
								<span class="required">*</span></label>

							<div class="review-stars-rated">
								<ul class="review-stars">
									<li><span class="fa fa-star-o"></span></li>
									<li><span class="fa fa-star-o"></span></li>
									<li><span class="fa fa-star-o"></span></li>
									<li><span class="fa fa-star-o"></span></li>
									<li><span class="fa fa-star-o"></span></li>
								</ul>
								<ul class="review-stars filled" style="width: 100%">
									<li><span class="fa fa-star"></span></li>
									<li><span class="fa fa-star"></span></li>
									<li><span class="fa fa-star"></span></li>
									<li><span class="fa fa-star"></span></li>
									<li><span class="fa fa-star"></span></li>
								</ul>
							</div>
						</div>
						<div>
							<label for="review-content"><?php esc_html_e( 'Comment', 'eduma' ); ?>
								<span class="required">*</span></label>
							<textarea required id="review-content" name="review-course-content"></textarea>
						</div>
						<input type="hidden" id="review-course-value" name="review-course-value" value="5"/>
						<input type="hidden" id="comment_course_ID" name="comment_course_ID"
							   value="<?php echo get_the_ID(); ?>"/>
						<button type="submit"><?php esc_html_e( 'Submit Review', 'eduma' ); ?></button>
					</form>
					<?php do_action( 'learn_press_after_review_fields' ); ?>
				</div>
				<?php
			}
		}

	}
}

/**
 * Process review
 */
if ( ! function_exists( 'thim_process_review' ) ) {
	function thim_process_review() {

		if ( ! thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) || ! thim_is_version_addons_review( '3' ) ) {
			return;
		}

		$user_id     = get_current_user_id();
		$course_id   = isset ( $_POST['comment_course_ID'] ) ? $_POST['comment_course_ID'] : 0;
		$user_review = learn_press_get_user_rate( $course_id, $user_id );
		if ( ! $user_review && $course_id ) {
			$review_title   = isset ( $_POST['review-course-title'] ) ? $_POST['review-course-title'] : 0;
			$review_content = isset ( $_POST['review-course-content'] ) ? $_POST['review-course-content'] : 0;
			$review_rate    = isset ( $_POST['review-course-value'] ) ? $_POST['review-course-value'] : 0;
			learn_press_add_course_review(
				array(
					'title'     => $review_title,
					'content'   => $review_content,
					'rate'      => $review_rate,
					'user_id'   => $user_id,
					'course_id' => $course_id
				)
			);
		}
	}
}
add_action( 'init', 'thim_process_review' );


/**
 * Display table detailed rating
 *
 * @param $course_id
 * @param $total
 */
if ( ! function_exists( 'thim_detailed_rating' ) ) {
	function thim_detailed_rating( $course_id, $total ) {
		global $wpdb;
		$query = $wpdb->get_results(
			$wpdb->prepare(
				"
		SELECT cm2.meta_value AS rating, COUNT(*) AS quantity FROM $wpdb->posts AS p
		INNER JOIN $wpdb->comments AS c ON p.ID = c.comment_post_ID
		INNER JOIN $wpdb->users AS u ON u.ID = c.user_id
		INNER JOIN $wpdb->commentmeta AS cm1 ON cm1.comment_id = c.comment_ID AND cm1.meta_key=%s
		INNER JOIN $wpdb->commentmeta AS cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key=%s
		WHERE p.ID=%d AND c.comment_type=%s AND c.comment_approved=%s
		GROUP BY cm2.meta_value",
				'_lpr_review_title',
				'_lpr_rating',
				$course_id,
				'review',
				'1'
			), OBJECT_K
		);
		?>
		<div class="detailed-rating">
			<?php for ( $i = 5; $i >= 1; $i -- ) : ?>
				<div class="stars">
					<div
						class="key"><?php ( $i === 1 ) ? printf( esc_html__( '%s star', 'eduma' ), $i ) : printf( esc_html__( '%s stars', 'eduma' ), $i ); ?></div>
					<div class="bar">
						<div class="full_bar">
							<div
								style="<?php echo ( $total && ! empty( $query[$i]->quantity ) ) ? esc_attr( 'width: ' . ( $query[$i]->quantity / $total * 100 ) . '%' ) : 'width: 0%'; ?>"></div>
						</div>
					</div>
					<div
						class="value"><?php echo empty( $query[$i]->quantity ) ? '0' : esc_html( $query[$i]->quantity ); ?></div>
				</div>
			<?php endfor; ?>
		</div>
		<?php
	}
}

/**
 * @param LP_Quiz|LP_Lesson $item
 */
function thim_item_quiz_meta_duration( $item ) {
	$duration = $item->get_duration();

	if ( is_a( $duration, 'LP_Duration' ) && $duration->get() ) {
		$format = array(
			'day'    => _x( '%s day', 'duration', 'eduma' ),
			'hour'   => _x( '%s hour', 'duration', 'eduma' ),
			'minute' => _x( '%s min', 'duration', 'eduma' ),
			'second' => _x( '%s sec', 'duration', 'eduma' ),
		);
		echo '<span class="meta duration">' . $duration->to_timer( $format, true ) . '</span>';
	} elseif ( is_string( $duration ) && strlen( $duration ) ) {
		echo '<span class="meta duration">' . $duration . '</span>';
	}
}

//add_action( 'learn-press/course-section-item/before-lp_quiz-meta', 'thim_item_quiz_meta_duration', 10 );

/**
 * Add class course item
 */
if ( ! function_exists( 'thim_add_class_course_item' ) ) {
	function thim_add_class_course_item( $defaults, $item_type, $item_id, $course_id ) {
		$item_type  = str_replace( 'lp_', '', $item_type );
		$defaults[] = 'course-' . $item_type;

		return $defaults;
	}
}
add_filter( 'learn-press/course-item-class', 'thim_add_class_course_item', 1000, 4 );


/**
 * Filter profile title
 *
 * @param $tab_title
 * @param $key
 *
 * @return string
 */
function thim_tab_profile_filter_title( $tab_title, $key ) {
	switch ( $key ) {
		case 'courses':
			$tab_title = '<i class="fa fa-book"></i><span class="text">' . esc_html__( 'Courses', 'eduma' ) . '</span>';
			break;
		case 'quizzes':
			$tab_title = '<i class="fa fa-check-square-o"></i><span class="text">' . esc_html__( 'Quiz Results', 'eduma' ) . '</span>';
			break;
		case 'orders':
			$tab_title = '<i class="fa fa-shopping-cart"></i><span class="text">' . esc_html__( 'Orders', 'eduma' ) . '</span>';
			break;
		case 'wishlist':
			$tab_title = '<i class="fa fa-heart-o"></i><span class="text">' . esc_html__( 'Wishlist', 'eduma' ) . '</span>';
			break;
		case 'gradebook':
			$tab_title = '<i class="fa fa-book"></i><span class="text">' . esc_html__( 'Gradebook', 'eduma' ) . '</span>';
			break;
		case 'assignment':
			$tab_title = '<i class="fa fa-book"></i><span class="text">' . esc_html__( 'Assignments', 'eduma' ) . '</span>';
			break;
		case 'settings':
			$tab_title = '<i class="fa fa-cog"></i><span class="text">' . esc_html__( 'Settings', 'eduma' ) . '</span>';
			break;
		case 'certificates':
			$tab_title = '<i class="fa fa-bookmark-o"></i><span class="text">' . esc_html__( 'Certificates', 'eduma' ) . '</span>';
			break;
		case 'instructor':
			$tab_title = '<i class="fa fa-user-tie"></i><span class="text">' . $tab_title . '</span>';
			break;
		case 'withdrawals':
			$tab_title = '<i class="fa fa-money-bill-alt"></i><span class="text">' . $tab_title . '</span>';
			break;
		case 'edit':
			$tab_title = '<i class="fa fa-user"></i><span class="text">' . esc_html__( 'Account', 'eduma' ) . '</span>';
			break;
	}

	return $tab_title;
}

add_filter( 'learn_press_profile_edit_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_courses_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_quizzes_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_orders_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_wishlist_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_gradebook_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_settings_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_certificates_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_assignment_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_instructor_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_withdrawals_tab_title', 'thim_tab_profile_filter_title', 100, 2 );

/**
 * Change tabs profile
 */
if ( ! function_exists( 'thim_change_tabs_course_profile' ) ) {
	function thim_change_tabs_course_profile( $defaults ) {
		unset( $defaults['dashboard'] );
		$defaults['settings']['priority']      = 15;
		$defaults['courses']['priority']       = 3;
		$defaults['orders']['priority']        = 13;
		$defaults['order-details']['priority'] = 14;
		$defaults['order-details']['priority'] = 14;

		return $defaults;
	}
}
add_filter( 'learn-press/profile-tabs', 'thim_change_tabs_course_profile', 1000 );


if ( ! function_exists( 'show_pass_text' ) ) {
	function show_pass_text() {
		$user   = learn_press_get_current_user();
		$course = LP()->global['course'];
		$grade  = $user->get_course_grade( $course->get_id() );
		if ( $grade == 'passed' ) {
			echo '<div class="message message-success learn-press-success">' . ( __( 'You have finished this course.', 'eduma' ) ) . '</div>';
		}
	}
}
add_action( 'thim_begin_curriculum_button', 'show_pass_text', 5 );

if ( ! function_exists( 'thim_checkout_link_login_register' ) ) {
	function thim_checkout_link_login_register() {
		if ( is_user_logged_in() ) {
			return;
		}
		$redirect      = ( ! empty( $_SERVER['HTTPS'] ) ? "https" : "http" ) . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$link_login    = thim_get_login_page_url() . '?redirect_to=' . esc_attr( $redirect );
		$link_register = thim_get_register_url() . '&redirect_to=' . esc_attr( $redirect );
		if ( LP()->checkout()->is_enable_login() || LP()->checkout()->is_enable_register() ) {
			echo '<div class="message message-notice">';
			if ( LP()->checkout()->is_enable_login() ) {
				printf( __( 'You can <a href="%1$s">login</a> now. ', 'eduma' ), esc_url( $link_login ) );
			}
			if ( LP()->checkout()->is_enable_register() ) {
				printf( __( 'Don\'t have an account? Click <a href="%1$s">register now</a>', 'eduma' ), esc_url( $link_register ) );
			}
			echo '</div>';
		}
	}
}
add_action( 'learn-press/before-checkout-form', 'thim_checkout_link_login_register', 5 );

if ( ! function_exists( 'thim_get_all_courses_instructors' ) ) {
	function thim_get_all_courses_instructors( $limits = 4 ) {
		$teacher       = array();
		$args_users    = array(
			'role'   => 'lp_teacher',
			'number' => $limits
		);
		$my_user_query = new WP_User_Query( $args_users );
		$users_by_role = $my_user_query->get_results();

		//		$users_by_role = get_users( array( 'role' => 'lp_teacher' ) );
		if ( $users_by_role ) {
			foreach ( $users_by_role as $user ) {
				//				$teacher[] = $user->ID;
				$teacher[] = array(
					'user_id' => $user->ID,
					//					'students'   => $count_students,
					//					'count_rate' => $count_rate
				);
			}
		}
		//		$result = array();
		//		if ( $teacher ) {
		//			foreach ( $teacher as $id ) {
		//				$user_curd        = new LP_User_CURD();
		//				$query_list_table = $user_curd->query_own_courses( $id, array(
		//					'limit'  => 9999,
		//					'status' => 'publish'
		//				) );
		//				$own_courses      = $query_list_table->get_items();
		//				$count_students   = $count_rate = 0;
		//
		//				foreach ( $own_courses as $course_id ) {
		//					$course_curd     = new LP_Course_CURD();
		//					$number_students = $course_curd->get_user_enrolled( $course_id );
		//
		//					$count_students += count( $number_students );
		//					if ( function_exists( 'learn_press_get_course_rate_total' ) ) {
		//						$rate = learn_press_get_course_rate_total( $course_id );
		//					} else {
		//						$rate = 0;
		//					}
		//
		//					$count_rate = $rate ? $rate + $count_rate : $count_rate;
		//				}
		//				$result[] = array(
		//					'user_id'    => $id,
		//					'students'   => $count_students,
		//					'count_rate' => $count_rate
		//				);
		//			}
		//		}

		return $teacher;
	}
}

if ( ! function_exists( 'thim_hooks_for_lp3' ) ) {
	function thim_hooks_for_lp3() {
		add_action( 'thim_single_course_before_meta', 'thim_course_thumbnail_item', 5 );
		remove_action( 'learn-press/content-landing-summary', 'learn_press_course_tabs', 20 );
		remove_action( 'learn-press/content-learning-summary', 'learn_press_course_tabs', 35 );

		if ( ! function_exists( 'thim_course_landing_summary_start_wrapper' ) ) {
			function thim_course_landing_summary_start_wrapper() {
				echo '<div id="course-landing"><div class="menu_content_course">';
			}
		}
		add_action( 'learn-press/content-landing-summary', 'thim_course_landing_summary_start_wrapper', 5 );
		add_action( 'learn-press/content-learning-summary', 'thim_course_landing_summary_start_wrapper', 5 );

		if ( ! function_exists( 'thim_course_landing_summary_content' ) ) {
			function thim_course_landing_summary_content() {
				learn_press_get_template( 'single-course/tabs/tabs-2.php' );
			}
		}
		add_action( 'learn-press/content-landing-summary', 'thim_course_landing_summary_content', 15 );
		add_action( 'learn-press/content-learning-summary', 'thim_course_landing_summary_content', 15 );

		if ( ! function_exists( 'thim_course_landing_summary_end_wrapper' ) ) {
			function thim_course_landing_summary_end_wrapper() {
				echo '</div></div>';
			}
		}
		add_action( 'learn-press/content-landing-summary', 'thim_course_landing_summary_end_wrapper', 50 );
		add_action( 'learn-press/content-learning-summary', 'thim_course_landing_summary_end_wrapper', 50 );

		//		remove_action( 'thim_single_course_meta', 'thim_course_forum_link', 20 );
	}
}
if ( get_theme_mod( 'thim_layout_content_page', 'normal' ) == 'new-1' ) {
	add_action( 'after_setup_theme', 'thim_hooks_for_lp3', 99 );
}


if ( ! function_exists( 'thim_curriculum_section_content' ) ) {
	function thim_curriculum_section_content( $section ) {
		learn_press_get_template( 'single-course/section/content.php', array( 'section' => $section ) );
	}
}
add_action( 'learn-press/section-summary', 'thim_curriculum_section_content', 10 );

/**
 * @param $user
 */
if ( ! function_exists( 'thim_extra_user_profile_fields' ) ) {
	function thim_extra_user_profile_fields( $user ) {
		$user_info = get_the_author_meta( 'lp_info', $user->ID );
		?>
		<h3><?php esc_html_e( 'LearnPress Profile', 'eduma' ); ?></h3>

		<table class="form-table">
			<tbody>
			<tr>
				<th>
					<label for="lp_major"><?php esc_html_e( 'Major', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_major" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['major'] ) ? $user_info['major'] : ''; ?>"
						   name="lp_info[major]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_facebook"><?php esc_html_e( 'Facebook Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_facebook" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['facebook'] ) ? $user_info['facebook'] : ''; ?>"
						   name="lp_info[facebook]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_twitter"><?php esc_html_e( 'Twitter Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_twitter" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['twitter'] ) ? $user_info['twitter'] : ''; ?>"
						   name="lp_info[twitter]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_instagram"><?php esc_html_e( 'Instagram Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_instagram" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['instagram'] ) ? $user_info['instagram'] : ''; ?>"
						   name="lp_info[instagram]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_google"><?php esc_html_e( 'Google Plus Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_google" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['google'] ) ? $user_info['google'] : ''; ?>"
						   name="lp_info[google]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_linkedin"><?php esc_html_e( 'LinkedIn Plus Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_linkedin" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['linkedin'] ) ? $user_info['linkedin'] : ''; ?>"
						   name="lp_info[linkedin]">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lp_youtube"><?php esc_html_e( 'Youtube Account', 'eduma' ); ?></label>
				</th>
				<td>
					<input id="lp_youtube" class="regular-text" type="text"
						   value="<?php echo isset( $user_info['youtube'] ) ? $user_info['youtube'] : ''; ?>"
						   name="lp_info[youtube]">
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}
}

add_action( 'show_user_profile', 'thim_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'thim_extra_user_profile_fields' );

function thim_save_extra_user_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'lp_info', $_POST['lp_info'] );
}

add_action( 'personal_options_update', 'thim_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'thim_save_extra_user_profile_fields' );

function thim_update_user_profile_basic_information() {
	$user_id     = learn_press_get_current_user_id();
	$update_data = array(
		'ID'           => $user_id,
		'first_name'   => filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING ),
		'last_name'    => filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING ),
		'display_name' => filter_input( INPUT_POST, 'display_name', FILTER_SANITIZE_STRING ),
		'nickname'     => filter_input( INPUT_POST, 'nickname', FILTER_SANITIZE_STRING ),
		'description'  => filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING ),
	);
	update_user_meta( $user_id, 'lp_info', $_POST['lp_info'] );
	$res = wp_update_user( $update_data );
	if ( $res ) {
		$message = __( 'Your change is saved', 'eduma' );
	} else {
		$message = __( 'Error on update your profile info', 'eduma' );
	}
	$current_url = learn_press_get_current_url();
	learn_press_add_message( $message );
	wp_redirect( $current_url );
	exit();
}

remove_action( 'learn_press_update_user_profile_basic-information', 'learn_press_update_user_profile_basic_information' );
add_action( 'learn_press_update_user_profile_basic-information', 'thim_update_user_profile_basic_information' );

add_action( 'learn-press/content-landing-summary', 'thim_landing_tabs', 22 );


#
# set redirect url in section
#
add_action( 'init', 'eduma_before_mo_openid_login_validate', 9 );
if ( ! function_exists( 'eduma_before_mo_openid_login_validate' ) ) {
	function eduma_before_mo_openid_login_validate() {
		if ( isset( $_REQUEST['option'] ) && ( strpos( $_REQUEST['option'], 'oauthredirect' ) !== false || strpos( $_REQUEST['option'], 'getmosociallogin' ) !== false ) ) {
			$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
			if ( ! session_id() ) {
				session_start();
			}
			if ( $redirect_to ) {
				$_SESSION['eduma_redirect_to'] = $redirect_to;
			}
		}
	}
}

#
# Mark flag $_SESSION['eduma_do_redirect_to'] for redirect
#
add_action( 'miniorange_collect_attributes_for_authenticated_user', 'eduma_callback_action_miniorange_collect_attributes_for_authenticated_user', 10, 2 );
function eduma_callback_action_miniorange_collect_attributes_for_authenticated_user( $user, $mo_openid_redirect_url ) {
	$_SESSION['eduma_do_redirect_to'] = true;

	return $user;
}

#
# Do redirect if flag $_SESSION['eduma_do_redirect_to'] == true
#
add_filter( 'wp_redirect', 'eduma_redirect_after_mo_login', 10 );
function eduma_redirect_after_mo_login( $redirect_url ) {
	if ( isset( $_SESSION['mo_login'] ) && $_SESSION['mo_login'] == false
		&& isset( $_SESSION['eduma_do_redirect_to'] ) && $_SESSION['eduma_do_redirect_to'] == true
		&& isset( $_SESSION['eduma_redirect_to'] )
	) {
		$redirect_url = $_SESSION['eduma_redirect_to'];
		unset( $_SESSION['eduma_redirect_to'] );
		unset( $_SESSION['eduma_do_redirect_to'] );
	}
	if ( is_user_logged_in() ) {
		if ( ! session_id() ) {
			return $redirect_url;
		}
		if ( isset( $_SESSION['eduma_redirect_to'] ) ) {
			$redirect_url = $_SESSION['eduma_redirect_to'];
			unset( $_SESSION['eduma_redirect_to'] );
			if ( isset( $_SESSION['eduma_do_redirect_to'] ) ) {
				unset( $_SESSION['eduma_do_redirect_to'] );
			}
		}
	}

	return $redirect_url;
}


#
# Rewrite javascript function moOpenIdLogin to add redirect url after login
#
add_action( 'learn_press_after_single_course', 'thim_action_callback_learn_press_after_single_course', 100 ); // work for LearnPress 2
add_action( 'learn-press/after-single-course', 'thim_action_callback_learn_press_after_single_course', 100 ); // work for LearnPress 3
if ( ! function_exists( 'thim_action_callback_learn_press_after_single_course' ) ) {
	function thim_action_callback_learn_press_after_single_course() {
		if ( is_user_logged_in() || ! learn_press_is_course() ) {
			return;
		}
		$course = learn_press_get_course();
		if ( ! is_object( $course ) ) {
			return;
		}
		$is_free_course = $course->is_free();
		?>
		<script type="text/javascript">
			function moOpenIdLogin(app_name, is_custom_app) {
				<?php

				if ( isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
					$http = "https://";
				} else {
					$http = "http://";
				}
				?>
				var base_url = '<?php echo site_url();?>';
				var request_uri = '<?php echo $_SERVER['REQUEST_URI'];?>';
				var http = '<?php echo $http;?>';
				var http_host = '<?php echo $_SERVER['HTTP_HOST'];?>';
				if (is_custom_app == 'false') {
					if (request_uri.indexOf('wp-login.php') != -1) {
						var redirect_url = base_url + '/?option=getmosociallogin&app_name=';

					} else {
						var redirect_url = http + http_host + request_uri;
						if (redirect_url.indexOf('?') != -1) {
							redirect_url = redirect_url + '&option=getmosociallogin&app_name=';
						} else {
							redirect_url = redirect_url + '?option=getmosociallogin&app_name=';
						}
					}
				} else {
					var current_url = window.location.href;
					var cname = 'redirect_current_url';
					var d = new Date();
					d.setTime(d.getTime() + (2 * 24 * 60 * 60 * 1000));
					var expires = 'expires=' + d.toUTCString();
					document.cookie = cname + '=' + current_url + ';' + expires + ';path=/';   //path = root path(/)
					if (request_uri.indexOf('wp-login.php') != -1) {
						var redirect_url = base_url + '/?option=oauthredirect&app_name=';
					} else {
						var redirect_url = http + http_host + request_uri;
						if (redirect_url.indexOf('?') != -1)
							redirect_url = redirect_url + '&option=oauthredirect&app_name=';
						else
							redirect_url = redirect_url + '?option=oauthredirect&app_name=';
					}
				}
				var redirect_to = jQuery('#loginform input[name="redirect_to"]').val();
				redirect_url = redirect_url + app_name + '&redirect_to=' + encodeURIComponent(redirect_to);
				window.location.href = redirect_url;
			}
		</script>
		<?php
	}
}

/*
 * Hide ads Learnpress
 */
if ( get_theme_mod( 'thim_learnpress_hidden_ads', false ) ) {
	remove_action( 'admin_footer', 'learn_press_footer_advertisement', - 10 );
}


/*
 * Disable function feature login/register form in profile page
 */
remove_action( 'learn-press/user-profile', 'learn_press_profile_dashboard_not_logged_in', 5 );
remove_action( 'learn-press/user-profile', 'learn_press_profile_login_form', 10 );
remove_action( 'learn-press/user-profile', 'learn_press_profile_register_form', 15 );

add_action( 'learn-press/user-profile', 'thim_profile_dashboard_not_logged_in', 5 );
if ( ! function_exists( 'thim_profile_dashboard_not_logged_in' ) ) {
	function thim_profile_dashboard_not_logged_in() {
		$profile = LP_Global::profile();
		if ( ! $profile->get_user()->is_guest() ) {
			return;
		}
		learn_press_get_template( 'profile/not-logged-in.php' );
	}
}

remove_action( 'learn-press/before-become-teacher-form', 'learn_press_become_teacher_heading', 10 );
remove_action( 'learn-press/become-teacher-form', 'learn_press_become_teacher_form_fields', 5 );
add_action( 'learn-press/become-teacher-form', 'thim_become_teacher_form_fields', 5 );
if ( ! function_exists( 'thim_become_teacher_form_fields' ) ) {
	function thim_become_teacher_form_fields() {
		include_once LP_PLUGIN_PATH . 'inc/admin/meta-box/class-lp-meta-box-helper.php';
		learn_press_get_template( 'global/become-teacher-form/form-fields.php', array( 'fields' => learn_press_get_become_a_teacher_form_fields() ) );
	}
}
remove_action( 'learn-press/after-become-teacher-form', 'learn_press_become_teacher_button', 10 );
add_action( 'learn-press/after-become-teacher-form', 'thim_become_teacher_button', 10 );
if ( ! function_exists( 'thim_become_teacher_button' ) ) {
	function thim_become_teacher_button() {
		learn_press_get_template( 'global/become-teacher-form/button.php' );
	}
}

/**
 * Show popular Courses
 */
if ( ! function_exists( 'thim_show_popular_courses' ) ) {
	function thim_show_popular_courses() {
		$show_popular = get_theme_mod( 'thim_learnpress_cate_show_popular' );
		if ( $show_popular && is_post_type_archive( 'lp_course' ) ) {
			//Get layout Grid/List Courses
			$layout_grid = get_theme_mod( 'thim_learnpress_cate_layout_grid', '' );
			$cls_layout  = ( $layout_grid != '' && $layout_grid != 'layout_courses_1' ) ? ' cls_courses_2' : '';

			$condition = array(
				'post_type'           => 'lp_course',
				'posts_per_page'      => 6,
				'ignore_sticky_posts' => true,
				'meta_query'          => array(
					array(
						'key'   => '_lp_featured',
						'value' => 'yes',
					)
				)
			);
			$the_query = new WP_Query( $condition );
			if ( $the_query->have_posts() ) :
				?>
				<div class="feature_box_before_archive<?php echo $cls_layout; ?>">
					<div class="container">
						<div class="thim-widget-heading thim-widget-heading-base">
							<div class="sc_heading clone_title  text-center">
								<h2 class="title"><?php esc_html_e( 'Popular Courses', 'eduma' ); ?></h2>
								<div class="clone"><?php esc_html_e( 'Popular Courses', 'eduma' ); ?></div>
							</div>
						</div>
						<div class="thim-carousel-wrapper thim-course-carousel thim-course-grid" data-visible="4"
							 data-pagination="true" data-navigation="false" data-autoplay="false">
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="course-item">
									<?php
									// @since 3.0.0
									do_action( 'learn-press/before-courses-loop-item' );
									?>

									<?php
									// @thim
									do_action( 'thim_courses_loop_item_thumb' );
									?>
									<div class="thim-course-content">
										<?php learn_press_courses_loop_item_instructor(); ?>
										<?php
										//thim_courses_loop_item_author();
										//do_action( 'learn_press_before_the_title' );
										the_title( sprintf( '<h2 class="course-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
										do_action( 'learn_press_after_the_title' );
										?>
										<div class="course-meta">
											<?php learn_press_courses_loop_item_instructor(); ?>
											<?php thim_course_ratings(); ?>
											<?php learn_press_courses_loop_item_students(); ?>
											<?php thim_course_ratings_count(); ?>
											<?php learn_press_courses_loop_item_price(); ?>
										</div>

										<div class="course-description">
											<?php
											do_action( 'learn_press_before_course_content' );
											echo thim_excerpt( 25 );
											do_action( 'learn_press_after_course_content' );
											?>
										</div>
										<?php learn_press_courses_loop_item_price(); ?>
										<div class="course-readmore">
											<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read More', 'eduma' ); ?></a>
										</div>
									</div>
								</div>
							<?php
							endwhile;
							?>
						</div>
					</div>
				</div>
			<?php
			endif;
		}
	}
}
add_action( 'thim_before_site_content', 'thim_show_popular_courses' );

if ( ! function_exists( 'thim_course_wishlist_button' ) ) {
	function thim_course_wishlist_button( $course_id = null ) {
		if ( ! class_exists( 'LP_Addon_Wishlist' ) ) {
			return;
		}

		LP_Addon_Wishlist::instance()->wishlist_button( $course_id );
	}
}


/*
 * Add real students enrolled meta for orderby attribute in the query
 * */
add_action( 'init', 'thim_add_real_student_enrolled_meta' );

if ( ! function_exists( 'thim_add_real_student_enrolled_meta' ) ) {
	function thim_add_real_student_enrolled_meta( $lp ) {
		if ( isset( $_POST['course_orderby'] ) && 'most-members' == $_POST['course_orderby'] ) {
			$arg = array(
				'post_type'           => 'lp_course',
				'post_status'         => 'publish',
				'posts_per_page'      => - 1,
				'ignore_sticky_posts' => true
			);

			$course_query = new WP_Query( $arg );

			if ( $course_query->have_posts() ) {
				while ( $course_query->have_posts() ) {
					$course_query->the_post();

					$course = learn_press_get_course( get_the_ID() );

					update_post_meta( get_the_ID(), 'thim_real_student_enrolled', $course->get_users_enrolled() );
				}

				wp_reset_postdata();
			}
		}
	}
}

/**
 * Add filter link login redirecti frontend editor
 */
add_filter( 'learn-press/frontend-editor/login-redirect', 'thim_custom_link_login_frontend_editor', 10, 1 );
if ( ! function_exists( 'thim_custom_link_login_frontend_editor' ) ) {
	function thim_custom_link_login_frontend_editor() {
		$url = add_query_arg( 'redirect_to', get_permalink( get_the_ID() ), thim_get_login_page_url() );

		return $url;
	}
}
