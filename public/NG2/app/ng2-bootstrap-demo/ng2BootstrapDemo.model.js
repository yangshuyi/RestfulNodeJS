"use strict";
var demo_buttons_component_1 = require("./demo-buttons.component");
var demo_carousel_component_1 = require("./demo-carousel.component");
var NG2BootstrapDemo = (function () {
    function NG2BootstrapDemo() {
        this.demos = [
            {
                name: 'Accordion',
                componentSelector: '',
                componentClass: ''
            },
            {
                name: 'Alert',
                componentSelector: '',
                componentClass: ''
            },
            {
                name: 'Buttons',
                componentSelector: 'ng2-bootstrap-demo-buttons-component',
                componentClass: demo_buttons_component_1.DemoButtonsComponent
            },
            {
                name: 'Carousel',
                componentSelector: 'ng2-bootstrap-demo-carousel-component',
                componentClass: demo_carousel_component_1.DemoCarouselComponent
            },
            {
                name: 'Collapse',
                componentSelector: '',
                componentClass: ''
            },
            {
                name: 'Datepicker',
                componentSelector: '',
                componentClass: ''
            }
        ];
    }
    return NG2BootstrapDemo;
}());
exports.NG2BootstrapDemo = NG2BootstrapDemo;
//# sourceMappingURL=ng2BootstrapDemo.model.js.map