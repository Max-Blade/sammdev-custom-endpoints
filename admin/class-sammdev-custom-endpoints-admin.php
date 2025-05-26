<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SammDev_Custom_Endpoints
 * @subpackage SammDev_Custom_Endpoints/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SammDev_Custom_Endpoints
 * @subpackage SammDev_Custom_Endpoints/admin
 * @author     Your Name <email@example.com>
 */
class SammDev_Custom_Endpoints_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sd_ce    The ID of this plugin.
	 */
	private $sd_ce;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sd_ce       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sd_ce, $version ) {

		$this->sd_ce = $sd_ce;
		$this->version = $version;

	}

	public function validate_number($param) {
		return ctype_digit($param) && $param > 0;
	}

	public function register_custom_endpoints() {
		
		/*Test route
			register_rest_route(
				'sammdev-custom-endpoints/v1',
				'/testroute',
				array(
					'methods' => 'GET',
					'callback' => array( $this, 'sd_ce_test_endpoint' ),
					'args' => array(
						'id' => array(
							'required' => false,
							'validate_callback' => function ($param) {
								return is_int($param) && $param > 0;
							}
						)
					)
				)
			); 
		*/

		//LastPosts
		register_rest_route(
			'sammdev-custom-endpoints/v1',
			'/last_posts',
			array(
				'methods' => 'GET',
				'callback' => array( $this, 'sd_ce_get_last_posts' ),
				'permission_callback' => '__return_true',
				'args' => array(
					'per_page' => array(
						'required' => false,
						'validate_callback' => array( $this, 'validate_number' )
					),
					'page' => array(
						'required' => false,
						'validate_callback' => array( $this, 'validate_number' )
					)
				)
			)
		);
	}

	public function sd_ce_test_endpoint($request) {
		$response = array(
			'message' => 'Hello, this is a test endpoint!',
			'request_data' => $request->get_params(),
		);

		return new WP_REST_Response( $response, 200 );

	}

	public function sd_ce_get_last_posts($request) {
		$args = array(
			'post_type'      	=> 'post',     // Tipo de contenido: publicaciones
			'posts_per_page' 	=> $request->get_param('per_page'),  // Número de posts a obtener
			'orderby'        	=> 'date',     // Ordenar por fecha
			'order'         	=> 'DESC',     // De más reciente a más antiguo
			'post_status'		=> 'publish',   // Solo las posts publicadas.
			'paged'				=> $request->get_param('page') //numero de la pagina
    	);
		
		$query = new WP_Query($args);

		$posts = array();

		foreach ($query->posts as $post) {
			$excerpt = empty($post->post_excerpt) ? "<p>" . get_the_excerpt($post->ID) . "</p>\n": $post->post_excerpt;

			$posts[] = array(
				'id' => $post->ID,
				'title' => $post->post_title,
				'excerpt' => $excerpt,
				'content' => $post->post_content,
				'date' => $post->post_modified,
				'featured_image' => get_the_post_thumbnail_url($post->ID)
			);
		}

		$response = array(
			'last_posts' => $posts
		);

		return new WP_REST_Response( $response, 200 );
	}
}
