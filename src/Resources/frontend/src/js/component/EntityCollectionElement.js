import Component from '../lib/Component';
import Utils from '../lib/Utils';
import ComponentFinder from '../lib/ComponentFinder';
import EntityCollection from './EntityCollection';

export default class EntityCollectionElement extends Component {
    static get id() {
        return 'EntityCollectionElement';
    }

    init() {
        super.init();

        var parentComponent = ComponentFinder.parent(this.$node, 'entity_collection');
        var removeElementButton = Utils.single_element(this.$node, 'remove_element');
        removeElementButton.on('click', () => {
            parentComponent.trigger(EntityCollection.events.REMOVE_ELEMENT, this.$node);
        });
    }

}
