import './common/common.scss'
// import '@lwc/synthetic-shadow'
import { createElement } from 'lwc'
import EventApp from 'tab/eventApp'

const wrapper = document.querySelector('.accordion-mixed__content-inner')
const appEl = createElement('tab-event-app', { is: EventApp })
appEl.eventId = wrapper.getAttribute('data-event')
wrapper.appendChild(appEl)
