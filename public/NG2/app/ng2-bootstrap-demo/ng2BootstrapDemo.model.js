"use strict";
var demo_buttons_component_1 = require("./demo-buttons.component");
var demo_carousel_component_1 = require("./demo-carousel.component");
var demo_accordion_component_1 = require("./demo-accordion.component");
var demo_datepicker_component_1 = require("./demo-datepicker.component");
var demo_mainmenu_component_1 = require("./demo-mainmenu.component");
var demo_modal_component_1 = require("./demo-modal.component");
var demo_dropdown_component_1 = require("./demo-dropdown.component");
var demo_topmenu_component_1 = require("./demo-topmenu.component");
var NG2BootstrapDemo = (function () {
    function NG2BootstrapDemo() {
        this.demos = [
            {
                name: 'Accordion',
                componentSelector: 'ng2-bootstrap-demo-accordion-component',
                componentClass: demo_accordion_component_1.DemoAccordionComponent
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
                componentSelector: 'ng2-bootstrap-demo-datepicker-component',
                componentClass: demo_datepicker_component_1.DemoDatepickerComponent
            },
            {
                name: 'Dropdown',
                componentSelector: 'ng2-bootstrap-demo-dropdown-component',
                componentClass: demo_dropdown_component_1.DemoDropdownComponent
            },
            {
                name: 'MainMenu',
                componentSelector: 'g2-bootstrap-demo-mainmenu-component  ',
                componentClass: demo_mainmenu_component_1.DemoMainMenuComponent
            },
            {
                name: 'Modal',
                componentSelector: 'ng2-bootstrap-demo-dropdown-component',
                componentClass: demo_modal_component_1.DemoModalComponent
            },
            {
                name: 'TopMenu',
                componentSelector: 'ng2-bootstrap-demo-topmenu-component',
                componentClass: demo_topmenu_component_1.DemoTopMenuComponent
            }
        ];
    }
    return NG2BootstrapDemo;
}());
exports.NG2BootstrapDemo = NG2BootstrapDemo;
//# sourceMappingURL=ng2BootstrapDemo.model.js.map