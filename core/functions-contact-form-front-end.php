<?php
// ----------------------------------------------------------------------------
// Front_End_Form clas
// ----------------------------------------------------------------------------
abstract class Front_End_Form {

	// Form fields
	protected $fields = array();

	// Form buttons
	protected $buttons = array();

	// Form errors
	protected $errors = array();

	// Form success
	protected $success = '';

	// Form construct
	public function __construct( $id, $action = '', $method = 'post', $attributes = array() ) {
		$this->id         = $id;
		$this->action     = $action;
		$this->method     = $method;
		$this->attributes = $attributes;
	}

	// Set Class Form
	public function set_class_form($class) {
		$form['class'] = $class;

		$this->form = $form;
	}
	// Set errors
	protected function set_errors( $errors = array() ) {
		$this->errors[] = $errors;
	}

	// Set form fields
	public function set_field( $type, $id, $label, $required = false, $args = array(), $default = false ) {
		$field = array(
			'id'         => $id, // Required
			'label'      => $label,
			'type'       => $type,
			'required'   => $required,
			'attributes' => $args['attributes'],
			'options'    => $args['options'],
			'default'    => $default,
        );

        $this->fields[] = $field;
	}

	// Set form buttons
	public function set_button( $type, $label, $class ) {
		$button = array(
			'type'       => $type,
			'label'      => $label,
			'class' 	 => $class,
		);

		$this->buttons[] = $button;
	}


	// Set success message
	public function set_success_message( $success = '' ) {
		$this->success = $success;
	}

	// Get submitted data
	public function get_submitted_data() {
		$data = $this->submitted_form_data();

		return $data;
	}

	// Get submitted attachments
	public function get_attachments() {
		$attachments = $this->uploaded_files();

		return $attachments;
	}

	// Get current page
	protected function get_current_page() {
		$url = 'http';
		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
			$url .= 's';
		}

		$url .= '://';

		if ( '80' != $_SERVER['SERVER_PORT'] ) {
			$url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		return $url;
	}

	// Get field label via ID
	protected function get_field_label( $id ) {
		foreach ( $this->fields as $field ) {
			if ( $field['id'] == $id ) {
				return $field['label'];
			}
		}

		return '';
	}

	// Process form and fields attributes
	protected function process_attributes( $attributes = array() ) {
		$attrs = '';

		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $key => $attribute ) {
				if ($key !== 'class_col') {
					$attrs .= ' ' . $key . '="' . $attribute . '"';
				}
			}
		}

		return $attrs;
	}

	// Sets the field default value
	protected function default_field( $id, $default ) {
		if ( 'get' == $this->method ) {
			return isset( $_GET[ $id ] ) ? sanitize_text_field( $_GET[ $id ] ) : $default;
		} else {
			return isset( $_POST[ $id ] ) ? sanitize_text_field( $_POST[ $id ] ) : $default;
		}
	}

	// Process form fields
	protected function process_fields() {
		$html = '';

		if ( ! empty( $this->fields ) ) {
			foreach ( $this->fields as $field ) {
				$id          = $field['id'];
				$type        = $field['type'];
				$label       = $field['label'];
				$attributes  = isset( $field['attributes'] ) ? $field['attributes'] : array();
				$options     = isset( $field['options'] ) ? $field['options'] : '';
				$required    = isset( $field['required'] ) && $field['required'] ? true : false;
				$default     = isset( $field['default'] ) ? $field['default'] : '';
				$default     = $this->default_field( $id, $default );

				if ( $required ) {
					$attributes = array_merge( array( 'required' => 'required' ), $attributes );
				}

				$class = explode(' ', $this->form['class']);
				foreach ($class as $form) {
					if ($form == 'Row') {
						$this->row = true;
					}
				}

				if ($this->row) {
					if ($attributes['class_col']) {
						$col = ' col '.$attributes['class_col'];
					} else {
						$col = ' col _col-12';
					}
				}
				$html .= '<div class="form-item'.$col.'">';
				switch ( $type ) {
					case 'text':
						$html .= $this->field_input( $id, $label, $default, $attributes );
						break;
					case 'hidden':
						$html .= $this->field_hidden( $id, $default, $attributes );
						break;
					case 'email':
						$html .= $this->field_input( $id, $label, $default, array_merge( array( 'type' => 'email' ), $attributes ) );
						break;
					case 'file':
						$html .= $this->field_input( $id, $label, $default, array_merge( array( 'type' => 'file' ), $attributes ) );
						$this->attributes = array_merge( array( 'enctype' => 'multipart/form-data' ), $this->attributes );
						break;
					case 'input':
						$html .= $this->field_input( $id, $label, $default, $attributes );
						break;
					case 'textarea':
						$html .= $this->field_textarea( $id, $label, $default, $attributes );
						break;
					case 'checkbox':
						$html .= $this->field_checkbox( $id, $label, $default, $attributes, $options );
						break;
					case 'select':
						$html .= $this->field_select( $id, $label, $default, $attributes, $options );
						break;
					case 'radio':
						$html .= $this->field_radio( $id, $label, $default, $attributes, $options );
						break;

					default:
						$html .= do_action( 'front_end_form_field_' . $this->id, $id, $label, $default, $attributes, $options );
						break;
				}

				$html .= '</div>';
			}
		}

		return $html;
	}

	// Process form buttons
	protected function process_buttons() {

		if ($this->row) {
			$col = ' col _button';
		}
		
		$html .= '<div class="form-item'.$col.'">';
		if ( ! empty( $this->buttons ) ) {
			foreach ( $this->buttons as $button ) {

				$attributes = array( 'class' => $button['class'] );
				$html .= sprintf(
					'<button type="%s"%s>%s</button>',
					$button['type'],
					$this->process_attributes( $attributes ),
					$button['label']
				);
			}
		} else {
			$html .= '<button type="submit" class="Button">Enviar</button>';
		}
		
		$html .= '</div>';


		return $html;
	}

	// Display error messages
	public function display_error_messages( $html ) {
		if ( ! empty( $this->errors ) ) {

			$html .= '<div class="Message _error"><ul class="_mb0">';

			foreach ( $this->errors as $error ) {
				$html .= '<li class="' . $error['id'] . '">' . $error['message'] . '</li>';
			}

			$html .= '</ul></div>';
		}

		return $html;
	}

	// Display success message
	protected function display_success_message() {
		$html = '';

		if ( isset( $_GET['success'] ) && 1 == $_GET['success'] ) {
			$html .= '<div class="modal _modal-form-success">';
			
			if ( ! empty( $this->success ) ) {
				$html .= $this->success;
			} else {
				$html .= '<div class="text"><h2>Obrigado!</h2><p>Seus dados foram enviados com sucesso.</p></div>';
			}
			
			$html .= '<span class="modal-close"></span></div>';
		}

		return $html;
	}

	// Required field HTML
	protected function required_field_alert( $attributes ) {
		if ( isset( $attributes['required'] ) ) {
			return ' <span class="text-danger">*</span>';
		}
	}

	// Input field
	protected function field_input( $id, $label, $default, $attributes ) {
		// Set the default type
		if ( ! isset( $attributes['type'] ) ) {
			$attributes['type'] = 'text';
		}

		if ($label) {
			$html .= '<label>'.$label.$this->required_field_alert( $attributes ).'</label>';
		}
		$html .= sprintf( '<div><input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, $default, $this->process_attributes( $attributes ) );
		$html .= '</div>';

		return $html;
	}

	// Hidden field
	protected function field_hidden( $id, $default, $attributes ) {
		// Set the default type
		if ( ! isset( $attributes['type'] ) ) {
			$attributes['type'] = 'hidden';
		}

		$html = sprintf( '<input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, $default, $this->process_attributes( $attributes ) );

		return $html;
	}

	// Textarea field
	protected function field_textarea( $id, $label, $default, $attributes ) {
		// Set the default class
		if ( ! isset( $attributes['cols'] ) ) {
			$attributes['cols'] = '60';
		}

		if ( ! isset( $attributes['rows'] ) ) {
			$attributes['rows'] = '4';
		}

		if ($label) {
			$html .= '<label>'.$label.$this->required_field_alert( $attributes ).'</label>';
		}
		$html .= sprintf( '<div><textarea id="%1$s" name="%1$s"%2$s>%3$s</textarea>', $id, $this->process_attributes( $attributes ), $default );
		$html .= '</div>';

		return $html;
	}

	// Checkbox field
	protected function field_checkbox( $id, $label, $default, $attributes, $options ) {
		if ($label) {
			$html .= '<label>'.$label.$this->required_field_alert( $attributes ).'</label>';
		}
		$html .= '<div class="_checkboxes">';

		foreach ( $options as $value => $label ) {
			// Set the checked attribute
			if ( $value == $default ) {
				$attributes['checked'] = 'checked';
			} else if ( isset( $attributes['checked'] ) ) {
				unset( $attributes['checked'] );
			}

			$html .= sprintf( '<label class="_checkbox"><input type="checkbox" id="%1$s-%2$s" name="%1$s" value="%2$s"%4$s /> %3$s</label>', $id, $value, $label, $this->process_attributes( $attributes ) );
		}
		$html .= '</div>';


		return $html;
	}

	// Select field
	protected function field_select( $id, $label, $default, $attributes, $options ) {
		// If multiple add a array in the option
		$multiple = ( in_array( 'multiple', $attributes ) ) ? '[]' : '';

		if ($label) {
			$html .= '<label>'.$label.$this->required_field_alert( $attributes ).'</label>';
		}
		$html .= sprintf( '<select id="%1$s" name="%1$s%2$s"%3$s>', $id, $multiple, $this->process_attributes( $attributes ) );

		foreach ( $options as $value => $name ) {
			// Set the selected attribute
			$selected = ( $value == $default ) ? ' selected="selected"' : '';

			$html .= sprintf( '<option value="%s"%s>%s</option>', $value, $selected, $name );
		}

		$html .= '</select>';

		return $html;
	}

	// Radio field
	protected function field_radio( $id, $label, $default, $attributes, $options ) {
		if ($label) {
			$html .= '<label>'.$label.$this->required_field_alert( $attributes ).'</label>';
		}
		$html .= '<div class="_checkboxes">';

		foreach ( $options as $value => $label ) {
			// Set the checked attribute
			if ( $value == $default ) {
				$attributes['checked'] = 'checked';
			} else if ( isset( $attributes['checked'] ) ) {
				unset( $attributes['checked'] );
			}

			$html .= sprintf( '<label class="_checkbox"><input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s"%4$s /> %3$s</label>', $id, $value, $label, $this->process_attributes( $attributes ) );
		}
		$html .= '</div>';

		return $html;
	}

	// Checks if the form data is valid
	protected function is_valid() {
		$valid = empty( $this->errors ) ? true : false;

		return $valid;
	}

	// Gests the form submitted data
	protected function submitted_form_data() {
		// Checks the form method
		if ( 'get' == $this->method ) {
			$data = $_GET;
		} else {
			$data = $_POST;
		}

		return $data;
	}

	// Gests the form submitted files
	protected function submitted_form_files() {
		$files = array();

		// Checks the form method
		if ( 0 < count( $_FILES ) ) {
			$files = $_FILES;
		}

		return $files;
	}

	// Validates the form data
	protected function validate_form_data() {
		$errors = array();

		// Sets the data.
		$data  = $this->submitted_form_data();
		$files = $this->submitted_form_files();

		if ( ! empty( $this->fields ) && ! empty( $data ) ) {
			foreach ( $this->fields as $field ) {
				$id       = $field['id'];
				$type     = $field['type'];
				$label    = isset( $field['label'] ) ? $field['label'] : '';
				$value    = ! empty( $data[ $id ] ) ? $data[ $id ] : '';
				$required = isset( $field['required'] ) && $field['required'] ? true : false;

				if ( $type != 'file' && $required && empty( $data[ $id ] ) ) {
					$this->set_errors(array('message'=> sprintf('Campo %s é obrigatório', '<strong>' . $label . '</strong>' ), 'id' =>  $id ));
				}

				switch ( $type ) {
					case 'email':
						if ( ! is_email( $value ) ) {
							$this->set_errors(array('message'=> sprintf('Campo %s precisa de um endereço válido', '<strong>' . $label . '</strong>' ), 'id' =>  $id ));
						}
						break;
					case 'file':
						if ( count($files) >= 1 ) {
							if ( $required && empty( $files[ $id ]['name'] ) ) {
								$this->set_errors(array('message'=> sprintf('Campo %s é obrigatório', '<strong>' . $label . '</strong>' ), 'id' =>  $id ));
							}
						}
						break;

					default:
						$custom_message = apply_filters( 'front_end_form_valid_' . $this->id . '_' . $id, '', $label, $value );
						if ( $custom_message ) {
							$this->set_errors(array('message'=> $custom_message, 'id' =>  $id));
						}
						break;
				}
			}

		}

		// Sets the errors
		if ( ! empty( $this->errors ) ) {

			// Remove valid param
			if ( isset( $_GET['success'] ) && 1 == $_GET['success'] ) {
				unset( $_GET['success'] );
			}
		}
	}

	// Redirect to current page
	protected function redirect() {
		@ob_clean();

		$url = $this->get_current_page();
		$url = apply_filters( 'front_end_form_redirect_' . $this->id, add_query_arg( 'success', '1', $url ) );

		wp_redirect( $url, 303 );

		exit;
	}

	// Process the send form files
	protected function uploaded_files() {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachments = array();

		foreach ( $this->fields as $field ) {
			$id = $field['id'];

			if ( 'file' == $field['type'] && isset( $_FILES[ $id ] ) ) {
				$attachment_id = media_handle_upload( $id, 0 );

				$attachments[ $id ] = array(
					'file' => get_attached_file( $attachment_id ),
					'url'  => wp_get_attachment_url( $attachment_id )
				);
			}
		}

		return $attachments;
	}

	// Render the form
	public function render() {

		$html = '';

		// Process the fields
		$fields = $this->process_fields();

		// Class
		if ($this->form['class']) {
			$form_class = '';
			
			$form_classes = array( 'class' => 'Form '.$this->form['class'] );
		} else {
			$form_classes = array( 'class' => 'Form' );
		}

		$action = get_permalink().'#'.$this->id;

		// Generate the form
		$html .= sprintf(
			'<form action="%s" id="%s" method="%s"%s>',
			$action,
			$this->id,
			$this->method,
			$this->process_attributes( array_merge( $form_classes, $this->attributes ) )
		);

		// Display error messages
		$html .= apply_filters( 'front_end_form_messages_' . $this->id, $html );

		// Display success message
		$html .= $this->display_success_message();

			$html .= do_action( 'front_end_form_before_fields_' . $this->id );
			$html .= $fields;
			$html .= do_action( 'front_end_form_after_fields_' . $this->id );
			$html .= $this->process_buttons();
			$html .= sprintf( '<input type="hidden" name="form_action" value="%s" />', $this->id );
			if (get_field('texto_email', $post->ID)) {
			$html .= '<input type="hidden" name="texto_email_field" value="'.get_field('texto_email', $post->ID).'" />';
			$html .= '<input type="hidden" name="arquivo_field" value="'.get_field('arquivo', $post->ID)['url'].'" />';
			}
		$html .= '</form>';

		return $html;
	}

	public function render_before() {

		$html = '';

		// Class
		if ($this->form['class']) {
			$form_class = '';
			
			$form_classes = array( 'class' => 'Form '.$this->form['class'] );
		} else {
			$form_classes = array( 'class' => 'Form' );
		}

		$action = get_permalink().'#'.$this->id;

		// Generate the form
		$html .= sprintf(
			'<form action="%s" id="%s" method="%s"%s>',
			$action,
			$this->id,
			$this->method,
			$this->process_attributes( array_merge( $form_classes, $this->attributes ) )
		);

		// Display error messages
		$html .= apply_filters( 'front_end_form_messages_' . $this->id, $html );

		// Display success message
		$html .= $this->display_success_message();

		return $html;
	}

	public function render_after() {
		$html .= sprintf( '<input type="hidden" name="form_action" value="%s" />', $this->id );
		if (get_field('texto_email', $post->ID)) {
			$html .= '<input type="hidden" name="texto_email_field" value="'.get_field('texto_email', $post->ID).'" />';
			$html .= '<input type="hidden" name="arquivo_field" value="'.get_field('arquivo', $post->ID)['url'].'" />';
		}
		$html .= '</form>';

		return $html;
	}

	// Form init
	public function init() {
		$submitted_data = $this->submitted_form_data();
		$uploaded_files = $this->get_attachments();

		if ( ! empty( $submitted_data ) && isset( $submitted_data['form_action'] ) && $this->id == $submitted_data['form_action'] ) {
			// Validates the form data
			$this->validate_form_data();

			if ( $this->is_valid() ) {
				// Hook to process submitted form data
				do_action( 'front_end_form_submitted_data_' . $this->id, $submitted_data, $uploaded_files );

				// Redirect after submit
				$this->redirect();
			} else {
				add_filter( 'front_end_form_messages_' . $this->id, array( $this, 'display_error_messages' ) );
			}
		}
	}

}
