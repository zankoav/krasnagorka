import { LightningElement, api, track } from 'lwc';
import './table.scss';

const CSS_CLASSES = {
    table: 'table',
    table_half: 'table table_half'
};
export default class Table extends LightningElement {
    _allRows;

    @track rows;
    @track tableClass = CSS_CLASSES.table;

    @api columns;
    @api
    set half(value) {
        this.tableClass = value ? CSS_CLASSES.table_half : CSS_CLASSES.table;
    }
    get half() {
        return this.tableClass;
    }
    @api
    set allRows(value) {
        this._allRows = value;
        this.rows = this._allRows.filter((item, index) => index < 100);
    }
    get allRows() {
        return this._allRows;
    }

    scrollTable(event) {
        const scrollTop = event.target.scrollTop;
        const scrollHeight = event.target.scrollHeight - 250;
        const scrollDiff = scrollTop / scrollHeight;
        if (scrollTop && scrollDiff > 0.8) {
            const rowLength = this.rows.length;
            const allRowLength = this._allRows.length;
            if (rowLength < allRowLength) {
                const deffNumber = allRowLength - rowLength;
                if (deffNumber < 200) {
                    this.rows = [...this._allRows];
                } else {
                    this.rows = this._allRows.filter(
                        (item, index) => index < this.rows.length + 200
                    );
                }
            }
        }
    }
}
