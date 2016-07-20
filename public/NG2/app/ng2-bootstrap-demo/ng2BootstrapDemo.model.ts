import {DemoButtonsComponent} from "./demo-buttons.component";
import {DemoCarouselComponent} from "./demo-carousel.component";
export class NG2BootstrapDemo {
    demos:Object = [
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
            componentSelector: '',
            componentClass: ''
        }
    ]
}
