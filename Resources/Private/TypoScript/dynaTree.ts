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
		tx_ajaxmap_domain_model_category {
			description = tooltip
		}
}
