// Import di vue e di vue router
import Vue from 'vue'
import VueRouter from 'vue-router'

// Importo i componenti delle pagine
import HomePage  from './components/pages/HomePage.vue';
import AboutPage  from './components/pages/AboutPage.vue';
import ContactsPage  from './components/pages/ContactsPage.vue';
import NotFoundPage from './components/pages/NotFoundPage.vue';
import PostDetailPage from './components/pages/PostDetailPage.vue';

// Dico a Vue di usare VueRouter
Vue.use(VueRouter)

// Definizione delle rotte
const routes = new VueRouter({

mode: 'history', // ci tiene la cronologia 
linkExactActiveClass: 'active',
routes: [
  { path: '/', component: HomePage, name: 'home' },
  { path: '/about', component: AboutPage, name: 'about' },
  { path: '/contacts', component: ContactsPage, name: 'contacts' },
  { path: '/posts/:id', component: PostDetailPage, name: 'post-detail' },
  
  { path: '*', component: NotFoundPage, name: 'not_found' }
]
});  // inizializzo una nuova istanza di router

// lo rendo esportabile
export default routes;
