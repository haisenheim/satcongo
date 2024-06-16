import EmploisIndex from "../Components/Pages/Emplois/Index.vue"
import EmploisCreate from "../Components/Pages/Emplois/Create.vue";
import EmploisShow from "../Components/Pages/Emplois/Show.vue"
export default[
    {
        name: "emplois_index",
        path: "/emplois",
        component: EmploisIndex,
        meta: {
            middleware: "auth",
            title: `Liste des emplois`
        }
    },
    {
        name: "emplois_create",
        path: "/emplois/create",
        component: EmploisCreate,
        meta: {
            middleware: "auth",
            title: `Nouvel emploi de temps`
        }
    },
    {
        name: "emplois_show",
        path: "/emplois/:tkn",
        props: true,
        component: EmploisShow,
        meta: {
            middleware: "auth",
            title: `Emploi`
        }
    },
]
