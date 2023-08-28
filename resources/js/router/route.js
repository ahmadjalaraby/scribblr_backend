const routes = [
    {
        path: "/",
        name: "Layout",
        redirect: "/dashboard",
        // component: () => import("@/Layouts/AuthenticatedLayout.vue"),
        // beforeEnter: auth,
        children: [
            {
                path: "/",
                name: 'dashboard',
                component: () => import("@/Pages/Dashboard.vue"),
            },
            {
                path: "/dashboard",
                name: 'dashboard',
                component: () => import("@/Pages/Dashboard.vue"),
            },
            {
                path: "/tags",
                name: "tags.index",
                component: () => import("@/Pages/Tag/List.vue"),
                meta: {
                    groupParent: "tags",
                },
            },
            {
                path: "/tags/create",
                name: "tags.create",
                component: () => import("@/Pages/Tag/Create.vue"),
                meta: {
                    groupParent: "tags",
                },
            },
            {
                path: ``,
                name: "tags.edit",
                component: () => import("@/Pages/Tag/Edit.vue"),
                meta: {
                    groupParent: "tags",
                },
            },
            {
                path: "/users",
                name: "users.index",
                component: () => import("@/Pages/User/List.vue"),
                meta: {
                    groupParent: "users",
                },
            },
            {
                path: "/users/create",
                name: "users.create",
                component: () => import("@/Pages/User/Create.vue"),
                meta: {
                    groupParent: "users",
                },
            },
            {
                path: ``,
                name: "users.edit",
                component: () => import("@/Pages/User/Edit.vue"),
                meta: {
                    groupParent: "users",
                },
            },
            {
                path: "/articles",
                name: "articles.index",
                component: () => import("@/Pages/Article/List.vue"),
                meta: {
                    groupParent: "articles",
                },
            },
            {
                path: "/articles/create",
                name: "articles.create",
                component: () => import("@/Pages/Article/Create.vue"),
                meta: {
                    groupParent: "articles",
                },
            },
            {
                path: ``,
                name: "articles.edit",
                component: () => import("@/Pages/Article/Edit.vue"),
                meta: {
                    groupParent: "articles",
                },
            },
            {
                path: "/countries",
                name: "countries.index",
                component: () => import("@/Pages/Country/List.vue"),
                meta: {
                    groupParent: "countries",
                },
            },
            {
                path: "/countries/create",
                name: "countries.create",
                component: () => import("@/Pages/Country/Create.vue"),
                meta: {
                    groupParent: "countries",
                },
            },
            {
                path: ``,
                name: "countries.edit",
                component: () => import("@/Pages/Country/Edit.vue"),
                meta: {
                    groupParent: "countries",
                },
            },
            {
                path: "/languages",
                name: "languages.index",
                component: () => import("@/Pages/Language/Index.vue"),
                meta: {
                    // groupParent: "tags",
                },
            },
            {
                path: "/languages/create",
                name: "languages.create",
                component: () => import("@/Pages/Language/Create.vue"),
                meta: {
                    // groupParent: "tags",
                },
            },
            {
                path: "notifications",
                name: "notifications",
                component: () => import("@/Pages/Dashboard.vue"),
                meta: {
                    hide: true,
                },
            },
        ],
    },
    {
        path: "/login",
        name: "Login",
        // beforeEnter: guest,
        component: () => import("@/Pages/Auth/Login.vue"),
    },
    {
        path: "/:catchAll(.*)",
        name: "404",
        component: () => import("@/Pages/Error/404.vue"),
    },

];
export default routes;
