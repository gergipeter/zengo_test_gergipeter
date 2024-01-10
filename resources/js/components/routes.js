// In your router/index.js or where you define your routes

import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const routes = [
  // ... your other routes ...

  {
    path: '/delete-city/:cityId',
    name: 'deleteCity',
    component: () => import(/* webpackChunkName: "deleteCity" */ '../views/DeleteCity.vue'),
    props: true, // Pass the route params as props to the component
  },
];

const router = new Router({
  routes,
});

export default router;
