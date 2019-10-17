import { createElement } from 'lwc';
import Table from './../table';

describe('Frontend Component Table', () => {
    afterEach(() => {
        // The jsdom instance is shared across test cases in a single file so reset the DOM
        while (document.body.firstChild) {
            document.body.removeChild(document.body.firstChild);
        }
    });

    it('No @api columns', () => {
        const element = createElement('z-table', {
            is: Table
        });
        document.body.appendChild(element);

        // Get link
        const tableWrapper = element.shadowRoot.querySelector('div');
        expect(tableWrapper.className).toBe('table');
    });
});
