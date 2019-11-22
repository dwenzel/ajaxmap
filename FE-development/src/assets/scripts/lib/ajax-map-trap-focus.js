/**
 * @author: EHO
 * @function: accessibiliy focus
 */

const KEYCODE_TAB = 9;

/**
 * trap focus
 * @param element
 * @param namespace
 */
export function trapFocus(element, namespace) {

    element.addEventListener('keydown', function(e) {
        let _sel = namespace || 'a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])',
            focusableEls = element.querySelectorAll(_sel),
            firstFocusableEl = focusableEls[0],
            lastFocusableEl = focusableEls[focusableEls.length - 1],
            isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

        if (!isTabPressed) {
            return;
        }

        if (e.shiftKey) /* shift + tab */ {
            if (document.activeElement === firstFocusableEl) {
                lastFocusableEl.focus();
                e.preventDefault();
            }
        } else /* tab */ {
            if (document.activeElement === lastFocusableEl) {
                firstFocusableEl.focus();
                e.preventDefault();
            }
        }
    });
}

/**
 * todo delete event
 * @param el
 */
export function deleteTrapFocus() {
    //el.removeEventListener('keydown', handler)
}

export default {
    trapFocus,
    deleteTrapFocus
};
