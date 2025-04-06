/* global woodmartConfig, wd_conditions_notice, woodmartAdminModule */
(function($) {
    // Condition query select2.
    function conditionQuerySelect2($field) {
        $field.select2({
            ajax             : {
                url     : woodmartConfig.ajaxUrl,
                data    : function(params) {
                    return {
                        action    : 'wd_conditions_query',
                        security  : woodmartConfig.get_new_template_nonce,
                        query_type: $field.attr('data-query-type'),
                        search    : params.term
                    };
                },
                method  : 'POST',
                dataType: 'json'
            },
            theme            : 'xts',
            dropdownAutoWidth: false,
            width            : 'resolve'
        });
    }

    function conditionQueryFieldInit( conditionType, $querySelect ) {
        if ($querySelect.data('select2')) {
            $querySelect.val('');
            $querySelect.select2('destroy');
        }

        var $conditionQueryFieldTitle      = $querySelect.parents('.xts-controls-wrapper').find('.xts-condition-query').first();
        var $querySelectWrapper            = $querySelect.parent();
        var $productTypeQuerySelectWrapper = $querySelect.parent().siblings('.xts-product-type-condition-query');

        if ('all' === conditionType) {
            $querySelectWrapper.addClass('xts-hidden');
            $productTypeQuerySelectWrapper.addClass('xts-hidden');
            $querySelect.removeAttr('data-query-type');
        } else if ('product_type' === conditionType) {
            $querySelectWrapper.addClass('xts-hidden');
            $productTypeQuerySelectWrapper.removeClass('xts-hidden');
            $querySelect.removeAttr('data-query-type');
        } else {
            $querySelectWrapper.removeClass('xts-hidden');
            $productTypeQuerySelectWrapper.addClass('xts-hidden');
            $querySelect.attr('data-query-type', conditionType);
            conditionQuerySelect2($querySelect);
        }

        // Show or hide Condition query field title.
        var showTitle = false;

        $('select.xts-condition-type').each((key, type) => {
            if ( 'all' !== $(type).val() ) {
                showTitle = true;
            }
        });

        if ( showTitle ) {
            $conditionQueryFieldTitle.removeClass('xts-hidden');
        } else {
            $conditionQueryFieldTitle.addClass('xts-hidden');
        }
    }

    function validate() {
		let isValid            = true;
		let $conditions        = $('.xts-conditions-control');
		let $conditionRows     = $conditions.find('.xts-controls-wrapper > .xts-table-controls:not(.xts-table-heading)');

		if ( 0 === $conditionRows.length ) {
            woodmartAdminModule.woodmartAdmin.addNotice($conditions, 'warning', wd_conditions_notice.no_discount_condition);
            isValid = false;
        }

        return isValid;
	}

    $('#post:has(.xts-options)').on('submit', function(e){
        if ( ! validate() ) {
            e.preventDefault();
        }
    });

    $(document)
        .ready( function() {
            $('.xts-condition-query:not(.xts-hidden) select.xts-condition-query').each((key, field) => {
                var $querySelect  = $( field );
                var conditionType = $querySelect.parents('.xts-table-controls').find('select.xts-condition-type').val();

                conditionQueryFieldInit( conditionType, $querySelect );
            });
        })
        .on('change', 'select.xts-condition-type', function() {
            var $this = $(this);
            var conditionType = $this.val();
            var $querySelect = $this.parents('.xts-table-controls').find('select.xts-condition-query');

            conditionQueryFieldInit( conditionType, $querySelect );
        });
})(jQuery)
