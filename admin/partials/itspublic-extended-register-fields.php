<?php

// Register Custom Fields for Members
function itspublic_members_fields( $meta_boxes ) {
    $prefix = 'itspublic-';

    $meta_boxes[] = array(
        'id' => 'member_fields',
        'title' => esc_html__( 'Member Fields', 'itspublic' ),
        'post_types' => array('member' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => 'true',
        'fields' => array(
            array(
                'id' => $prefix . 'member_designation',
                'type' => 'text',
                'name' => esc_html__( 'Designation', 'itspublic' ),
            ),
            array(
                'id' => $prefix . 'member_email',
                'name' => esc_html__( 'Email', 'itspublic' ),
                'type' => 'email',
            ),
            array(
                'id' => $prefix . 'member_linkedin',
                'type' => 'text',
                'name' => esc_html__( 'LinkedIn', 'itspublic' ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'itspublic_members_fields' );

// Metabox for Term "Project Type"
class ProjectTypeTermFields {
	private $meta_fields = array(
		array(
			'label' => 'Icon Class (FontAwesome v4.7)',
			'id' => 'type_icon',
			'default' => '',
			'type' => 'text',
		),
	);
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'project_type_add_form_fields', array( $this, 'create_fields' ), 10, 2 );
			add_action( 'project_type_edit_form_fields', array( $this, 'edit_fields' ),  10, 2 );
			add_action( 'created_project_type', array( $this, 'save_fields' ), 10, 1 );
			add_action( 'edited_project_type',  array( $this, 'save_fields' ), 10, 1 );
		}
	}
	public function create_fields( $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= '<div class="form-field">'.$this->format_rows( $label, $input ).'</div>';
		}
		echo $output;
	}
	public function edit_fields( $term, $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<div class="form-field">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<tr class="form-field"><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $term_id ) {
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_term_meta( $term_id, $meta_field['id'], $_POST[ $meta_field['id']] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_term_meta( $term_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('ProjectTypeTermFields')) {
	new ProjectTypeTermFields;
};

// Metabox for Term "Categorie"
class CategorieTermFields {
	private $meta_fields = array(
		array(
			'label' => 'Categorie Color',
			'id' => 'categorie_color',
			'default' => '',
			'type' => 'color',
		),
	);
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'categorie_add_form_fields', array( $this, 'create_fields' ), 10, 2 );
			add_action( 'categorie_edit_form_fields', array( $this, 'edit_fields' ),  10, 2 );
			add_action( 'created_categorie', array( $this, 'save_fields' ), 10, 1 );
			add_action( 'edited_categorie',  array( $this, 'save_fields' ), 10, 1 );
		}
	}
	public function create_fields( $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= '<div class="form-field">'.$this->format_rows( $label, $input ).'</div>';
		}
		echo $output;
	}
	public function edit_fields( $term, $taxonomy ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_term_meta( $term->term_id, $meta_field['id'], true );
			switch ( $meta_field['type'] ) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? '' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<div class="form-field">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<tr class="form-field"><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $term_id ) {
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_term_meta( $term_id, $meta_field['id'], $_POST[ $meta_field['id']] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_term_meta( $term_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('CategorieTermFields')) {
	new CategorieTermFields;
};