import {renderTreeAjax} from './tree-helpers'

function renderTree(mapEntry) {

    renderTreeAjax({
        select: '#ajaxMapCategoryTree' + mapEntry.id,
        action: "listCategories",
        mapId: mapEntry.id,
        settings: mapEntry.settings.categoryTree
    });
}

export default {
    renderTree
};

