/* eslint-disable no-console */
import { LightningElement, api, track } from 'lwc';
import './content.scss';

const imgs = {
    xlsx: require('./../../icons/xlsx.svg'),
    success: require('./../../icons/success.svg'),
    error: require('./../../icons/error.svg'),
    salesforce: require('./../../icons/salesforce.svg')
};

const MIME_TYPE =
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

const ERROR_MESSAGE_TITLE_VALIDATE =
    'Invalid Format! Different title in columns';
const ERROR_MESSAGE_DUPLICATES = 'Invalid Stations! Duplicates ESI in country';
export default class Content extends LightningElement {
    @track currentVersion;
    @track errorMessage = ERROR_MESSAGE_TITLE_VALIDATE;
    @track spinnerText = 'loading...';
    @track version;
    @track isUpdate;
    @track imgs = imgs;
    @track file;
    @track isLoading = true;
    @track actualColumns;
    @track actualData;
    @track countCurrentStations;
    @track previewRows;
    @track previewColumns;
    @track countCurrentStations;
    @track isValid = false;
    filesElement;

    @api setSuccessUpdateDBMessage() {
        this.isUpdate = true;
    }

    async connectedCallback() {
        let responce = await fetch(`/admin/stations/`).catch(error =>
            console.log(error)
        );
        if (responce.status === 200) {
            let result = await responce.json();

            const validate = result.validate;
            if (!validate) {
                document.location.reload(true);
            }
            const version = result.version;
            if (version) {
                this.currentVersion = version.title;
                this.actualData = result.stations;
                this.countCurrentStations = this.actualData.length;
                this.actualColumns = result.columns;
            }
        }
        this.isLoading = false;
    }

    renderedCallback() {
        this.filesElement = this.template.querySelector('[name="xlsxFile"]');
    }

    @api
    async previewBackUp(versionId) {
        this.isLoading = true;
        let responce = await fetch('/admin/preview-restore', {
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            method: 'post',
            body: JSON.stringify({
                versionId: versionId
            })
        });
        let result = await responce.json();
        if (!result.sessionValid) {
            document.location.reload(true);
        } else {
            if (result.status) {
                this.previewRows = result.stations;
                this.countStations = this.previewRows.length;
                this.previewColumns = result.columns;
                this.isValid = true;
                this.restore = versionId;
            }
            this.isLoading = false;
        }
    }

    chooseFile() {
        if (this.filesElement) {
            this.filesElement.click();
        }
    }

    xlsxChange() {
        this.file = this.filesElement.files[0];
    }

    previewXLSX() {
        this.isUpdate = false;
        if (this.file.type) {
            if (MIME_TYPE.indexOf(this.file.type) === -1) {
                console.log('format error');
            }

            const data = new FormData();
            const request = new XMLHttpRequest();
            request.responseType = 'json';

            request.upload.addEventListener('progress', e => {
                const percent_complete = (e.loaded / e.total) * 100;
                console.log(percent_complete + '%');
            });

            request.addEventListener('load', () => {
                const result = request.response;
                if (!result.sessionValid) {
                    document.location.reload(true);
                } else {
                    this.previewRows = result.stations;
                    if (result.duplicate) {
                        this.errorMessage = ERROR_MESSAGE_DUPLICATES;
                    }
                    this.isValid = result.validate;
                    this.countStations = this.previewRows.length;
                    this.previewColumns = result.columns;
                    this.restore = false;
                    this.file = null;
                    this.isLoading = false;
                }
            });

            this.isLoading = true;
            this.spinnerText = 'uploading file...';
            data.append('xlsxFile', this.file);
            request.open('post', '/admin/upload-xlsx');
            request.send(data);
        }
    }

    closePreview() {
        this.errorMessage = ERROR_MESSAGE_TITLE_VALIDATE;
        this.previewColumns = null;
        this.previewRows = null;
    }

    async updateDataBase() {
        this.dispatchEvent(
            new CustomEvent('updatedatabase', {
                detail: {
                    restoreId: this.restore,
                    stations: this.previewRows
                }
            })
        );
    }

    filterOnlyESI() {
        this.previewRows = this.previewRows.filter(
            item => item.value[44].value
        );
        this.countStations = this.previewRows.length;
    }

    updateSalesforce() {
        this.dispatchEvent(new CustomEvent('salseforceupdate'));
    }
}
