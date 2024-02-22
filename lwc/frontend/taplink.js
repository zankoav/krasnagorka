import './common/common.scss'
import '@lwc/synthetic-shadow'
import { createElement } from 'lwc'
import Taplink from 'tk/taplink'

const appEl = createElement('tk-taplink', { is: Taplink })
appEl.model = JSON.parse(model.replace(/\r\n/g, '\\n'))
document.body.appendChild(appEl)
