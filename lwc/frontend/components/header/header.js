/* eslint-disable @lwc/lwc/no-async-operation */
import { LightningElement, api, track } from 'lwc';
import './header.scss';

const imgs = {
    logo: require('./../../icons/fleetcor-logo.png')
};

export default class Header extends LightningElement {
    imgs = imgs;

    @track _showLogout;

    @api set showLogout(value) {
        this._showLogout = value;
    }
    get showLogout() {
        return this._showLogout;
    }

    // async logoutUser() {
    //     let responce = await fetch('/admin/logout');
    //     let result = await responce.json();
    //     if (result.status) {
    //         this.dispatchEvent(
    //             new CustomEvent('userlogout', { bubbles: true })
    //         );
    //     }
    // }

    showMenu() {
        console.log('Toogle Menu');
    }
}
