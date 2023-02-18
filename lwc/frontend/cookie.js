import './common/common.scss'
import { createElement } from 'lwc'
import Cookie from 'ut/cookie'

const appEl = createElement('ut-cookie', { is: Cookie })
document.body.appendChild(appEl)
