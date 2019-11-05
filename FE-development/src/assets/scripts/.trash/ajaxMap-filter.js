import {renderTreeAjax} from './helpers'

const _ = {
    renderCategoryTree: (mapEntry) => {

        renderTreeAjax({
            select: '#ajaxMapCategoryTree' + mapEntry.id,
            action: "listCategories",
            mapId: mapEntry.id,
            settings: mapEntry.settings.categoryTree
        });
    }
}

const categorys = {
    renderCategoryTree:_.renderCategoryTree
};

export default categorys;
