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
class Sample_WP_List_Table {
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
		add_menu_page( 'CSC List Table', 'CSC List Table', 'manage_options', 'csc-list-table.php', array( __CLASS__, 'list_table_page' ), 'dashicons-info', 9 );
		// add_submenu_page( 'csc-list-table.php', 'CSC List Table', 'CSC List Table', 'manage_options', 'csc-list-table1.php', array( __CLASS__, 'list_table_page' ), 'dashicons-info', 9 );
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


			<h2>CSC List Table Page</h2>

			<form method="post">
				<input type="hidden" name="page" value="my_list_test" />
				<?php $csc_list_table->search_box( 'ToDo', 'search_id' ); ?>
			</form>

			<form method="post">
				<input type="hidden" name="logs" value="<?php echo $_REQUEST['log']; ?>" />
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

		$perPage = 20;
		$currentPage = $this->get_pagenum();
		$totalItems = count( $data );

		$this->set_pagination_args( array(
			'total_items' => $totalItems,
			'per_page'    => $perPage,
		) );

		$data = array_slice( $data, ( ( $currentPage -1 ) * $perPage ),$perPage );

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
			'cb'            => '<input type="checkbox" />',
			'id'          => 'ID',
			'title'       => 'Title',
			'description' => 'Description',
			'year'        => 'Year',
			'director'    => 'Director',
			'rating'      => 'Rating',
		);

		return $columns;
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
	public function get_sortable_columns1() {
		return array(
			'id' => array( 'id', false ),
			'title' => array( 'title', false ),
			'year' => array( 'year', false ),
			'director' => array( 'director', false ),
			'rating' => array( 'rating', false ),
		);
	}

	/**
	 * Define the sortable columns
	 *
	 * @return Array
	 */
	public function get_sortable_columns() {
		return array(
			'id' => array( 'id', false ),
			'title' => array( 'title', false ),
			'year' => array( 'year', false ),
			'director' => array( 'director', false ),
			'rating' => array( 'rating', false ),
		);
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data() {
		$data = array();
		$data[] = array(
					'cb'          => '<input type="checkbox" />',
					'id'          => 1,
					'title'       => 'The Shawshank Redemption',
					'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
					'year'        => '1994',
					'director'    => 'Frank Darabont',
					'rating'      => '9.3',
					);

		$data[] = array(
					'cb'          => '<input type="checkbox" />',
					'id'          => 2,
					'title'       => 'The Godfather',
					'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
					'year'        => '1972',
					'director'    => 'Francis Ford Coppola',
					'rating'      => '9.2',
					);
		return $data;
	}

	/**
	 * Get the table data
	 *
	 * @return Array
	 */
	private function table_data1() {
		$data = array();

		$data[] = array(
					'cb'          => '<input type="checkbox" />',
					'id'          => 1,
					'title'       => 'The Shawshank Redemption',
					'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
					'year'        => '1994',
					'director'    => 'Frank Darabont',
					'rating'      => '9.3',
					);

		$data[] = array(
					'cb'          => '<input type="checkbox" />',
					'id'          => 2,
					'title'       => 'The Godfather',
					'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
					'year'        => '1972',
					'director'    => 'Francis Ford Coppola',
					'rating'      => '9.2',
					);

		$data[] = array(
					'id'          => 3,
					'title'       => 'The Godfather: Part II',
					'description' => 'The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on his crime syndicate stretching from Lake Tahoe, Nevada to pre-revolution 1958 Cuba.',
					'year'        => '1974',
					'director'    => 'Francis Ford Coppola',
					'rating'      => '9.0',
					);

		$data[] = array(
					'id'          => 4,
					'title'       => 'Pulp Fiction',
					'description' => 'The lives of two mob hit men, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
					'year'        => '1994',
					'director'    => 'Quentin Tarantino',
					'rating'      => '9.0',
					);

		$data[] = array(
					'id'          => 5,
					'title'       => 'The Good, the Bad and the Ugly',
					'description' => 'A bounty hunting scam joins two men in an uneasy alliance against a third in a race to find a fortune in gold buried in a remote cemetery.',
					'year'        => '1966',
					'director'    => 'Sergio Leone',
					'rating'      => '9.0',
					);

		return $data;
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
			case 'title':
			case 'description':
			case 'year':
			case 'director':
			case 'rating':
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
		$orderby = 'title';
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
}

