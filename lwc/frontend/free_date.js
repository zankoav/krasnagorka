import './common/common.scss'
import '@lwc/synthetic-shadow'
import { createElement } from 'lwc'
import FreeDate from 'fd/freeDate'

const appEl = createElement('fd-free-date', { is: FreeDate })
const freeDateWrapperEl = document.querySelector('.free-date-wrapper')
freeDateWrapperEl.appendChild(appEl)
