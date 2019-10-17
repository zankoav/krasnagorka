import { LightningElement, track, api } from 'lwc';
import './backups.scss';

export default class Backups extends LightningElement {
    @api backupsItems;

    @track isButtonOpen;

    _backupItem;

    toogleButton(event) {
        event.currentTarget.classList.toggle('button_success');
        this.isButtonOpen = !this.isButtonOpen;
        if (!this.isButtonOpen) {
            this._backupItem = null;
        }
    }

    selectBackupItem(event) {
        let items = this.template.querySelectorAll('.backups__item');
        let index = -1;
        items.forEach((element, inx) => {
            element.classList.remove('backups__item_current');
            if (element === event.currentTarget) {
                index = inx;
                event.currentTarget.classList.add('backups__item_current');
            }
        });
        if (index > -1) {
            this._backupItem = this.backupsItems[index];
            let buttonStart = this.template.querySelector('.backups__start');
            if (buttonStart) {
                buttonStart.classList.add(
                    'button_success',
                    'backups__start_open'
                );
            }
        }
    }

    async startRestore() {
        if (this._backupItem) {
            this.dispatchEvent(
                new CustomEvent('restore', {
                    detail: this._backupItem.value,
                    bubbles: true
                })
            );
        }
    }
}
