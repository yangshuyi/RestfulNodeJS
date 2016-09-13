import {Component, ComponentRef, ViewContainerRef, ViewChild, ComponentResolver, ComponentFactory} from '@angular/core';

import '$';
import {NG2BootstrapDemo} from "./ng2BootstrapDemo.model";

@Component({
    selector: 'bootstrap-component',
    templateUrl: 'app/ng2-bootstrap-demo/bootstrap.template.html',
    styles: [''],
    directives: [],
    providers: []
})
export class BootstrapComponent {

    @ViewChild('demoContent', {read: ViewContainerRef})
    private target;

    private cmpRef:ComponentRef<any>;

    private ng2BootstrapDemo:NG2BootstrapDemo = new NG2BootstrapDemo();

    constructor(private resolver:ComponentResolver) {
        console.log('BootstrapComponent constructor');
    }


    showDemo(demo:{componentSelector:string,componentClass:string}) {
        if (demo && demo.componentSelector) {
            this.resolver.resolveComponent(demo.componentClass).then((factory:ComponentFactory<any>) => {
                this.cmpRef = this.target.createComponent(factory);
            });
        }

    }
}

