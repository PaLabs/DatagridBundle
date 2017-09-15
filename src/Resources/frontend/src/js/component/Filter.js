import Component from '../lib/Component';
import Utils from '../lib/Utils';

export default class Filter extends Component {
    static get id() {
        return 'Filter';
    }

    init() {
        super.init();
        this.filterTable = Utils.single_element(this.$node, 'filter_table');
        this.fieldSelector = Utils.single_element(this.$node, 'field_selector');
        this.initHideButtons();

        var self = this;

        var hideButtons = Utils.single_element(this.$node, 'hide_filter_row');
        hideButtons.each(function (idx, hideButton) {
            $(hideButton).on('click', function () {
                var rowName = $(this).attr('data-field');
                self.hideRow(rowName);

            })
        });

        var displayButtons = this.fieldSelector.find('li');
        displayButtons.each(function (idx, displayButton) {
            $(displayButton).on('click', function () {
                var rowName = $(this).attr('data-field');
                self.revertRowVisibility(rowName);
            });
        })
    }

    initHideButtons() {
        this.$node.find('li[data-field]').each((idx, element) => {
            const fieldName = $(element).attr('data-field');
            const tableRow = this.filterTable.find(`tr[data-field='${fieldName}']`);
            const needDisplayTableRow = tableRow.attr('data-display');

            if (needDisplayTableRow) {
                Utils.single_element($(element), 'row_visibility').prop('checked', true);
            } else {
                Utils.single_element($(element), 'row_visibility').prop('checked', false);
                tableRow.find(":input").attr("disabled", true);
            }
        });
    }

    hideRow(rowName) {
        var tableRow = this.filterTable.find(`tr[data-field='${rowName}']`);
        tableRow.hide();
        tableRow.find(":input").attr("disabled", true);
        var rowSelector = this.fieldSelector.find(`li[data-field='${rowName}']`);
        Utils.single_element(rowSelector, 'row_visibility').prop('checked', false);
    }

    showRow(rowName) {
        var tableRow = this.filterTable.find(`tr[data-field='${rowName}']`);
        tableRow.find(":input").attr("disabled", false);
        tableRow.show();
        var rowSelector = this.fieldSelector.find(`li[data-field='${rowName}']`);
        Utils.single_element(rowSelector, 'row_visibility').prop('checked', true);
    }

    revertRowVisibility(rowName) {
        var tableRow = this.filterTable.find(`tr[data-field='${rowName}']`);
        if (tableRow.is(':visible')) {
            this.hideRow(rowName);
        } else {
            this.showRow(rowName);
        }
    }
}