/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, track } from 'lwc';
import './admin.scss';

export default class Admin extends LightningElement {
    @track backupVersions;
    @track spinnerText = 'loading...';
    @track isLoginUser;
    @track isLoading = true;

    spinnerEnd() {
        this.isLoading = false;
    }

    spinnerStart() {
        this.isLoading = true;
    }

    async connectedCallback() {
        let responce = await fetch('/admin/islogin');
        let result = await responce.json();
        if (result.status) {
            this.loadVersions();
        } else {
            this.isLoading = false;
        }
    }

    async loadVersions() {
        let versionsResponce = await fetch('/admin/versions');
        let result = await versionsResponce.json();
        if (result.validate) {
            this.backupVersions = result.versions;
            this.isLoading = false;
            this.isLoginUser = true;
        } else {
            document.location.reload(true);
        }
    }

    async checkStatus() {
        this.spinnerText = `updating locator database...`;
        let responce = await fetch('/admin/check-status');
        let result = await responce.json();
        if (result.oracleUpdating) {
            setTimeout(() => {
                this.checkStatus();
            }, 1000);
        } else {
            this.loadVersions();
        }
    }

    async startRestore(event) {
        const version = event.detail;
        this.template.querySelector('z-content').previewBackUp(version);
    }

    async updateDataBase(event) {
        this.isLoading = true;
        this.spinnerText = 'uploading 0%';
        const restoreId = event.detail.restoreId;
        let stations = event.detail.stations;

        const size = 1000;
        let index = 0;
        const total = stations.length;
        sendDataPartOfStations.bind(this)();

        function sendDataPartOfStations() {
            let stationsPart;
            let isLast;
            if (index < total) {
                stationsPart = stations.slice(index, (index += size));
            } else {
                stationsPart = stations.slice(index, stations.length);
                isLast = true;
            }

            fetch(`/admin/update-data-base`, {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    stations: stationsPart,
                    restoreId: restoreId,
                    isLast: isLast
                })
            })
                .then(responce => responce.json())
                .then(result => {
                    if (!result.sessionValid) {
                        document.location.reload(true);
                    } else {
                        let percent = parseInt(
                            (result.uploaded * 100) / total,
                            10
                        );
                        this.spinnerText = `uploading ${percent}%`;
                        if (!result.status) {
                            sendDataPartOfStations.bind(this)();
                        } else {
                            this.checkStatus();
                        }
                    }
                });
        }
    }

    loginSuccessHandler() {
        this.isLoginUser = true;
        this.loadVersions();
    }

    userLogoutHandler() {
        this.isLoginUser = false;
    }

    async updateSalesforce() {
        this.isLoading = true;
        this.spinnerText = 'Salesforce accounts updating...';
        let responce = await fetch(`/admin/update-salesforce`, {
            method: 'post',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({})
        });
        let result = await responce.json();
        console.log(result);
        this.isLoading = false;
    }
}
