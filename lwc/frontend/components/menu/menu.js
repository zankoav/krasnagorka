/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import {LightningElement, track, api} from 'lwc';
import './menu.scss';

import ONLINE_VIDEO from './../../icons/online-video.svg';
import MENU_ICON from './../../icons/menu-icon.svg';
import PHONE_ICON from './../../icons/contacts-icon.svg';
import CLOSE_ICON from './../../icons/menu-close.svg';

const MENU_NAVIGATION_CSS = 'menu__navigation-list-wrapper';
const MENU_NAVIGATION_ACTIVE_CSS = 'menu__navigation-list-wrapper menu__navigation-list-wrapper_active';

export default class Menu extends LightningElement {

    @api model;

    @track menuCss = MENU_NAVIGATION_CSS;
    @track contactsPopupIsOpen;
    @track isVideoLoaded;
    @track videoOpened;
    @track icons = {
        onlineVideo: ONLINE_VIDEO,
        menuIcon: MENU_ICON,
        phone: PHONE_ICON,
        closeIcon: CLOSE_ICON,
    };

    showVideo() {
        this.videoOpened = true;
    }

    videoLoaded(){
        console.log('isVideoLoaded');
        this.isVideoLoaded = true;
    }

    closeOnlineVideo(){
        this.videoOpened = false;
    }

    showMenu() {
        this.menuCss = MENU_NAVIGATION_ACTIVE_CSS;
    }

    hideMenu() {
        this.menuCss = MENU_NAVIGATION_CSS;
    }

    toggleContacts() {
        this.contactsPopupIsOpen = !this.contactsPopupIsOpen;

    }
}
