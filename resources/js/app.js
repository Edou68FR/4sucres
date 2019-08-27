import Vue from 'vue'
import _ from 'lodash';
import moment from 'moment';
import { InertiaApp } from '@inertiajs/inertia-vue'

moment.locale('fr');

Object.defineProperty(Vue.prototype, 'route', { value: route });
Object.defineProperty(Vue.prototype, 'moment', { value: moment });
Object.defineProperty(Vue.prototype, '_', { value: _ });

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
