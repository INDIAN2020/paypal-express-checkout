<?php
/**
 * A PluginSkeleton osztállyal gyorsan hozhatunk létre WP plugin-t.
 * Használat:
 *  1, Másoljuk le a skeleton mappát és nevezzük át tetszés szerint
 *  2, Hozzuk létre a plugin-ünk .php file-ját és hozzuk létre a saját plugin objektumunkat a megfelelő paraméterekkel
 */
class PluginSkeleton {
	
	protected $pid, $tid, $plugin_path;
	
	/**
	 * Konstruktor, beállítjuk a szükséges változókat
	 * @param $pid: a plugin ID, ez lesz az URL-ben - pl.: options-general.php?page=test
	 * @param $tid: a plugin title, ez jelenik meg a menüben valamint a fejlécben a plugin adminban
	 * @param $menu: megadjuk, hogy milyen menüt hozzunk létre a pluginnak, alapértelmezésben nincs menü
	 *							 lehetséges opciók: AddMenu, AddSettingsSubMenu
	 */
	public function __construct( $pid, $tid, $menu = FALSE ) {
		$this->pid = $pid;
		$this->tid = $tid;
		$this->plugin_path = ABSPATH.'wp-content/plugins/'.$pid.'/';
		if ( $menu !== FALSE )
			add_action('admin_menu', array( $this, $menu ));
	}
	
	/**
	 * Fő menüpont létrehozása a pluginnek
	 */
	public function AddMenu() {
		add_menu_page( $this->tid, $this->tid, 'level_10', $this->pid, array( $this, 'PluginAdmin' ), '../wp-content/plugins/'.$this->pid.'/static/images/icon.png');
	}
	
	/**
	 * Almenüpont létrehozása a pluginnek a beállítások alatt
	 */
	public function AddSettingsSubMenu() {
		add_submenu_page( 'options-general.php', $this->tid, $this->tid, 'level_10', $this->pid, array( $this, 'PluginAdmin' ) ); 
	}
		
	/**
	 * Üres plugin admin metodus, ha szükséges írjuk felül
	 * ez a metodus hajtódik végre ha megnyitjuk az admin felületét a pluginnak
	 */
	public function PluginAdmin() {}
	
}