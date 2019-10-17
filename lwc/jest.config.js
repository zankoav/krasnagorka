const { jestConfig } = require('@salesforce/lwc-jest/config');
// console.log('process', process);
let collectCoverageFrom = [];
if (process.argv.indexOf('frontend') > -1) {
    collectCoverageFrom.push('**/frontend/**/*.{js,jsx}');
} else if (process.argv.indexOf('backend') > -1) {
    collectCoverageFrom.push('**/backend/**/*.{js,jsx}');
} else if (process.argv.indexOf('fullCoverage') > -1) {
    collectCoverageFrom.push('**/backend/**/*.{js,jsx}');
    collectCoverageFrom.push('**/frontend/**/*.{js,jsx}');
}
module.exports = {
    ...jestConfig,
    moduleNameMapper: {
        '^.+\\.(css|less|scss)$': 'identity-obj-proxy'
    },
    collectCoverageFrom: collectCoverageFrom
};
