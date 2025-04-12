/* global woodmartConfig, woodmartAdminModule */
function updateConditions(ruleRow) {
	let dateTypeSelect = ruleRow.querySelector('.xts-condition-date-type select');
	let removeRowBtn   = ruleRow.querySelector('.xts-close .xts-remove-item');

	dateTypeSelect.addEventListener( 'change', function(e) {
		if ( 'single' === dateTypeSelect.value ) {
			ruleRow.querySelector('.xts-condition-day-single').classList.remove('xts-hidden');

			ruleRow.querySelector('.xts-condition-day-first').classList.add('xts-hidden');
			ruleRow.querySelector('.xts-condition-day-last').classList.add('xts-hidden');
		} else if ( 'period' === dateTypeSelect.value ) {
			ruleRow.querySelector('.xts-condition-day-single').classList.add('xts-hidden');
			ruleRow.querySelector('.xts-condition-empty').classList.add('xts-hidden');

			ruleRow.querySelector('.xts-condition-day-first').classList.remove('xts-hidden');
			ruleRow.querySelector('.xts-condition-day-last').classList.remove('xts-hidden');
		}

		let allFirstDayInputs = ruleRow.parentNode.querySelectorAll('.xts-table-controls:not(.xts-table-heading) .xts-condition-day-first:not(.xts-hidden)');
		let allSingeDayInputs = ruleRow.parentNode.querySelectorAll('.xts-table-controls:not(.xts-table-heading) .xts-condition-day-single:not(.xts-hidden)');

		if ( allFirstDayInputs.length > 0 ) {
			allSingeDayInputs.forEach(function (singleDayRow) {
				singleDayRow.parentNode.querySelector('.xts-condition-empty').classList.remove('xts-hidden');
			});
		} else {
			allSingeDayInputs.forEach(function (singleDayRow) {
				singleDayRow.parentNode.querySelector('.xts-condition-empty').classList.add('xts-hidden');
			});
		}
	});

	removeRowBtn.addEventListener( 'click', function(e) {
		e.preventDefault();

		let allFirstDayInputs = ruleRow.parentNode.querySelectorAll('.xts-table-controls:not(.xts-table-heading) .xts-condition-day-first:not(.xts-hidden)');
		let allSingeDayInputs = ruleRow.parentNode.querySelectorAll('.xts-table-controls:not(.xts-table-heading) .xts-condition-day-single:not(.xts-hidden)');

		let isSingleRow = this.closest('.xts-table-controls').querySelector('.xts-condition-day-single:not(.xts-hidden)');

		if ( ! isSingleRow && allFirstDayInputs.length === 1 ) {
			allSingeDayInputs.forEach(function (singleDayRow) {
				singleDayRow.parentNode.querySelector('.xts-condition-empty').classList.add('xts-hidden');
			});
		}
	});
}

function validate() {
    let isValid = true;
    let timetable = jQuery('.xts-timetable-control');
    let ruleRows = document.querySelectorAll('.xts-timetable-control .xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');	

    if (ruleRows.length === 0) {
        woodmartAdminModule.woodmartAdmin.addNotice(timetable, 'warning', woodmartConfig.no_rows_msg);
        isValid = false;
    }

    ruleRows.forEach((ruleRow) => {
        let dateType = ruleRow.querySelector('select.xts-condition-date-type').value;

        if (dateType === 'single') {
            return;
        }

		let dayFirst = ruleRow.querySelector('.xts-condition-day-first input').value;
		let dayLast = ruleRow.querySelector('.xts-condition-day-last input').value;

		if ( ( ! dayFirst && dayLast ) || ( dayFirst && ! dayLast ) ) {
			woodmartAdminModule.woodmartAdmin.addNotice(timetable, 'warning', woodmartConfig.empty_date_field_msg);
            isValid = false;
		}

        if (new Date(dayFirst) > new Date(dayLast)) {
            woodmartAdminModule.woodmartAdmin.addNotice(timetable, 'warning', woodmartConfig.invalid_date_order_msg);
            isValid = false;
        }
    });

    return isValid;
}

jQuery('#post:has(.xts-options)').on('submit', function(e){
	if ( ! validate() ) {
		e.preventDefault();
	}
});

window.addEventListener('load', function() {
	let ruleRows = document.querySelectorAll('.xts-timetable-control .xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');

	if ( ruleRows.length > 0 ) {
		ruleRows.forEach(function(ruleRow) {
			updateConditions(ruleRow);
		});
	}
});

document.addEventListener('click', function(event) {
    if (event.target.closest('.xts-timetable-control .xts-add-row')) {
		event.preventDefault();

		let ruleRows = document.querySelectorAll('.xts-timetable-control .xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');
		let lastRow  = ruleRows[ruleRows.length - 1];

		if ( ruleRows.length > 0 ) {
			updateConditions( lastRow );
		}

		if ( event.target.parentNode.parentNode.querySelectorAll('.xts-condition-day-first:not(.xts-hidden)').length > 0 ) {
			lastRow.querySelector('.xts-condition-empty').classList.remove('xts-hidden');
		}
    }
});

jQuery(document).on('xts_select_with_table_control_row_removed', function( e, $control ) {
	let $row = $control.find('.xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');

	if (1 === $row.length ) {
		updateConditions($row[0]);
	}
});
