# dynaTree.ts
# include JavaScript for jQuery plugin DynaTree

page {
	includeJSFooterlibs {
		jQueryUi = EXT:ajaxmap/Resources/Public/JavaScript/Lib/jQuery-1.10/jquery-ui.custom.js
		jQueryCookie = EXT:ajaxmap/Resources/Public/JavaScript/Lib/jQuery-1.10/jquery.cookie.js
		fancyTree = EXT:ajaxmap/Resources/Public/Contrib/jquery.fancytree-2.9.0/jquery.fancytree-all.js
		fancyTreeFilter = EXT:ajaxmap/Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.filter.js
	}
	includeCSS {
		fancyTree = EXT:ajaxmap/Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/ui.fancytree.css
	}
}

plugin.tx_ajaxmap.settings {
	mapping {
		Webfox\Ajaxmap\Domain\Model\Map {
			categories.exclude = 1
			pid.exclude = 1
			placeGroups.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\Category {
			pid.exclude = 1
			uid.mapTo = key
		}
		Webfox\Ajaxmap\Domain\Model\Region {
			uid.mapTo = key
			regions {
				mapTo = children
				maxDept = 5
			}
			pid.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\Place {
			uid.mapTo = key
			description.mapTo = tooltip
			pid.exclude = 1
			info.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\PlaceGroup {
			uid.mapTo = key
			description.mapTo = tooltip
			pid.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\LocationType {
			uid.mapTo = key
			icon.mapTo = markerIcon
			pid.exclude = 1
		}
	}
	// mapping for ajaxListPlaces action
	mapping.listPlaces {
		Webfox\Ajaxmap\Domain\Model\Category {
			uid.mapTo = key
			pid.exclude = 1
			//title.exclude = 1
			description.exclude = 1
			icon.exclude = 1
			parent.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\Region {
			uid.mapTo = key
			regions {
				maxDept = 1
			}
			pid.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\Place {
			uid.mapTo = key
			description.mapTo = tooltip
			pid.exclude = 1
			info.exclude = 1
			content.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\PlaceGroup {
			uid.mapTo = key
			description.exclude = 1
			pid.exclude = 1
			title.exclude = 1
			parent.exclude = 1
			icon.exclude = 1
		}
		Webfox\Ajaxmap\Domain\Model\LocationType {
			uid.mapTo = key
			description.exclude = 1
			icon.exclude = 1
			pid.exclude = 1
			title.exclude = 1
		}
	}
}
