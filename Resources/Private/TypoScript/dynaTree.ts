# dynaTree.ts
# include JavaScript for jQuery plugin DynaTree

page {
	includeJSFooterlibs {
		jQueryUi = EXT:ajaxmap/Resources/Public/JavaScript/Lib/jQuery/jquery-ui.custom.js
		jQueryCookie = EXT:ajaxmap/Resources/Public/JavaScript/Lib/jQuery/jquery.cookie.js
		dynaTree = EXT:ajaxmap/Resources/Public/Contrib/jquery.dynatree-1.2.6/jquery.dynatree.js
	}
	includeCSS {
		dynaTree = EXT:ajaxmap/Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/ui.dynatree.css
	}
}

plugin.tx_ajaxmap.settings {
	mapping {
		Webfox\Ajaxmap\Domain\Model\Category {
			uid = key
			description = tooltip
		}
		Webfox\Ajaxmap\Domain\Model\Region {
			uid = key
			regions = children
		}
		Webfox\Ajaxmap\Domain\Model\PlaceGroup {
			uid = key
			place_groups = place_groups
			categories = categories
			description = tooltip
		}

		Webfox\Ajaxmap\Domain\Model\LocationType {
			uid = key
			icon = markerIcon 
		}
	}
}
