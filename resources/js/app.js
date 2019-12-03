import Vue from 'vue'

import _ from 'lodash';
Object.defineProperty(Vue.prototype, '_', { value: _ });

import moment from 'moment';
moment.locale('fr');
Object.defineProperty(Vue.prototype, 'moment', { value: moment });

import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
Object.defineProperty(Vue.prototype, 'axios', { value: axios });

Object.defineProperty(Vue.prototype, 'route', { value: route });

Vue.prototype.asideAnimation = { value: true };

import { InertiaApp } from '@inertiajs/inertia-vue'
Vue.use(InertiaApp)

const app = document.getElementById('app')



new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Views/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
