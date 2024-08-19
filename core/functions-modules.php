<?php

// -----------------------------------------------------------------------------
// Carrego os modulos
// -----------------------------------------------------------------------------
_require_all('core/modules', 2);


// -----------------------------------------------------------------------------
// Helper function that scan a path, recursively including all PHP files
// -----------------------------------------------------------------------------
function _require_all($dir, $max_depth = 1, $depth = 1) {
    if ($depth > $max_depth) {
        return;
    }

    // require all php files
    $theme_dir = get_template_directory();
    $scan      = glob("$theme_dir/$dir/*");

    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        } elseif (is_dir($path)) {
            _require_all($path, $max_depth, $depth + 1);
        }
    }
}


// -----------------------------------------------------------------------------
// Class Modules
// -----------------------------------------------------------------------------
class Module {

    protected $arguments = array();
    protected $options   = array();
    protected $fields    = array();
    protected $location  = array();

    // Construct Modules
    public function __construct( $id, $title, $order = 0 ) {
        $this->id    = $id;
        $this->title = $title;
        $this->menu_order = $order;

    }
    // Custom location
    public function set_field($type, $label, $name, $opitons = array()){
        $field_defaut = array(
            'key'   => 'field_'.$this->id.'_'.$name,
            'label' => $label,
            'name'  => $name,
            'type'  => $type,
        );
        
        $field_new = array();

        if ($type == 'image') {
            $field_new = array(
                'save_format'  => 'url',
                'preview_size' => 'thumbnail',
                'library'      => 'uploadedTo'
            );
                
        } else if ($type == 'textarea') {
            $field_new = array(
                'formatting' => 'br',
            );
        } else if ($type == 'repeater') {
            $field_new = array(
                'sub_fields'   => $opitons,
                'layout'       => 'row',
                'button_label' => 'Adicionar',

            );
        } else if ($type == 'text') {
            $field_new = array(
                'formatting' => 'none',
            );
        }

        $field_new = array_merge( $field_new, $opitons );

        $field[] = array_merge( $field_defaut, $field_new );

        $this->fields = array_merge($this->fields, $field);

    }

    // Custom location
    public function set_location($param, $value){
        $location[][] = array (
            'param'    => $param,
            'operator' => '==',
            'value'    => $value,
            'order_no' => 0,
            'group_no' => 0,
        );

        $this->location = array_merge($this->location, $location);
    }

    // Custom options
    public function set_options( $options = array() ) {
        $this->options = $options;
    }

    // fields
    protected function fields() {
        return $this->fields;
    }

    // Options
    protected function options() {
        $default = array(
            'position'       => 'normal',
            'layout'         => 'default',
            'hide_on_screen' => array (
                0 => 'the_content',
            )
        );
        
        return array_merge( $default, $this->options );
    }

    // fields
    protected function location() {
        return $this->location;
    }

    // Arguments
    public function arguments() {
        $arguments = array(
            'id'         => $this->id,
            'title'      => $this->title,
            'fields'     => $this->fields(),
            'location'   => $this->location(),
            'options'    => $this->options(),
            'menu_order' => $this->menu_order
        );

        return $arguments;
    }


}
