import Layout from '../views/layout/Layout'
import i18n from '../lang'

/**
 * hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
 * alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
 *                                if not set alwaysShow, only more than one route under the children
 *                                it will becomes nested mode, otherwise not show the root menu
 * redirect: noredirect           if `redirect:noredirect` will no redirct in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * permissions: []                Only who has one of these permissions can access/view this route
 *                                No permissions property means no guards.
 * meta : {
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar,
  }
 **/
export default [{},
  {
    path: '/user',
    component: Layout,
    redirect: '/user/list',
    name: 'User',
    permissions: ['User@index', 'Role@index', 'Permission@index'],
    meta: { title: () => i18n.t('user.title'), icon: 'fa-users' },
    children: [
      {
        path: 'list',
        name: 'Users',
        permissions: ['User@index'],
        component: () => import('@/views/user/List'),
        meta: { title: () => i18n.t('global.terms.list'), icon: 'fa-user' }
      },
      {
        hidden: true,
        path: ':id/edit',
        name: 'Edit User',
        permissions: ['User@update'],
        component: () => import('@/views/user/Editor'),
        meta: { title: () => i18n.t('global.terms.edit'), icon: 'fa-user' }
      },
      {
        hidden: true,
        path: 'create',
        name: 'Create User',
        permissions: ['User@store'],
        component: () => import('@/views/user/Editor'),
        meta: { title: () => i18n.t('global.terms.create'), icon: 'fa-user' }
      },
      {
        path: 'role/list',
        name: 'Roles',
        permissions: ['Role@index'],
        component: () => import('@/views/user/role/List'),
        meta: { title: () => i18n.t('routes.role_list'), icon: 'fa-id-card' }
      },
      {
        hidden: true,
        path: 'role/create',
        name: 'Create Role',
        permissions: ['Role@create'],
        component: () => import('@/views/user/role/Editor'),
        meta: { title: () => i18n.t('routes.role_create'), icon: 'fa-user' }
      },
      {
        hidden: true,
        path: 'role/:id/edit',
        name: 'Edit Role',
        permissions: ['Role@update'],
        component: () => import('@/views/user/role/Editor'),
        meta: { title: () => i18n.t('routes.role_edit'), icon: 'fa-user' }
      },
      {
        path: 'permission',
        name: 'Permissions',
        permissions: ['Permission@index'],
        component: () => import('@/views/user/permission/List'),
        meta: { title: () => i18n.t('permission.title'), icon: 'fa-cogs' }
      }
    ]
  }
  // Append More Routes. Don't remove me
]
