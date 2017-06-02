<?php

namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

/**
 * An example of how to write code to PEAR's standards
 *
 * Docblock comments start with "/**" at the top.  Notice how the "/"
 * lines up with the normal indenting and the asterisks on subsequent rows
 * are in line with the first asterisk.  The last line of comment text
 * should be immediately followed on the next line by the closing
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 */
/**
 * Sample_WP_List_Table class will create the page to load the table
 */
class Sample_Plugins_List_Table {
	/**
	 * Description
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'network_admin_menu', array( __CLASS__, 'add_menu_csc_list_table_page' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_menu_csc_list_table_page' ) );
	}

	/**
	 * Menu item will allow us to load the page to display the table
	 */
	public static function add_menu_csc_list_table_page() {
		// add_menu_page( 'This MultiSite Plugins', 'This MultiSite Plugins', 'manage_options', 'csc-list-table.php', array( __CLASS__, 'list_table_page' ), 'dashicons-info', 9 );
		add_submenu_page( 'connect-to-multisite.php', 'This MultiSite Plugins', 'This MultiSite Plugins', 'manage_options', 'csc-list-table1.php', array( __CLASS__, 'list_table_page' ) );
	}

	/**
	 * Display the list table page
	 *
	 * @return Void
	 */
	public static function list_table_page() {
		$csc_list_table = new CSC_List_Table();
		$csc_list_table->prepare_items();
		?>

		<div class="wrap">


			<div id="icon-users" class="icon32"></div>


			<h2>This MultiSite Plugins Page</h2>

			<?php $csc_list_table->views(); ?> 

			<form method="post">
				<input type="hidden" name="page" value="my_list_test" />
				<?php $csc_list_table->search_box( 'ToDo', 'search_id' ); ?>
			</form>

			<form method="post">
				<input type="hidden" name="plugin" value="<?php echo $_REQUEST['plugin']; ?>" />
				<?php $csc_list_table->display(); ?>
			</form>

		</div>
		<?php
	}
}

	// WP_List_Table is not loaded automatically so we need to load it in our application
if ( ! class_exists( '\WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class CSC_List_Table extends \WP_List_Table {

	/**
	 * Prepare the items for the table to process
	 *
	 * @return Void
	 */
	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$data = $this->table_data();
		usort( $data, array( &$this, 'sort_data' ) );

		$per_page = 30;
		$current_page = $this->get_pagenum();
		$total_items = count( $data );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
		) );

		$data = array_slice( $data, ( ( $current_page -1 ) * $per_page ),$per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items = $data;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function get_columns() {
		$columns = array(
			'cb'           => '<input type="checkbox" />',
			// 'id'           => 'ID',
			'Title'        => 'Title',
			'Description'  => 'Description',
			'Author'       => 'Author',
			'AuthorURI'    => 'AuthorURI',
			// 'AuthorName'   => 'AuthorName',
			'Network'      => 'Network',
			'TextDomain'   => 'TextDomain',
			'DomainPath'   => 'DomainPath',
		);

		return $columns;
	}
	/**
	 * Method for Checkbox column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'], // in this case it'll return 'plugin'
			/*$2%s*/ $item['Title']
		);
	}

	function get_bulk_actions() {
		$actions = array(
			// 'delete'    => 'Delete',
		);
		return $actions;
	}

	/**
	 * Define which columns are hidden
	 *
	 * @return Array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array(
			// 'id' => array( 'id', false ),
			'Title' => array( 'Title', false ),
			'Author' => array( 'Author', false ),
			'AuthorName' => array( 'AuthorName', false ),
			'AuthorURI' => array( 'AuthorURI', false ),
			'Network' => array( 'Network', false ),
			'TextDomain' => array( 'TextDomain', false ),
			'DomainPath' => array( 'DomainPath', false ),
		);
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = array();

		$all_plugins = get_plugins();

		return $all_plugins;
	}



	/**
	 * Define what data to show on each column of the table
	 *
	 * @param  Array  $item        Data
	 * @param  String $column_name - Current column name
	 *
	 * @return Mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'cb':
			case 'id':
			case 'Title':
			case 'Description':
			case 'Author':
			case 'AuthorURI':
			case 'AuthorName':
			case 'Network':
				if ( true === $item[ $column_name ] ) {
					return 'Network Only';
				}
				// break;
			case 'TextDomain':
			case 'DomainPath':
				return $item[ $column_name ];

			default:
				return print_r( $item, true );
		}
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET
	 *
	 * @return Mixed
	 */
	private function sort_data( $a, $b ) {
		// Set defaults
		$orderby = 'Title';
		$order = 'asc';

		// If orderby is set, use this as the sort column
		if ( ! empty( $_GET['orderby'] ) ) {
			$orderby = $_GET['orderby'];
		}

		// If order is set use this as the order
		if ( ! empty( $_GET['order'] ) ) {
			$order = $_GET['order'];
		}

		$result = strnatcmp( $a[ $orderby ], $b[ $orderby ] );

		if ( $order === 'asc' ) {
			return $result;
		}

		return -$result;
	}

	/**
	 * @see WP_List_Table::get_views()
	 */
	public function get_views() {
		return array();
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table
	 *
	 * @return Array
	 */
	public function extra_tablenav( $which ) {
		if ( $which == 'top' ) {

			/*
			?>
			Sent Date Range&nbsp;
			<form method="post">
			<input type="text" name="date_picker_from" class="example-datepicker" placeholder="From"
			value="<?php echo $_REQUEST['date_picker_from']; ?>">
			&nbsp;&nbsp;
			<input type="text" name="date_picker_to" class="example-datepicker" placeholder="To" value=
			"<?php echo $_REQUEST['date_picker_to']; ?>">
			&nbsp;&nbsp;
			<input type="submit" value="TODO" class="button">
			<input type="hidden" name="date_picker_from" value="<?php echo $_REQUEST['date_picker_from']; ?>">
			<input type="hidden" name="date_picker_to" value="<?php echo $_REQUEST['date_picker_to']; ?>">
			<input type="hidden" name="post_type" value="ecard">
			</form>


			<?php
			*/

			$current_offset = get_option( 'gmt_offset' );
			$tzstring = get_option( 'timezone_string' );
			$check_zone_info = true;
		?>
			<style type="text/css">
				.ddec-head {
					font-weight: bold;
					color: blue;
				}
			</style>
			<?php

			echo "<span class='ddec-head'>UTC = current_time( 'timestamp', 1 ) : </span><b>" . date( 'Y-m-d H:i:s', current_time( 'timestamp', 1 ) ) . '</b>';

			echo  ' | ' ;

			echo  "<span class='ddec-head'>WP Time Zone = </span><b>" . $tzstring;

			echo  ' | ' ;

			echo "<span class='ddec-head'>WP = current_time( 'timestamp') : </span><b>" . date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) . '</b>';
		}// End if().

		if ( $which == 'bottom' ) {
			// The code that goes after the table is there
			echo '</h4>' . __FUNCTION__ . ' adds code here</h4>';
		}
	}
}

