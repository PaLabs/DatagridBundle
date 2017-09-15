import Builder from './lib/Builder';

import EntityCollectionElement from './component/EntityCollectionElement';
import EntityCollection from './component/EntityCollection';
import ColumnsSelector from './component/ColumnsSelector';
import Filter from './component/Filter';


$(document).ready(function () {
    let components = [
        EntityCollectionElement,
        EntityCollection,
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