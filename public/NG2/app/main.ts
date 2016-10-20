//Start up your application
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic'; //Angular's browser bootstrap function

import { AppModule } from './app.module';                    //The application root component, AppComponent

//Because the QuickStart application runs directly in the browser, main.ts imports the platformBrowserDynamic function from @angular/platform-browser-dynamic, not @angular/core.
//On a mobile device, you might load a module with Apache Cordova or NativeScript, using a bootstrap function that's specific to that platform.

const platform = platformBrowserDynamic();
platform.bootstrapModule(AppModule);
