import Builder from './lib/Builder';

import OrderCollectionElement from './component/OrderCollectionElement';
import OrderCollection from './component/OrderCollection';
import ColumnsSelector from './component/ColumnsSelector';
import Filter from './component/Filter';


$(document).ready(function () {
    let components = [
        OrderCollectionElement,
        OrderCollection,
        ColumnsSelector,
        Filter
    ];

    let builder = new Builder(components);
    builder
        .bootstrap({
            afterComponentCreated: function (node) {
                node.attr('data-initialization-state', 'complete');
            }
        })
        .init($(document.body));
});