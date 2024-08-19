<?php
// ----------------------------------------------------------------------------
// Contact_Form class
// ----------------------------------------------------------------------------
class Contact_Form extends Front_End_Form {

	// Mail content type
	protected $content_type = 'text/html';

	// Mail subject
	protected $subject = '';

	// Mail Reply-To
	protected $reply_to = '';

	// Contact Form construct
	public function __construct( $id, $to, $cc = array(), $bcc = array(), $attributes = array(), $attachment_type = 'file' ) {
		$this->id              = $id;
		$this->to              = $to;
		$this->cc              = $cc;
		$this->bcc             = $bcc;
		$this->attributes      = $attributes;
		$this->attachment_type = $attachment_type;

		parent::__construct( $this->id, '', 'post', $this->attributes );

		// Hooks send_mail
		add_action( 'front_end_form_submitted_data_' . $this->id, array( $this, 'send_mail' ), 1, 2 );

		// init form
		add_action( 'init', array( &$this, 'init' ), 1 );
	}

	// Set the mail content type
	public function set_content_type( $content_type ) {
		if ( 'html' == $content_type ) {
			$this->content_type = 'text/html';
		}
	}

	// Set the mail subject
	public function set_subject( $subject ) {
		$this->subject = $subject;
	}

	// Mail Reply-To
	public function set_reply_to( $reply_to ) {
		$this->reply_to = $reply_to;
	}

	// Process the sent form data
	protected function process_submitted_form_data( $submitted_data, $attachments ) {
		$data = array();

		// Process the fields
		if ( ! empty( $this->fields ) && ! empty( $submitted_data ) ) {
			foreach ( $this->fields as $field ) {
				if ( 'file' != $field['type'] ) {
					$id    = $field['id'];
					if ($field['label']) {
						$label = $field['label'];
					} else {
						$label = $field['attributes']['placeholder'];
					}

					$data[ $label ] = $submitted_data[ $id ];
				} elseif ( 'file' == $field['type'] && 'url' == $this->attachment_type ) {
					$id    = $field['id'];
					$label = $field['label'];
					$url   = $attachments[ $id ]['url'];

					$data[ $label ] = '<p><a href="' . $url . '" target="_blank">' . $url . '</a></p>';
				}
			}
		}

		return $data;
	}

	// Build the mail subject
	protected function build_mail_subject( $submitted_data ) {
		if ( ! empty( $this->subject ) ) {
			$subject = $this->subject;

			// Create the placeholders
			$placeholders = array_merge(
				array(
					'form_id' => $this->id,
					'sent_date' => date( get_option( 'date_format' ) ),
					'sent_time' => date( get_option( 'time_format' ) )
				),
				$submitted_data
			);

			// Process the placeholders
			foreach ( $placeholders as $placeholder => $value ) {
				$subject = str_replace( '[' . $placeholder . ']', sanitize_text_field( $value ), $subject );
			}

			return $subject;
		} else {
			// Default subject
			return sprintf('Mensagem enviada pelo formulário de contato em %s às %s',
				date( get_option( 'date_format' ) ),
				date( get_option( 'time_format' ) )
			);
		}
	}

	// Get attachments paths
	protected function get_attachments_paths( $attachments ) {
		$paths = array();

		foreach ( $attachments as $attachment ) {
			$paths[] = $attachment['file'];
		}

		return $paths;
	}

	// Format the mail headers
	protected function format_mail_headers( $submitted_data ) {
		$headers = array();

		// Cc
		if ( ! empty( $this->cc ) ) {
			foreach ( $this->cc as $cc ) {
				$headers[] = 'Cc: ' . $cc;
			}
		}

		// Bc
		if ( ! empty( $this->bcc ) ) {
			foreach ( $this->bcc as $bcc ) {
				$headers[] = 'Bcc: ' . $bcc;
			}
		}

		// Reply-To
		if ( ! empty( $this->reply_to ) ) {
			$headers[] = 'Reply-To: ' . sanitize_email( $submitted_data[ $this->reply_to ] );
		}

		// Content type
		if ( 'text/html' == $this->content_type ) {
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
		}

		return apply_filters( 'contact_form_mail_headers_' . $this->id, $headers );
	}

	// Send the mail
	public function send_mail( $submitted_data, $attachments ) {
		if ( ! empty( $submitted_data ) ) {
			// Mail subject
			$subject = $this->build_mail_subject( $submitted_data );

			// Build message to company
			$data['data'] = $this->process_submitted_form_data( $submitted_data, $attachments );
			$message = Timber::compile('email/email.twig', $data);

			// Mail headers
			$headers = $this->format_mail_headers( $submitted_data );
	
			// Send mail
			if ( 0 < count( $attachments ) && 'file' == $this->attachment_type ) {
				$files = $this->get_attachments_paths( $attachments );
			} else {
				$files = '';
			}

			// Send email to company
			wp_mail( $this->to, $subject, $message, $headers, $files );

			// Get email of user
			$email_user = $submitted_data['email'];

			if (is_array($_POST) && !empty($_POST)) {
			    $title = isset($subject) ? $subject : 'Formulário';

			    // Get posted values
			    if ( ! empty( $this->fields ) && ! empty( $submitted_data ) ) {
					foreach ( $this->fields as $field ) {
						if ( 'file' != $field['type'] ) {
							$id    = $field['id'];
							if ($field['label']) {
								$label = $field['label'];
							} else {
								$label = $field['attributes']['placeholder'];
							}

							$data_post[ $label ] = $submitted_data[ $id ];
						} elseif ( 'file' == $field['type'] ) {
							$id    = $field['id'];
							$label = $field['label'];
							$url   = $attachments[ $id ]['url'];

							$data_post[ $label ] = $url;
							$data_file[ $label ] = $url;
						}
					}
				}

			    // Prepare data structure for call to hook
			    $data = (object) array(
					'title'          => $title,
					'posted_data'    => $data_post,
					'uploaded_files' => $data_file,
					'submitted_from' => ''
			    );

			    // Call hook to submit data
			    do_action_ref_array('cfdb_submit', array(&$data));

        	    $to_user = $this->to;

			    if (strpos($this->to, ',')) {
			   		$to_user = explode(',', $this->to)[0];
			    }

        	    $headers_user[] = 'Reply-To: ' . $to_user;
        	    $headers_user[] = 'Content-Type: text/html; charset=UTF-8';

        	    // Build message to user
				$data->site_name = get_bloginfo();
				$data            = (array) $data;

        	    // Send email to user
            	$message = Timber::compile('email/email.twig', $data);
            	
            	if ($email_user) {
            		wp_mail($email_user, $subject, $message, $headers_user);
            	}
	
				// Email Reply
				if ($_POST['texto_email_field']) {
					$message = '<p>'.$_POST['texto_email_field'].'</p>';
					$message .= '<p><a href="' . $_POST['arquivo_field'] . '" target="_blank">' . $_POST['arquivo_field'] . '</a></p>';
					$files   = $this->get_attachments_paths( array($_POST['arquivo_field']) );
					$mail_to = sanitize_email( $submitted_data[ $this->reply_to ] );
					
					wp_mail( $mail_to, $subject, $message, $headers, $files );
				}
			}
		}
	}
}