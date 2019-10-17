import { LightningElement, track } from 'lwc';
import './updateOracle.scss';

const img = {
    download: require('./../../icons/download.svg')
};

export default class UpdateOracle extends LightningElement {
    @track img = img;
    @track updatingOracle;

    async updateOracle() {
        this.updatingOracle = true;
        let res = await fetch(`/admin/update-oracle`, {
            method: 'post',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            }
        })
            .then(result => result.json())
            .catch(error => {
                console.log('updateOracle', error);
                this.updatingOracle = false;
            });

        if (res) {
            console.log(res);
            this.updatingOracle = false;
        }
    }
}
