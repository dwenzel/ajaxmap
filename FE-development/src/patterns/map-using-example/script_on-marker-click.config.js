const fs = require('fs');

const onMarkerClickTemplate = function(mapEntry, place, $) {
    const treeNode = place.placeInstance.treeNode//has all domNodes

    treeNode.setSelected(true)

    var ulEl = treeNode.parent.ul;
    var liEl = treeNode.li;

    var $li = $(liEl);
    var $ul = $(ulEl);

    function scrollUL(li) {
        // scroll UL to make li visible
        // li can be the li element or its id
        if (typeof li !== "object") {
            li = document.getElementById(li);
        }
        var ul = li.parentNode;
        // fudge adjustment for borders effect on offsetHeight
        var fudge = 4;
        // bottom most position needed for viewing
        var bottom = (ul.scrollTop + (ul.offsetHeight - fudge) - li.offsetHeight);
        // top most position needed for viewing
        var top = ul.scrollTop + fudge;
        if (li.offsetTop <= top) {
            // move to top position if LI above it
            // use algebra to subtract fudge from both sides to solve for ul.scrollTop
            ul.scrollTop = li.offsetTop - fudge;
        } else if (li.offsetTop >= bottom) {
            // move to bottom position if LI below it
            // use algebra to subtract ((ul.offsetHeight - fudge) - li.offsetHeight) from both sides to solve for ul.scrollTop
            ul.scrollTop = li.offsetTop - ((ul.offsetHeight - fudge) - li.offsetHeight);
        }
    };

    scrollUL(liEl);

    return;


    liEl.scrollIntoView()
    /*
     var offset = $firstLi.position().top;
     var ulScrollTop= $li.position().top - offset;



     $ul.animate({
     scrollTop: $li.position().top
     }, 'slow');
     //   $ul.scrollTop(ulScrollTop);

     //$ul[0].style.display='none'
     console.log(ulEl,'****', ulScrollTop)
     */
}.toString();

const onMarkerClick = `function (){
    window.ajaxMapConfig = window.ajaxMapConfig|| {};
    window.ajaxMapConfig.onMarkerClick=${onMarkerClickTemplate};
}`;

module.exports = {
    context: {
        onMarkerClick: '<script>(' + onMarkerClick + ')()</script>'
    }
}
