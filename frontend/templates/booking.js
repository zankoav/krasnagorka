// import './common/common.scss';
import '@lwc/synthetic-shadow';
import { createElement } from 'lwc';
import Booking from './../components/booking/booking';

const appEl = createElement('z-admin', { is: Booking });
document.body.appendChild(appEl);
