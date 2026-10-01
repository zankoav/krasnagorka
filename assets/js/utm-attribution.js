(function () {
    'use strict';

    var STORAGE_KEY = 'kg_attribution';
    var KEYS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'gclid',
        'gbraid',
        'wbraid'
    ];
    var MAX_VALUE_LENGTH = 500;

    function readStoredAttribution() {
        try {
            return JSON.parse(window.localStorage.getItem(STORAGE_KEY) || '{}') || {};
        } catch (error) {
            return {};
        }
    }

    function readUrlAttribution() {
        var params = new URLSearchParams(window.location.search);
        var values = {};

        KEYS.forEach(function (key) {
            var value = params.get(key);

            if (value && value.trim()) {
                values[key] = value.trim().slice(0, MAX_VALUE_LENGTH);
            }
        });

        return values;
    }

    function saveAttribution(values) {
        if (!Object.keys(values).length) {
            return;
        }

        var attribution = readStoredAttribution();
        attribution.first = attribution.first || {};
        attribution.last = attribution.last || {};

        Object.keys(values).forEach(function (key) {
            if (!attribution.first[key]) {
                attribution.first[key] = values[key];
            }

            attribution.last[key] = values[key];
        });

        attribution.landing_page = attribution.landing_page || window.location.href;
        attribution.first_visit_at = attribution.first_visit_at || new Date().toISOString();
        attribution.last_visit_at = new Date().toISOString();

        try {
            window.localStorage.setItem(STORAGE_KEY, JSON.stringify(attribution));
        } catch (error) {
            // The booking flow must keep working when browser storage is unavailable.
        }
    }

    saveAttribution(readUrlAttribution());

    window.KGAttribution = {
        get: readStoredAttribution
    };
})();
