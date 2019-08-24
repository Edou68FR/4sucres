import Vue from 'vue'
import { InertiaApp } from '@inertiajs/inertia-vue'

import moment from 'moment';
moment.locale('fr');

Vue.mixin({
    methods: {
        route: route,
        moment: moment,
    }
});

Vue.use(InertiaApp)

const app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
