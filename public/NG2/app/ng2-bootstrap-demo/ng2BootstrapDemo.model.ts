import {DemoButtonsComponent} from "./demo-buttons.component";
import {DemoCarouselComponent} from "./demo-carousel.component";
import {DemoAccordionComponent} from "./demo-accordion.component";
import {DemoDatepickerComponent} from "./demo-datepicker.component";
import {DemoMainMenuComponent} from "./demo-mainmenu.component";
import {DemoModalComponent} from "./demo-modal.component";
import {DemoDropdownComponent} from "./demo-dropdown.component";
import {DemoTopMenuComponent} from "./demo-topmenu.component";
export class NG2BootstrapDemo {
    demos:Object = [
        {
            name: 'Accordion',
            componentSelector: 'ng2-bootstrap-demo-accordion-component',
            componentClass: DemoAccordionComponent
        },
        {
            name: 'Alert',
            componentSelector: '',
            componentClass: ''
        },
        {
            name: 'Buttons',
            componentSelector: 'ng2-bootstrap-demo-buttons-component',
            componentClass: DemoButtonsComponent
        },
        {
            name: 'Carousel',
            componentSelector: 'ng2-bootstrap-demo-carousel-component',
            componentClass: DemoCarouselComponent
        },
        {
            name: 'Collapse',
            componentSelector: '',
            componentClass: ''
        },
        {
            name: 'Datepicker',
            componentSelector: 'ng2-bootstrap-demo-datepicker-component',
            componentClass: DemoDatepickerComponent
        },
        {
            name: 'Dropdown',
            componentSelector: 'ng2-bootstrap-demo-dropdown-component',
            componentClass: DemoDropdownComponent
        },
        {
            name: 'MainMenu',
            componentSelector: 'g2-bootstrap-demo-mainmenu-component  ',
            componentClass: DemoMainMenuComponent

        },
        {
            name: 'Modal',
            componentSelector: 'ng2-bootstrap-demo-dropdown-component',
            componentClass: DemoModalComponent
        },
        {
            name: 'TopMenu',
            componentSelector: 'ng2-bootstrap-demo-topmenu-component',
            componentClass: DemoTopMenuComponent
        }
    ]
}
