import { createRouter, createWebHistory, RouterView } from "vue-router";

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    {
        path: "/dashboard",
        component: () => import("./components/Dashboard.vue"),
    },
    {
        path: "/profile",
        component: () => import("./components/Profile.vue"),
    },
    {
        path: "/users",
        component: () => import("./components/Users.vue"),
    },
    {
        name: "not-found",
        path: "/:pathMatch(.*)*",
        component: () => import("./components/NotFound.vue"),
    },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
});

// Make sure to _use_ the router instance to make the
// whole app router-aware.
export default router;
