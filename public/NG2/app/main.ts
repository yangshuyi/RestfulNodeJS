import { bootstrap }    from '@angular/platform-browser-dynamic';     //Angular's browser bootstrap function
import { AppComponent } from './app.component';                         //The application root component, AppComponent
import { APP_ROUTER_PROVIDERS } from './app.routes';        //Next we open main.ts where we must register our router providers in the bootstrap method.

bootstrap(AppComponent, [
    APP_ROUTER_PROVIDERS
])
.catch(err => console.error(err));