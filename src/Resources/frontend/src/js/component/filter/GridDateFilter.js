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
            case 'OPERATOR_CURRENT_DAY':
            case 'OPERATOR_YESTERDAY':
            case 'OPERATOR_CURRENT_WEEK':
            case 'OPERATOR_CURRENT_YEAR':
                this._expandOperator();
                break;
            default:
                this._collapseOperator();
                break;
        }
    }

    _expandOperator() {
        this.dates.hide();
        this.typeSelector.removeClass('col-md-3').addClass('col-md-12');
    }

    _collapseOperator() {
        this.dates.show();
        this.typeSelector.removeClass('col-md-12').addClass('col-md-3');
    }

}