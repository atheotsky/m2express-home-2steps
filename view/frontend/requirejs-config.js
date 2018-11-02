var config = {
    map: {
        '*': {
            'Magento_Swatches/js/swatch-renderer':'M2express_Home2Steps/js/swatch-renderer',
            'category-renderer':'M2express_Home2Steps/js/category-renderer'
        }
    },
    paths: {
        'owlCarousel': 'M2express_Home2Steps/js/owl.carousel'
    },
    shim: {
        'owlCarousel': {
            deps: ['jquery']
        }
    }
};
