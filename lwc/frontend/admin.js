import './common/common.scss';
import '@lwc/synthetic-shadow';
import { createElement } from 'lwc';
import Admin from './components/admin/admin';

const appEl = createElement('z-admin', { is: Admin });
document.body.appendChild(appEl);
