define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'payonaccount',
                component: 'Evry_Payonaccount/js/view/payment/method-renderer/payonaccount'
            }
        );
        return Component.extend({});
    }
);