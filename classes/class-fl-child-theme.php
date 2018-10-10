<?php

/**
 * Helper class for theme functions.
 *
 * @class FLChildTheme
 */

add_action( 'after_setup_theme', 'FLChildTheme::setup', 10 );

final class FLChildTheme {
	
	static public $random_inductee = array();
	
	/**
     * @method setup
     */
    static public function setup() {
		
		// Actions
		add_action( 'after_setup_theme', 			__CLASS__ . '::add_fonts', 11 );
		add_action( 'fl_head', 						__CLASS__ . '::add_typekit' );
		add_action( 'wp_enqueue_scripts', 			__CLASS__ . '::enqueue_scripts', 1000 );
		add_action( 'after_setup_theme',			__CLASS__ . '::add_image_sizes', 11 );
		add_action( 'fl_page_data_add_properties', 	__CLASS__ . '::add_post_properties' );
		add_action( 'fl_page_open', 				__CLASS__ . '::sticky_links' );
		add_action( 'pre_get_posts', 				__CLASS__ . '::filter_inductees', 10, 1 );

		// Filters
		add_filter( 'style_loader_src', 			__CLASS__ . '::remove_version', 10, 1 );
		add_filter( 'script_loader_src', 			__CLASS__ . '::remove_version', 10, 1 );
		add_filter( 'wp_prepare_themes_for_js', 	__CLASS__ . '::theme_display_mods' );
		add_filter( 'image_size_names_choose', 		__CLASS__ . '::insert_custom_image_sizes', 10, 1 );
		add_filter( 'posts_clauses',				__CLASS__ . '::inductee_orderby_year', 10, 2 );
		add_filter( 'fl_builder_is_node_visible',	__CLASS__ . '::state_inductee_visiblity', 10, 2 );
		add_filter( 'the_password_form',			__CLASS__ . '::password_form_banner', 10, 1 );
		add_filter( 'protected_title_format',		__CLASS__ . '::protected_title_format', 10, 2 );
		
		// Shortcodes
		add_shortcode( 'inductee_search',			__CLASS__ . '::inductee_search_shortcode' );
		add_shortcode( 'sports_grid',				__CLASS__ . '::sports_grid_shortcode' );
	}
	
    /**
     * @method enqueue_scripts
     */
    static public function enqueue_scripts() {
		$is_builder_active = FLBuilderModel::is_builder_active();
		
		if ( ! $is_builder_active ) {
			wp_enqueue_style( 'eshf-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
			wp_enqueue_style( 'fancybox3', FL_CHILD_THEME_URL . '/vendor/jquery.fancybox.min.css' );
		}
		wp_enqueue_style( 'nouislider', FL_CHILD_THEME_URL . '/vendor/nouislider.min.css' );
		wp_enqueue_style( 'fl-child-styles', FL_CHILD_THEME_URL . '/style.css' );
		
		if ( ! $is_builder_active ) {
			wp_enqueue_script( 'eshf-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array(), '', true );
			wp_enqueue_script( 'fancybox3', FL_CHILD_THEME_URL . '/vendor/jquery.fancybox.min.js', array(), '', true );
		}
		wp_enqueue_script( 'nouislider', FL_CHILD_THEME_URL . '/vendor/nouislider.min.js', array(), '', true );
		wp_enqueue_script( 'nicescroll', FL_CHILD_THEME_URL . '/vendor/jquery.nicescroll.min.js', array(), '', true );
		wp_enqueue_script( 'nicescroll-plus', FL_CHILD_THEME_URL . '/vendor/jquery.nicescroll.plus.js', array(), '', true );
		
		if ( is_post_type_archive('inductee') || is_tax( 'sport' ) || is_tax( 'role' ) ) {
			FLBuilder::enqueue_layout_styles_scripts_by_id( 463 );
		}
		
		wp_register_script( 'fl-child-scripts', FL_CHILD_THEME_URL . '/main.js', array(), '', true );
		$data = array(
			'ajaxUrl' => admin_url( 'admin-ajax.php', 'http' ),
			'frontend' => $is_builder_active ? false : true
		);
		wp_localize_script( 'fl-child-scripts', 'site', $data );
		wp_enqueue_script( 'fl-child-scripts' );
	}
	
	/**
     * @method remove_version
     */
	static public function remove_version( $src ) {
		if ( strpos( $src, '?ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		
		return $src;
	}
	
	/**
	 * #method theme_display_mods
	 */
	static public function theme_display_mods( $themes ) {
		if ( $themes['sbm-bb-theme'] ) {
			$logo_text = apply_filters( 'fl-logo-text', FLTheme::get_setting( 'fl-logo-text' ) );
			$logo_image = FLTheme::get_setting( 'fl-logo-image' );
			$theme_screenshot = $logo_image ? $logo_image : '//via.placeholder.com/732x550/ffffff/000000/?text=' . $logo_text . ' Theme';
			
			$themes['sbm-bb-theme']['name'] = get_bloginfo('name') . ' Theme';
			$themes['sbm-bb-theme']['screenshot'][0] = $theme_screenshot;
		}

		return $themes;
	}
	
	/**
     * @method add_typekit
     */
	static public function add_typekit() {
		echo '<link rel="stylesheet" href="https://use.typekit.net/ojq0bce.css">';
	}
	
	
	/**
     * @method add_fonts
     */
	static public function add_fonts() {
		if ( class_exists( 'FLBuilderFontFamilies' ) && class_exists( 'FLFontFamilies' ) ) {		
			$gibson = array(
				"fallback" => "sans-serif",
				"weights"  => array(
					"300",
					"400",
					"600",
					"700",
				)
			);
			
			FLBuilderFontFamilies::$system['canada-type-gibson'] = $gibson;
			FLFontFamilies::$system['canada-type-gibson'] = $gibson;
			
			$adriane = array(
				"fallback" => "serif",
				"weights"  => array(
					"300",
					"400",
					"600",
				)
			);
            
            FLBuilderFontFamilies::$system['adriane'] = $adriane;
			FLFontFamilies::$system['adriane'] = $adriane;
            
            $freightsans = array(
				"fallback" => "sans-serif",
				"weights"  => array(
					"300",
					"400",
					"600",
				)
			);
            
            FLBuilderFontFamilies::$system['freight-sans-pro'] = $freightsans;
			FLFontFamilies::$system['freight-sans-pro'] = $freightsans;
            
            $tisa = array(
				"fallback" => "serif",
				"weights"  => array(
					"300",
					"400",
					"600",
				)
			);
            
            FLBuilderFontFamilies::$system['ff-tisa-web-pro'] = $tisa;
			FLFontFamilies::$system['FF-Tisa-Pro'] = $tisa;
		}
	}
	
	/**
     * @method add_image_sizes
     */
	static public function add_image_sizes() {
		add_image_size( 'inductee', 344, 429, true );
	}
	
	/**
     * @method insert_custom_image_sizes
     */
	static public function insert_custom_image_sizes( $sizes ) {
		global $_wp_additional_image_sizes;
		if ( empty( $_wp_additional_image_sizes ) )
			return $sizes;

		foreach ( $_wp_additional_image_sizes as $id => $data ) {
			if ( ! isset($sizes[$id]) )
				$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
		}

		return $sizes;
	}
	
	/**
     * @method add_post_properties
     */
	static public function add_post_properties() {

		if ( class_exists('FLPageData') && class_exists('FLPageDataPost') && class_exists('FLPageDataSite') ) {
			
			FLPageData::add_group( 'inductees', array(
				'label' => 'Inductees'
			) );
			
			FLPageData::add_site_property( 'random_inductee', array(
				'label'       => __( 'Random Inductee', 'fl-theme-builder' ),
				'group'       => 'inductees',
				'type'        => 'all',
				'getter'      => 'FLChildTheme::get_random_inductee',
			) );
			
			FLPageData::add_site_property_settings_fields( 'random_inductee', array(
				'field'          =>  array(
					'type'         => 'select',
					'label'         => __( 'Field', 'fl-theme-builder' ),
					'default'       => 'name',
					'options'       => array(
						'name'		    => __( 'Name', 'fl-theme-builder' ),
						'bio'			=> __( 'Bio', 'fl-theme-builder' ),
						'link'			=> __( 'Link', 'fl-theme-builder' ),
						'image'			=> __( 'Image', 'fl-theme-builder' ),
					)
				)
			) );
			
			FLPageData::add_post_property( 'post_id', array(
				'label'       => __( 'Post ID', 'fl-theme-builder' ),
				'group'       => 'posts',
				'type'        => 'string',
				'getter'      => 'FLChildTheme::post_id',
			) );
			
			FLPageData::add_post_property( 'post_url', array(
				'label'       => __( 'Post URL', 'fl-theme-builder' ),
				'group'       => 'posts',
				'type'        => 'string',
				'getter'      => 'FLChildTheme::post_url',
			) );
			
			FLPageData::add_post_property( 'post_sport_icons', array(
				'label'       => __( 'Post Sport Icons', 'fl-theme-builder' ),
				'group'       => 'posts',
				'type'        => 'string',
				'getter'      => 'FLChildTheme::post_sport_icons',
			) );
			
			FLPageData::add_post_property( 'acf_post_term', array(
				'label'   => __( 'ACF Post Term Field', 'fl-theme-builder' ),
				'group'   => 'acf',
				'type'    => array( 'string', 'custom_field' ),
				'getter'  => 'FLChildTheme::string_field',
			) );
			
			$form = array(
				'taxonomy' => array(
					'type'          => 'select',
					'label'         => __( 'Taxonomy', 'fl-theme-builder' ),
					'default'       => 'category',
					'options'		=> FLPageDataPost::get_taxonomy_options(),
				),
				'type' => array(
					'type'    => 'select',
					'label'   => __( 'Field Type', 'fl-theme-builder' ),
					'default' => 'text',
					'options' => array(
						'text'		 		=> __( 'Text', 'fl-theme-builder' ),
						'textarea'			=> __( 'Textarea', 'fl-theme-builder' ),
						'number'	 		=> __( 'Number', 'fl-theme-builder' ),
						'email'		 		=> __( 'Email', 'fl-theme-builder' ),
						'url'		 		=> __( 'URL', 'fl-theme-builder' ),
						'password'	 		=> __( 'Password', 'fl-theme-builder' ),
						'wysiwyg'	 		=> __( 'WYSIWYG', 'fl-theme-builder' ),
						'oembed'	 		=> __( 'oEmbed', 'fl-theme-builder' ),
						'image'		 		=> __( 'Image', 'fl-theme-builder' ),
						'file'		 		=> __( 'File', 'fl-theme-builder' ),
						'select'	 		=> __( 'Select', 'fl-theme-builder' ),
						'checkbox'		 	=> __( 'Checkbox', 'fl-theme-builder' ),
						'radio'		 		=> __( 'Radio', 'fl-theme-builder' ),
						'page_link'  		=> __( 'Page Link', 'fl-theme-builder' ),
						'google_map'        => __( 'Google Map', 'fl-theme-builder' ),
						'date_picker'       => __( 'Date Picker', 'fl-theme-builder' ),
						'date_time_picker'  => __( 'Date Time Picker', 'fl-theme-builder' ),
						'time_picker'       => __( 'Time Picker', 'fl-theme-builder' ),
					),
					'toggle' => array(
						'image' => array(
							'fields' => array( 'image_size', 'display' ),
						),
						'checkbox' => array(
							'fields' => array( 'checkbox_format' ),
						),
					),
				),
				'name' => array(
					'type'  => 'text',
					'label' => __( 'Field Name', 'fl-theme-builder' ),
				),
				'display' => array(
					'type'          => 'select',
					'label'         => __( 'Display', 'fl-theme-builder' ),
					'default'       => 'tag',
					'options'       => array(
						'tag'        	=> __( 'Image Tag', 'fl-theme-builder' ),
						'url'        	=> __( 'URL', 'fl-theme-builder' ),
					),
				),
				'image_size' => array(
					'type'    => 'photo-sizes',
					'label'   => __( 'Image Size', 'fl-theme-builder' ),
					'default' => 'thumbnail',
				),
				'checkbox_format' => array(
					'type'    => 'select',
					'label'   => __( 'Format', 'fl-theme-builder' ),
					'default' => 'string',
					'options' => array(
						'text' 	  => __( 'Text', 'fl-theme-builder' ),
						'ol' 	  => __( 'Ordered List', 'fl-theme-builder' ),
						'ul' 	  => __( 'Unordered List', 'fl-theme-builder' ),
					),
				),
			);
			FLPageData::add_post_property_settings_fields( 'acf_post_term', $form );
			
		}
		
	}
	
	/**
     * @method get_random_inductee
     */
	static public function get_random_inductee( $settings ) {
		global $post;
		
		if ( empty( self::$random_inductee ) ) {
			$inductees = get_posts( array( 'post_type' => 'inductee', 'posts_per_page' => 1, 'orderby' => 'rand' ) );
			if ( $inductees ) {
				self::$random_inductee = $inductees[0];
			}
		}
		
		$output = '';
		switch( $settings->field ) {
			case 'name':
				$output = get_the_title( self::$random_inductee->ID );
				break;
			case 'bio':
				$output = wp_trim_words( self::$random_inductee->post_content, 80, '&hellip;' );
				break;
			case 'link':
				$output = get_permalink( self::$random_inductee->ID );
				break;
			case 'image':
				$output = get_the_post_thumbnail_url( self::$random_inductee, 'full' );
				break;
		}
		
		return $output;
	}
	
	/**
     * @method post_id
     */
	static public function post_id() {
		global $post;
		
		return $post->ID;
	}
	
	/**
     * @method post_url
     */
	static public function post_url() {
		global $post;
		
		return get_permalink();
	}
	
	/**
     * @method string_field
     */
	static public function string_field( $settings, $property ) {
		$content = '';
		$terms = get_the_terms( $post->ID, $settings->taxonomy );
		
		if ( $terms ) {
			foreach ( $terms as $term ) {
				$object  = get_field_object( trim( $settings->name ), $settings->taxonomy . '_' . $term->term_id );

				if ( empty( $object ) || ! isset( $object['type'] ) ) {
					return $content;
				}

				switch ( $object['type'] ) {
					case 'text':
					case 'textarea':
					case 'number':
					case 'email':
					case 'url':
					case 'password':
					case 'wysiwyg':
					case 'oembed':
					case 'select':
					case 'radio':
					case 'page_link':
					case 'date_time_picker':
					case 'time_picker':
						$content .= isset( $object['value'] ) ? $object['value'] : '';
						break;
					case 'checkbox':
						$values = array();

						if ( ! is_array( $object['value'] ) ) {
							break;
						} elseif ( 'text' !== $settings->checkbox_format ) {
							$content .= '<' . $settings->checkbox_format . '>';
						}

						foreach ( $object['value'] as $value ) {
							$values[] = is_array( $value ) ? $value['label'] : $value;
						}

						if ( 'text' === $settings->checkbox_format ) {
							$content .= implode( ', ', $values );
						} else {
							$content .= '<li>' . implode( '</li><li>', $values ) . '</li>';
							$content .= '</' . $settings->checkbox_format . '>';
						}
						break;
					case 'date_picker':
						if ( isset( $object['date_format'] ) && ! isset( $object['return_format'] ) ) {
							$format  = FLPageDataACF::js_date_format_to_php( $object['display_format'] );
							$date    = DateTime::createFromFormat( 'Ymd',  $object['value'] );

							// Only pass to format() if vaid date, DateTime returns false if not valid.
							if ( $date ) {
								$content .= $date->format( $format );
							} else {
								$content .= '';
							}
						} else {
							$content .= isset( $object['value'] ) ? $object['value'] : '';
						}
						break;
					case 'google_map':
						$value = isset( $object['value'] ) ? $object['value'] : '';
						$height = ! empty( $object['height'] ) ? $object['height'] : '400';
						if ( ! empty( $value ) && is_array( $value ) && isset( $value['address'] ) ) {
							$address = urlencode( $value['address'] );
							$content .= "<iframe src='https://www.google.com/maps/embed/v1/place?key=AIzaSyD09zQ9PNDNNy9TadMuzRV_UsPUoWKntt8&q={$address}' style='border:0;width:100%;height:{$height}px'></iframe>";
						} else {
							$content .= '';
						}
						break;
					case 'image':
						if ( $settings->display == 'tag' ) {
							$content .= '<img src="' . FLPageDataACF::get_file_url_from_object( $object, $settings->image_size ) . '" />';
						} else {
							$content .= FLPageDataACF::get_file_url_from_object( $object, $settings->image_size );
						}
						break;
					case 'file':
						$content .= FLPageDataACF::get_file_url_from_object( $object );
						break;
					case 'true_false':
						$content .= ( $object['value'] ) ? '1' : '0';
						break;
					default:
						$content = '';
				}// End switch().
			}
		}

		return is_string( $content ) ? $content : '';
	}
	
	/**
     * @method post_sport_icons
     */
	static public function post_sport_icons() {
		global $post;
		$terms = get_the_terms( $post->ID, 'sport' );
		
		if ( $terms ) {
			return implode( '', array_map( function( $term ) {
				$name = str_replace( array( ' ', '&amp;' ), array( '-', 'and' ), $term->name );
				return '<span class="eshf-sport-'.$name.'"></span>';
			}, $terms ) );
		} else {
			return false;
		}
	}
	
	/**
     * @method sticky_links
     */
	static public function sticky_links() {
		echo '<a href="' . home_url() . '" id="logo-link">home</a>';
		echo '<a href="javascript:;" id="menu-link" class="menu-link">menu</a>';
	}
	
	/**
     * @method filter_inductees
     */
	static public function filter_inductees( $query ) {
		
		if ( ! is_admin() && is_front_page() && $query->query['fl_builder_loop'] && $query->query['post_type'] == 'inductee' ) {
			
			$query->set( 'posts_per_page', 8 );
			$query->set( 'orderby', 'year_inducted title' );
			$query->set( 'order', 'DESC' );
		}
		
		if ( ! is_admin() && $query->is_main_query()
			&& ( ( $query->is_post_type_archive && $query->query['post_type'] == 'inductee' )
			|| ( is_tax( 'sport' ) || is_tax( 'role' ) ) )
		) {

			$s = isset( $_GET['k'] ) ? $_GET['k'] : null;
			$is_state = isset( $_GET['_state'] ) ? $_GET['_state'] : null;
			
			$tax = array();
			$tax['year'] = isset( $_GET['_yr'] ) ? explode( ',', $_GET['_yr'] ) : null;
			$tax['sport'] = isset( $_GET['_sport'] ) ? $_GET['_sport'] : null;
			$tax['role'] = isset( $_GET['_role'] ) ? $_GET['_role'] : null;
			$tax['level'] = isset( $_GET['_level'] ) ? $_GET['_level'] : null;
			
			$query->set( 'posts_per_page', 12 );
			$query->set( 'orderby', 'year_inducted title' );
			$query->set( 'order', 'DESC' );
			
			if ( $s ) {
				$query->set( 's', $s );
			}
			
			if ( $is_state ) {
				$query->set( 'meta_key', 'state_inductee' );
				$query->set( 'meta_value', '1' );
			}
			
			if ( $tax['year'] || $tax['sport'] || $tax['role'] || $tax['level'] ) {
				$tax_query = array();
				
				if ( $tax['year'] ) {					
					$tax_query[] = array(
						'taxonomy' => 'year_inducted',
						'field' => 'slug',
						'terms' => range( $tax['year'][0], $tax['year'][1] )
					);
				}
				if ( $tax['sport'] ) {
					$tax_query[] = array(
						'taxonomy' => 'sport',
						'field' => 'slug',
						'terms' => $tax['sport']
					);
				}
				if ( $tax['role'] ) {
					$tax_query[] = array(
						'taxonomy' => 'role',
						'field' => 'slug',
						'terms' => $tax['role']
					);
				}
				if ( $tax['level'] ) {
					$tax_query[] = array(
						'taxonomy' => 'level_played',
						'field' => 'slug',
						'terms' => $tax['level']
					);
				}
				
				$query->set( 'tax_query', $tax_query );
			}
			
			// echo '<pre>'; print_r( $query ); echo '</pre>';
		}
	}
	
	/**
     * @method inductee_orderby_year
     */
	static public function inductee_orderby_year( $clauses, $wp_query ) {
		global $wpdb;
		
		$taxonomies = array( 'year_inducted' );
		$orderby = explode( ' ', $wp_query->query_vars['orderby'] );
		if ( isset( $wp_query->query_vars['orderby'] ) && in_array( $orderby[0], $taxonomies ) ) {
			$clauses['join'] .= "
				LEFT OUTER JOIN {$wpdb->term_relationships} AS rel2 ON {$wpdb->posts}.ID = rel2.object_id
				LEFT OUTER JOIN {$wpdb->term_taxonomy} AS tax2 ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
				LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
			";
			$clauses['where'] .= " AND (taxonomy = '{$orderby[0]}' OR taxonomy IS NULL)";
			$clauses['groupby'] = "rel2.object_id";
			$clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
			$clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
		}
		
		return $clauses;
	}
	
	/**
     * @method inductee_search_shortcode
     */
	static public function inductee_search_shortcode() {
		ob_start();
		get_template_part( 'includes/inductee', 'search' );
		return ob_get_clean();
	}
	
	/**
     * @method sports_grid_shortcode
     */
	static public function sports_grid_shortcode() {
		$sports = get_terms( array( 'taxonomy' => 'sport' ) );
		$icons = array();
		
		if ( $sports ) {
			$icons = array_map( function( $sport ) {
				$name = str_replace( array( ' ', '&amp;' ), array( '-', 'and' ), $sport->name );
				return '<li class="erie-ih-list-item">
							<a href="' . get_term_link( $sport ) . '" class="erie-ih-link">
								<div class="erie-ih-item erie-ih-effect19 erie-ih-top_to_bottom erie-ih-square">
									<div class="erie-ih-image-block">
										<div class="erie-ih-wrapper"></div>
										<span class="erie-ih-image"><span class="eshf-sport-' . $name . '"></span></span>
									</div>
									<div class="erie-ih-info">
										<div class="erie-ih-info-back">
											<div class="erie-ih-content">
												<div style="" class="erie-ih-heading-block">
													<h3 class="erie-ih-heading">' . $sport->name . '</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</li>';
			}, $sports );
			
			return sprintf( '<ul class="sport-grid erie-ih-list uabb-align-center list-unstyled">%s</ul>', implode( '', $icons ) );
		}
		
		return false;
	}
	
	/**
     * @method state_inductee_visiblity
     */
	static public function state_inductee_visiblity( $is_visible, $node ) {
		global $post;
		$is_state_inductee = get_field( 'state_inductee', $post->ID );
		
		if ( $node->node == '5aaaccdb7eb51' && $is_state_inductee == false ) {	
			$is_visible = false;
		}
		
		return $is_visible;
	}
	
	/**
     * @method password_form_banner
     */
	static public function password_form_banner( $output ) {
		$banner = do_shortcode('[fl_builder_insert_layout slug="dynamic-banner" type="fl-builder-template"]');
		
		return $banner . $output;
	}
	
	/**
     * @method protected_title_format
     */
	static public function protected_title_format( $prepend, $post ) {
		return '%s';
	}
}