import './common/common.scss'
import '@lwc/synthetic-shadow'
import { createElement, setHooks } from 'lwc'
import Admin from 'z/admin'

setHooks({
    sanitizeHtmlContent(content) {
        return content
    }
})

const appEl = createElement('z-admin', { is: Admin })
appEl.model = JSON.parse(model.replace(/\r\n/g, '\\n'))
document.body.appendChild(appEl)
