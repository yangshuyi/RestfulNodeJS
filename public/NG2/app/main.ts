import { bootstrap }    from '@angular/platform-browser-dynamic';     //Angular's browser bootstrap function
import { HTTP_PROVIDERS } from '@angular/http';

import { AppComponent } from './app.component';                         //The application root component, AppComponent
import { APP_ROUTER_PROVIDERS } from './app.routes';        //Next we open main.ts where we must register our router providers in the bootstrap method.

import {provideForms, disableDeprecatedForms} from '@angular/forms';

bootstrap(AppComponent, [
    APP_ROUTER_PROVIDERS, HTTP_PROVIDERS, disableDeprecatedForms(), provideForms()
])
.catch(err => console.error(err));