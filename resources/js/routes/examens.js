import ExamensIndex from "../Components/Pages/Examens/Index.vue"
import ExamensCreate from "../Components/Pages/Examens/Create.vue";
import ExamensShow from "../Components/Pages/Examens/Show.vue"
import ExamensNotes from "../Components/Pages/Examens/Notes.vue"
export default[
    {
        name: "examens_index",
        path: "/examens",
        component: ExamensIndex,
        meta: {
            middleware: "auth",
            title: `Liste des examens`
        }
    },
    {
        name: "examens_notes",
        path: "/notes",
        component: ExamensNotes,
        meta: {
            middleware: "auth",
            title: `Liste des notes`
        }
    },
    {
        name: "examens_create",
        path: "/examens/create",
        component: ExamensCreate,
        meta: {
            middleware: "auth",
            title: `Nouvelle examen`
        }
    },
    {
        name: "examens_show",
        path: "/examens/show/:tkn",
        props: true,
        component: ExamensShow,
        meta: {
            middleware: "auth",
            title: `Salle`
        }
    },
]
