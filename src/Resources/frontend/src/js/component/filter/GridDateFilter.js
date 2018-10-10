import Component from "../../lib/Component";
import Utils from "../../lib/Utils";

export default class GridDateFilter extends Component {
    static get id() {
        return 'GridDateFilter';
    }

    init() {
        super.init();
        this.typeSelector = Utils.single_element(this.$node, 'type_selector');
        this.dates = Utils.single_element(this.$node, 'dates');

        this._processType();

        this.typeSelector.on('change', (e) => {
            this._processType();
        });
    }

    _processType() {
        const optionValue = this.typeSelector.find('option:selected').val();
        switch (optionValue) {
            case 'cd':
            case 'cy':
                this.dates.hide();
                break;
            default:
                this.dates.show();
                break;
        }
    }

}