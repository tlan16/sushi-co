<?php
/**
 * Menu template
 *
 * @package    Web
 * @subpackage Layout
 * @author     lhe
 */
class Menu extends TTemplateControl
{
    /**
     * (non-PHPdoc)
     * @see TControl::onLoad()
     */
	public function onLoad($param)
	{
	}
	public function getMenuItems()
	{
		$pageItem = trim($this->getPage()->menuItem);
		$array = array(
// 			'' => array('url' => '/', 'name' => 'Products', 'icon' => '<span class="glyphicon glyphicon-home"></span>')
	        'categories' => array('url' => '/categories.html', 'name' => 'Category', 'icon' => '<span class="glyphicon glyphicon-tasks"></span>'),
			'product' => array(
				'name' => 'Products',
				'url' => '/products.html',
				'icon' => '<span class="glyphicon glyphicon-tag"></span>'
			)
		);
		if (AccessControl::canAccessResourcePage(Core::getRole()) === true) {
		    $array['Resources'] = array(
				'icon' => '<span class="glyphicon glyphicon-th-list"></span>'
				,'ingredients' => array('url' => '/ingredients.html', 'name' => 'Ingredients', 'icon' => '')
				,'allergents' => array('url' => '/allergents.html', 'name' => 'Allergents', 'icon' => '')
				,'nutritions' => array('url' => '/nutritions.html', 'name' => 'Nutritions', 'icon' => '')
				,'servemeasurements' => array('url' => '/servemeasurements.html', 'name' => 'Serve Measurements', 'icon' => '')
// 				,'labels' => array('url' => '/labels.html', 'name' => 'Labels', 'icon' => '')
				,'materials' => array('url' => '/materials.html', 'name' => 'Materials', 'icon' => '')
// 				,'addresses' => array('url' => '/addresses.html', 'name' => 'Addresses', 'icon' => '')
				,'rawmaterial' => array('url' => '/rawmaterials.html', 'name' => 'Raw Materials', 'icon' => '')
			);
		}
		if (AccessControl::isStoreAdmin(Core::getRole()) === true) {
  		$array['stocktake'] = array(
  		        'name' => 'Stocktake',
  		        'url' => '/stocktake.html?view=stocktake',
  		        'icon' => '<span class="glyphicon glyphicon-tag"></span>'
  		);
  		$array['placeorder'] = array(
  		        'name' => 'Place Order',
  		        'url' => '/restock.html?view=placeorder',
  		        'icon' => '<span class="glyphicon glyphicon-shopping-cart"></span>'
  		);
		}
		if (AccessControl::canAccessUserPage(Core::getRole()) === true) {
    		$array['System'] = array(
				'icon' => '<span class="glyphicon glyphicon-cog"></span>'
				,'useraccounts' => array('url' => '/useraccounts.html', 'name' => 'User Accounts', 'icon' => '')
				,'stores' => array('url' => '/stores.html', 'name' => 'Stores', 'icon' => '')
				,'messages' => array('url' => '/messages.html', 'name' => 'Messages', 'icon' => '')
				,'systemsettings' => array('url' => '/systemsettings.html', 'name' => 'System Settings', 'icon' => '')
			);
		}
		$array['help'] = array(
			'name' => 'Help',
			'url' => '/help.html',
			'icon' => '<span class="glyphicon glyphicon-info-sign"></span>'
		);
		$html = "<ul class='nav navbar-nav'>";
			foreach ($array as $key => $item) {
				$hasNextLevel = !isset($item['name']) && is_array($item) && count($item) > 0;
				$activeClass = ($pageItem === $key || array_key_exists($pageItem, $item) ? 'active' : '');
				$html .= "<li class='" . $activeClass . " visible-xs visible-sm visible-md visible-lg'>";
				$html .= "<a href='" . ($hasNextLevel === true ? '#' : $item['url']) . "' " . ($hasNextLevel === true ? 'class="dropdown-toggle" data-toggle="dropdown"' : '') . ">";
					$html .= (isset($item['icon']) ? $item['icon'] . ' ' : '') . ($hasNextLevel === true ? $key .'<span class="caret"></span>' : $item['name']);
				$html .= "</a>";
					if ($hasNextLevel === true) {
						$html .= "<ul class='dropdown-menu'>";
						foreach ($item as $k => $i) {
							if(is_string($i) || !isset($i['url']))
								continue;
							$html .= "<li class='" . ($pageItem === $k ? 'active' : '') . "'><a href='" . $i['url'] . "'>" . (isset($i['icon']) ? $i['icon'] . ' ' : '') .$i['name'] . "</a></li>";
						}
						$html .= "</ul>";
					}
				$html .= "</li>";
			}
		$html .= "</ul>";
		return $html;
	}
}
?>
