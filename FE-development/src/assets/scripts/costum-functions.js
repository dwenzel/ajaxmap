import $ from 'jquery';

const customMapFunctions = {
    onMarkerClick: function(mapEntry, place) {

        const treeNode = place.placeInstance.treeNode; // has all domNodes
        let topPosition = $(treeNode.li).position().top,
            listWrapper = $(treeNode.li).closest('.am__sb__scroll-wrapper__inner');

        treeNode.setSelected(true);
        $(listWrapper).animate({scrollTop: topPosition}, 600);
    },
    placeSortFunction: function(a, b) {
        let valA = a.data.distance;
        let valB = b.data.distance;

        if (!valA && !valB) {
            valA = a.data.placeInstance.placeData.title;
            valB = b.data.placeInstance.placeData.title;
        }

        return valA > valB ? 1 : valA < valB ? -1 : 0;
    },

    renderPlaceTreesItemFunction: function(placeInstance) {

        var placeData = placeInstance.placeData;
        var title = placeData.title;

        return `<div class="am-card">
    <!-- logo or profile image todo @EHO default image for profile or company-->
    <div class="am-card__img is-outlined">
        <img src="${placeData.address.firstImage}" alt="${placeData.address.fullName}">
    </div>
    <div class="am-card__copy">
        <header class="am-card__copy__head">
            <h3 class="am-card__title u-typo:m u-typo:bold">${title}</h3>
            <span class="am-card__subtitle">${placeData.locationType.title}</span>
        </header>

        <address class="am-card__info am-card__info--w-icon">
            <i class="o-icon-font o-icon-font--consultant" aria-hidden="true"></i>
            <span>${placeData.address.address}</span><br>
            <span>${placeData.address.zip} ${placeData.address.city}</span>
        </address>
        <a href="${placeData.address.profileLink}" target='_blank' class="am-card__detail-link c-link u-icon u-icon:left u-icon--triangle-right">
            zum Profil
        </a>
    </div>

    <!--a href="${placeData.address.profileLink}" class="am-card__block-link js-am-jt-marker">Anchor map</a-->
</div>
`;
    }
};

export default () => {

    window.ajaxMapConfig = window.ajaxMapConfig || {};

    window.ajaxMapConfig.onMarkerClick = customMapFunctions.onMarkerClick;

    window.ajaxMapConfig.placeSortFunction = customMapFunctions.placeSortFunction;

    window.ajaxMapConfig.renderPlaceTreesItem = customMapFunctions.renderPlaceTreesItemFunction;
};
