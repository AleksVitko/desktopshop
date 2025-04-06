<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Класс отвечает за работу страницы логов.
 *
 * @author        Artem Prihodko <webtemyk@yandex.ru>
 * @copyright (c) 2020, Webcraftic
 * @version       1.0
 */
class Wbcr_FactoryLogger149_PageBase extends \WBCR\Factory_Templates_134\Pages\PageBase {

	/**
	 * {@inheritdoc}
	 */
	public $id; // Уникальный идентификатор страницы

	/**
	 * {@inheritdoc}
	 */
	public $page_menu_dashicon = 'dashicons-admin-tools';

	/**
	 * {@inheritdoc}
	 */
	public $type = 'page';

	/**
	 * @param Wbcr_Factory480_Plugin $plugin
	 */
	public function __construct($plugin)
	{
		$this->id = $plugin->getPrefix() . "logger";

		$this->menu_title = __('Plugin Log', 'wbcr_factory_logger_149');
		$this->page_menu_short_description = __('Plugin debug report', 'wbcr_factory_logger_149');

		add_action( 'wp_ajax_wbcr_factory_logger_149_'.$plugin->getPrefix().'logs_cleanup', [ $this, 'ajax_cleanup' ] );

		parent::__construct($plugin);
	}

	/**
	 * {@inheritdoc}
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function assets($scripts, $styles)
	{
		parent::assets($scripts, $styles);

		$this->styles->add(FACTORY_LOGGER_149_URL . '/assets/css/logger.css');
		$this->scripts->add(FACTORY_LOGGER_149_URL . '/assets/js/logger.js', ['jquery'], 'wbcr_factory_logger_149', FACTORY_LOGGER_149_VERSION);
		$this->scripts->localize('wbcr_factory_logger_149', [
			'clean_logs_nonce' => wp_create_nonce('wbcr_factory_logger_149_clean_logs'),
			'plugin_prefix' => $this->plugin->getPrefix(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMenuTitle()
	{
		return __('Plugin Log', 'wbcr_factory_logger_149');
	}

	/**
	 * {@inheritdoc}
	 */
	public function showPageContent()
	{
		$buttons = "
            <div class='btn-group'>
                <a href='" . wp_nonce_url( $this->getActionUrl( 'export' ), 'export-' . $this->plugin->getPluginName() ) . "'
                   class='button button-primary'>" . __('Export Debug Information', 'wbcr_factory_logger_149') . "</a>
                <a href='#'
                   class='button button-secondary'
                   onclick='wbcr_factory_logger_149_LogCleanup(this);return false;'
                   data-working='" . __('Working...', 'wbcr_factory_logger_149') . "'>" . sprintf(__('Clean-up Logs (<span id="wbcr-log-size">%s</span>)', 'wbcr_factory_logger_149'), $this->get_log_size_formatted()) . "
                   </a>
            </div>";
		?>
		<div class="wbcr-factory-page-group-header" style="margin-top:0;">
			<strong><?php _e('Plugin Log', 'wbcr_factory_logger_149') ?></strong>
			<p>
				<?php _e('In this section, you can track how the plugin works. Sending this log to the developer will help you resolve possible issues.', 'wbcr_factory_logger_149') ?>
			</p>
		</div>
		<div class="wbcr-factory-page-group-body" style="padding: 0 20px">
			<?php echo $buttons; ?>
			<div class="wbcr-log-viewer" id="wbcr-log-viewer">
				<?php echo $this->plugin->logger->prettify() ?>
			</div>
			<?php echo $buttons; ?>
		</div>
		<?php
	}

	public function ajax_cleanup()
	{
		check_admin_referer('wbcr_factory_logger_149_clean_logs', 'nonce');

		if( !current_user_can('manage_options') ) {
			wp_die(-1);
		}

		if( !$this->plugin->logger->clean_up() ) {
			wp_send_json_error([
				'message' => esc_html__('Failed to clean-up logs. Please try again later.', 'wbcr_factory_logger_149'),
				'type' => 'danger',
			]);
		}

		wp_send_json([
			'message' => esc_html__('Logs clean-up successfully', 'wbcr_factory_logger_149'),
			'type' => 'success',
		]);
	}

	/**
	 * Processing log export action in form of ZIP archive.
	 */
	public function exportAction()
	{
		if( !(isset( $_GET[ '_wpnonce' ] ) && wp_verify_nonce( $_GET[ '_wpnonce' ], 'export-' . $this->plugin->getPluginName() ))
		    || !$this->plugin->currentUserCan() ) {
			wp_die(__('You do not have sufficient permissions to perform this action!', 'wbcr_factory_logger_149'));
		}

		$export = new WBCR\Factory_Logger_149\Log_Export($this->plugin->logger);

		if( $export->prepare() ) {
			$export->download(true);
		}
	}

	/**
	 * Get log size formatted.
	 *
	 * @return false|string
	 */
	private function get_log_size_formatted()
	{

		try {
			return size_format($this->plugin->logger->get_total_size());
		} catch( \Exception $exception ) {
			$this->plugin->logger->error(sprintf('Failed to get total log size as exception was thrown: %s', $exception->getMessage()));
		}

		return '';
	}
}
