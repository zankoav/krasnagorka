import './common/common.scss'
import { createElement, setHooks } from 'lwc'
import FreeDate from 'fd/freeDate'

setHooks({
    sanitizeHtmlContent(content) {
        return content
    }
})

const appEl = createElement('fd-free-date', { is: FreeDate })
const freeDateWrapperEl = document.querySelector('.free-date-wrapper')
if (freeDateWrapperEl) {
    freeDateWrapperEl.appendChild(appEl)
}
