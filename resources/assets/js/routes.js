import store from './store'


function redirectIfNotAuthenticated(to, from ,next) {
  if (store.getters['auth/check'])
    next()
  else
    next('/login')
} 

function redirectIfAuthenticated(to, from ,next) {
  if (store.getters['auth/check']) { 
    if (store.getters['auth/role'] == 'admin')
      next('/dashboard')
    else
      next({name: 'contact.view' , params: {contact: store.getters['auth/contactId']}})
  }
  else
    next()
} 

  
function redirectIfNotAdmin(to, from ,next) {
  if (store.getters['auth/check'] && store.getters['auth/role'] == 'admin')
    next()
  else {
    next('/login')
  }
}

function redirectIfCantEditContact(to, from ,next) {
  if (
    store.getters['auth/check'] && 
    (store.getters['auth/role'] == 'admin' || 
    store.getters['auth/contactId'] == to.params.contact)
  )
    next()
  else {
    next('/login')
  }
}

export default [

  {
    path: '/login', 
    component: require('./pages/Login'), 
    beforeEnter: redirectIfAuthenticated,
    name: 'login'
  },
  {
    path: '/dashboard', 
    component: require('./pages/Dashboard'), 
    name : 'dashboard',
    beforeEnter: redirectIfNotAdmin

  },
  {
    path: '/contact/create', 
    component: require('./pages/contact/Create'), 
    name : 'contact.create',
    beforeEnter: redirectIfNotAdmin

  },
  {
    path: '/contact/:contact', 
    component: require('./pages/contact/View'), 
    name : 'contact.view',
    beforeEnter: redirectIfCantEditContact

  },
  {
    path: '/contact/:contact/edit', 
    component: require('./pages/contact/Edit'), 
    name : 'contact.edit',
    beforeEnter: redirectIfCantEditContact

  },
  {
    path: '/agency/create', 
    component: require('./pages/agency/Create'), 
    name : 'agency.create',
    beforeEnter: redirectIfNotAdmin

  },
  {
    path: '/agency/:agency', 
    component: require('./pages/agency/View'), 
    name : 'agency.view',
    beforeEnter: redirectIfNotAdmin

  },
  {
    path: '/agency/:agency/edit', 
    component: require('./pages/agency/Edit'), 
    name : 'agency.edit',
    beforeEnter: redirectIfNotAdmin

  },
  {
    path: '/',
    redirect: '/login'
  },

];
