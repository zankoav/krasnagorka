import './../common/common.scss';
import '@lwc/synthetic-shadow';
import { createElement } from 'lwc';
import AppComponent from 'c/loader';

const appTemplate = createElement(`c-app`, { is: AppComponent });
document.querySelector('#app').appendChild(appTemplate);
