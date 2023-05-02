Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'redirects',
      path: '/redirects',
      component: require('./components/Tool').default,
    },
  ])
})
