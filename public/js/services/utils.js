App.factory('utils', ['', function () {

    'use strict';

    function mergeObjects (a, b) {
        if (a && b && typeof a === 'object' && typeof b === 'object') {
            for (var f in a) {
                if (a.hasOwnProperty(f)) {
                    b[f] = a[f];
                }
            }
        }
    }

    // utils
    return {
        TipoDocumento: function (idTipoDocumento) {
            return 1;
        }
    };
}]);
