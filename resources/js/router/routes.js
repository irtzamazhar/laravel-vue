function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },
  { path: '/home', name: 'home', component: page('activity/activities.vue') },
  { path: '/addActivity', name: 'addActivity', component: page('activity/addActivity.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },

  { path: '*', component: page('errors/404.vue') }
]
