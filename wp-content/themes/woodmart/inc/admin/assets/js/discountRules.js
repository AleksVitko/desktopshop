/* global woodmartConfig, wd_discount_rules_notice */
(function($) {
	function validate() {
        let isValid        = true;
        let $discountRules = $('.xts-discount_rules-field');
        let $ruleRows      = $discountRules.find('.xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');

        if ( 0 === $ruleRows.length ) {
            woodmartAdminModule.woodmartAdmin.addNotice( $discountRules, 'warning', wd_discount_rules_notice.no_quantity_range );
            isValid = false;
        }

        $ruleRows.each((key,ruleRow) => {
            let $ruleRow                = $(ruleRow);
            let priceFrom               = parseInt( $ruleRow.find('.xts-discount-from input').val() );
            let priceTo                 = parseInt( $ruleRow.find('.xts-discount-to input').val() );
            let type                    = $ruleRow.find('.xts-discount-type select').val();
            let discountPercentageValue = parseInt( $ruleRow.find('.xts-discount-percentage-value input').val() );
            let nextPriceFrom           = parseInt( $ruleRow.next().find('.xts-discount-from input').val() );

            if ( isNaN( priceFrom ) || isNaN( priceTo ) ) {
                return isValid;
            }

            if ( key !== $ruleRows.length - 1 && priceTo >= nextPriceFrom ) {
                if ( isNaN( nextPriceFrom ) ) {
                    return isValid;
                }

                woodmartAdminModule.woodmartAdmin.addNotice( $discountRules, 'warning', wd_discount_rules_notice.quantity_range_start );
                isValid = false;
            }

            if ( priceFrom > priceTo ) {
                woodmartAdminModule.woodmartAdmin.addNotice( $discountRules, 'warning', wd_discount_rules_notice.closing_quantity );
                isValid = false;
            }

            if ( 'percentage' === type && discountPercentageValue > 100 ) {
                woodmartAdminModule.woodmartAdmin.addNotice( $discountRules, 'warning', wd_discount_rules_notice.max_value );
                isValid = false;
            }
        });

        return isValid;
    }

    function updateConditions($ruleRow) {
        $ruleRow.find('.xts-discount-from input').attr('required', true);
        $ruleRow.find('.xts-discount-type select').attr('required', true);
        $ruleRow.find('.xts-discount-amount-value:not(.xts-hidden) input').attr('required', true);
        $ruleRow.find('.xts-discount-percentage-value:not(.xts-hidden) input').attr('required', true);

        $ruleRow.find('.xts-discount-type select').on('change', function() {
            let $discountTypeSelect = $(this);
            let $discountTypeWrapper = $discountTypeSelect.parent();
            let $discountAmountInputWrapper = $discountTypeWrapper.siblings('.xts-discount-amount-value');
            let $discountPercentageInputWrapper = $discountTypeWrapper.siblings('.xts-discount-percentage-value');
            let $discountAmountInput = $discountAmountInputWrapper.find('input');
            let $discountPercentageInput = $discountPercentageInputWrapper.find('input');

            if ( 'amount' === $discountTypeSelect.val() ) {
                $discountAmountInputWrapper.removeClass('xts-hidden');
                $discountPercentageInputWrapper.addClass('xts-hidden');

                $discountAmountInput.attr('required', true);
                $discountPercentageInput.attr('required', false);
            } else if ( 'percentage' === $discountTypeSelect.val() ) {
                $discountPercentageInputWrapper.removeClass('xts-hidden');
                $discountAmountInputWrapper.addClass('xts-hidden');

                $discountPercentageInput.attr('required', true);
                $discountAmountInput.attr('required', false);
            }
        })
    }

    $('#post:has(.xts-options)').on('submit', function(e){
        if ( ! validate() ) {
            e.preventDefault();
        }
    });

    $(document)
        .ready( function() {
            $('.xts-discount_rules-field .xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)').each((key,ruleRow) => {
                updateConditions( $(ruleRow) );
            });
        })
        .on('click', '.xts-discount_rules-field .xts-add-row', function(e) {
            e.preventDefault();

            let $ruleRows = $('.xts-discount_rules-field .xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');

            $ruleRows.each((key,ruleRow) => {
                let $ruleRow = $(ruleRow);

                updateConditions( $ruleRow );

                if ( key !== $ruleRows.length - 1 ) {
                    $ruleRow.find('.xts-discount-to input').attr('required', true);
                }
            });
        });
})(jQuery);
