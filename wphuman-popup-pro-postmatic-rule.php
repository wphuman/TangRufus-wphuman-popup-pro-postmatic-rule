<?php
/*
 * Plugin Name:         WP Human Popup Pro Postmatic Rule
 * Description:         Conditions based on the Postmatic subscrition.
 * Type:        		Rule
 * Rules:       		Visitor is not subscribed
 * Author:              Tang Rufus @ WP Human
 * Author URI:          https://www.wphuman.com
 * Author Twitter:      @tangrufus, @wphuman
 * Author Email:        rufus@wphuman.com
 * Version:             1.0.0
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * NOTE: DON'T RENAME THIS FILE!!
 * This filename is saved as metadata with each popup that uses these rules.
 * Renaming the file will DISABLE the rules, which is very bad!
 */

class IncPopupRule_Postmatic extends IncPopupRule {

	/**
	 * Initialize the rule object.
	 *
	 * @since  1.0.0
	 */
	protected function init() {
		$this->filename = basename( __FILE__ );

		// 'no_postmatic' rule.
		$this->add_rule(
			'no_postmatic',
			__( 'Visitor is not subscribed', 'popup-pro-postmatic' ),
			__( 'Shows the PopUp if the user is not subscribed to Postmatic.', 'popup-pro-postmatic' )
			);
	}

	/*==============================*\
	==================================
	==                              ==
	==         NO_postmatic         ==
	==                              ==
	==================================
	\*==============================*/


	/**
	 * Apply the rule-logic to the specified popup
	 *
	 * @since  1.0.0
	 * @param  mixed $data Rule-data which was saved via the save_() handler.
	 * @return bool Decission to display popup or not.
	 */
	protected function apply_no_postmatic( $data ) {
		$commenter = wp_get_current_commenter();
		$defaults = array(
			'subscribe_name' => $commenter['comment_author'] ? $commenter['comment_author'] : '',
			'subscribe_email' => $commenter['comment_author_email'] ? $commenter['comment_author_email'] : '',
			);
		$site = new Prompt_Site();
		$user = wp_get_current_user();

		if ( ! $user->exists() ) {
			$user = get_user_by( 'email', $defaults['subscribe_email'] );
		}

		return ! ( $user and $site->is_subscribed( $user->ID ) );
	}
}

IncPopupRules::register( 'IncPopupRule_Postmatic' );
