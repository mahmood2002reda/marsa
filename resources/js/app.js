import { createApp } from 'vue';
import CreateTour from './components/CreateTour.vue';

document.addEventListener('DOMContentLoaded', function() {
    const appElement = document.querySelector('#app');
    console.log('App element:', appElement); // This will log the #app element
    if (appElement) {
        const app = createApp({});
        app.component('create-tour', CreateTour);
        app.mount('#app');
    } else {
        console.error('Mount target #app not found');
    }
});
Vue.component('tour-details', require('./components/TourDetails.vue').default);
