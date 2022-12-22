//VERSION - 1.0

/* eslint-disable no-console */
import { api, LightningElement } from 'lwc'
import { UTILS } from 'core/utils'
import './tooltip.scss' // from WEBPACK loader 'form.js' {!!!theme}

const VARIABLES = {
    ARROW_SIZE: 8,
    PADDING_SIZE: 4
}

const VARIANTS = {
    SMALL: 'small',
    LARGE: 'large'
}

const CLASSES = {
    ARROW: '.tooltip__arrow',
    CONTENT: '.tooltip__content'
}

export default class Tooltip extends LightningElement {
    static renderMode = 'light'
    content
    elementTooltip
    arrowElement

    @api value
    @api variant
    @api maxWidth = 300
    @api minWidth = 100
    @api whiteBackground

    renderedCallback() {
        this.elementTooltip = this.querySelector('.tooltip')
        this.arrowElement = this.querySelector(CLASSES.ARROW)
        this.content = this.querySelector(CLASSES.CONTENT)
        this.content.innerHTML = this.value
    }

    handleMouseOver(event) {
        this.stopEvent(event)
        this.setPosition()
    }

    handleClick(event) {
        this.stopEvent(event)
        this.setPosition()
    }

    setPosition() {
        let elementTooltipRect = this.elementTooltip.getBoundingClientRect()
        let elementRight =
            document.documentElement.clientWidth -
            elementTooltipRect.left -
            this.elementTooltip.offsetWidth
        let screenWidth = window.screen.width - VARIABLES.PADDING_SIZE
        let minWidth =
            this.content.offsetWidth < this.minWidth ? this.minWidth : this.content.offsetWidth
        let maxWidth = screenWidth < this.maxWidth ? screenWidth : this.maxWidth
        minWidth = minWidth < maxWidth ? minWidth : maxWidth
        this.content.style.minWidth = `${minWidth}px`
        this.content.style.maxWidth = `${maxWidth}px`

        const INITIAL_CONTENT_WIDTH = this.content.offsetWidth
        const INITIAL_CONTENT_HEIGHT = this.content.offsetHeight

        // top or bottom
        if (elementTooltipRect.top - VARIABLES.ARROW_SIZE * 2 >= this.content.offsetHeight) {
            this.content.style.top =
                this.elementTooltip.offsetTop -
                this.content.offsetHeight -
                VARIABLES.ARROW_SIZE * 2 +
                'px'
            this.arrowElement.style.top =
                this.elementTooltip.offsetTop -
                this.arrowElement.offsetHeight / 2 -
                VARIABLES.ARROW_SIZE +
                'px'
            this.arrowElement.style.left =
                this.elementTooltip.offsetLeft +
                this.elementTooltip.offsetWidth / 2 -
                this.arrowElement.offsetWidth / 2 +
                'px'
            this.arrowElement.style.border = VARIABLES.ARROW_SIZE + 'px solid transparent'
            this.arrowElement.style.borderTop = VARIABLES.ARROW_SIZE + 'px solid #FFFFFF'
        } else {
            this.content.style.top =
                this.elementTooltip.offsetTop +
                this.elementTooltip.offsetHeight +
                VARIABLES.ARROW_SIZE * 2 +
                'px'
            this.arrowElement.style.top =
                this.elementTooltip.offsetTop +
                this.elementTooltip.offsetHeight +
                VARIABLES.ARROW_SIZE -
                this.arrowElement.offsetHeight / 2 +
                'px'
            this.arrowElement.style.left =
                this.elementTooltip.offsetLeft +
                this.elementTooltip.offsetWidth / 2 -
                this.arrowElement.offsetWidth / 2 +
                'px'
            this.arrowElement.style.border = VARIABLES.ARROW_SIZE + 'px solid transparent'
            this.arrowElement.style.borderBottom = VARIABLES.ARROW_SIZE + 'px solid #FFFFFF'
        }

        // left-right alignment
        if (elementTooltipRect.left < this.content.offsetWidth / 2) {
            this.content.style.left = VARIABLES.PADDING_SIZE + 'px'
        } else if (elementRight < this.content.offsetWidth / 2) {
            this.content.style.right = VARIABLES.PADDING_SIZE + 'px'
            this.content.style.right = VARIABLES.PADDING_SIZE + 'px'
            this.content.style.left = 'auto'
        } else {
            this.content.style.left =
                this.elementTooltip.offsetLeft +
                this.elementTooltip.offsetWidth / 2 -
                this.content.offsetWidth / 2 +
                'px'
        }

        if (
            INITIAL_CONTENT_HEIGHT !== this.content.offsetHeight ||
            INITIAL_CONTENT_WIDTH !== this.content.offsetWidth
        ) {
            this.setPosition()
        }
    }

    stopEvent(event) {
        event.stopImmediatePropagation()
    }

    get computedElementClass() {
        return UTILS.configToString({
            tooltip: true,
            tooltip_small: this.normalizedVariant === VARIANTS.SMALL,
            tooltip_large: this.normalizedVariant === VARIANTS.LARGE,
            'tooltip__button-unfocused': UTILS.normalizeBoolean(this.whiteBackground)
        })
    }

    get normalizedVariant() {
        return UTILS.normalizeString(this.variant, {
            fallbackValue: VARIANTS.SMALL,
            validValues: [VARIANTS.LARGE, VARIANTS.SMALL]
        })
    }
}
