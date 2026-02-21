import './common/common.scss'
import { createElement } from 'lwc'
import EventApp from 'tab/eventApp'

const wrapper = document.currentScript.parentNode
const appEl = createElement('tab-event-app', { is: EventApp })
appEl.eventTabId = wrapper.getAttribute('data-event-tab')
appEl.eventId = wrapper.getAttribute('data-event')
wrapper.appendChild(appEl)
