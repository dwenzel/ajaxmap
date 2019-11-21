/*
 * _______________
 * |       .-.   |
 * |      // ``  |
 * |     //      |
 * |  == ===-_.-'|
 * |   //  //    |
 * |__//_________|
 *
 * Copyright (c) ${YEAR} familie-redlich :systeme <systeme@familie-redlich.de>
 * @link     http://www.familie-redlich.de
 *
 *
 */

module.exports = {
    /**
     * Creates Icon Overview
     *
     * Add all icons placed in /assets/vectors
     */
    collated: true,
    collator: function(markup, item) {
        return `<!-- Start: @${item.handle} -->\n
        <div style="margin-bottom:20px;">
            <p style="margin-bottom:5px;">
                ${item.handle}
            </p>${markup}
        </div>\n<!-- End: @${item.handle} -->\n`
    },
    context: {
    },
    default: 'arrow',
    variants: [
        {
            name: 'arrow',
            context: {
                name: 'am-arrow'
            }
        },
        {
            name: 'cross',
            context: {
                name: 'am-cross'
            }
        },
        {
            name: 'marker',
            context: {
                name: 'am-marker'
            }
        },
        {
            name: 'search',
            context: {
                name: 'am-search'
            }
        },
        {
            name: 'target',
            context: {
                name: 'am-target'
            }
        }
    ]
};
