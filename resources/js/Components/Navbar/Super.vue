<template>
    <!-- Navigation menu -->
    <div class="mainnav__top-content scrollable-content pb-5">

        <!-- Profile Widget -->
        <div class="mainnav__profile mt-3 d-flex3">

            <div class="mt-2 d-mn-max"></div>

            <!-- Profile picture  -->
            <div class="mininav-toggle text-center py-2">
                <img class="mainnav__avatar img-md rounded-circle border" :src="avatar" alt="Profile Picture">
            </div>

            <div class="mininav-content collapse d-mn-max">
                <div class="d-grid">

                    <!-- User name and position -->
                    <button class="d-block btn shadow-none p-2" data-bs-toggle="collapse" data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
                        <span class="dropdown-toggle d-flex justify-content-center align-items-center">
                            <h6 class="mb-0 me-3">{{ user.name }}</h6>
                        </span>
                        <small class="text-muted">Super Admin</small>
                    </button>

                    <!-- Collapsed user menu -->
                    <div id="usernav" class="nav flex-column collapse">

                        <router-link to="/profile" class="nav-link">
                            <i class="demo-pli-male fs-5 me-2"></i>
                            <span class="ms-1">Profile</span>
                        </router-link>
                        <a href="javascript:void(0)" @click="logout()" class="nav-link">
                            <i class="demo-pli-unlock fs-5 me-2"></i>
                            <span class="ms-1">Se deconnecter</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
        <!-- End - Profile widget -->

        <!-- Navigation Category -->
        <div class="mainnav__categoriy py-3">
            <ul class="mainnav__menu nav flex-column">
                <template v-for="(mem, index) in menu" :key="index">
                    <HasSubMenu :sequence="mem.sequence" :icon="mem.icon" :links="mem.links" v-if="mem.links!==undefined">{{ mem.title }}</HasSubMenu>
                    <SingleMenuItem v-else :sequence="mem.sequence" :icon="mem.icon" :path="mem.path" >{{ mem.title }}</SingleMenuItem>
                </template>
            </ul>
        </div>
        <!-- END : Navigation Category -->
</div>
<!-- End - Navigation menu -->
</template>
<script>
    import {mapActions} from 'vuex';
    import SubMenu from "./Submenu.vue";
    import SingleMenuItem from './SingleMenuItem.vue';
    import HasSubMenu from './HasSubMenu.vue';
    import avatar from "~/img/avatar.png";
    export default{
        name:'SuperAdminNavbar',
        components:{
            SubMenu,
            SingleMenuItem,
            HasSubMenu,
        },
        data: function(){
            return {
                authenticated:this.$store.state.authenticated,
                user:this.$store.state.user,
                avatar:avatar,
                menu:[
                {
                    title:'Tableau de bord',
                    icon:'pli-dashboard',
                    sequence:1,
                    path:'/dashboard'
                },
                {
                    title:'SCOLARITE',
                    icon:'pli-student-hat',
                    sequence:2,
                    links:[
                        {
                            label:'Incriptions',
                            path:'/inscriptions'
                        },
                        {
                            label:'Etudiants',
                            path:'/etudiants'
                        },
                        {
                            label:'Enseignants',
                            path:'/enseignants'
                        },
                        {
                            label:'Parents et Tuteurs',
                            path:'/tuteurs',
                        },
                    ]
                },
                {
                    title:'SUIVI',
                    icon:'pli-spell-check',
                    sequence:3,
                    links:[
                        {
                            label:'Emplois de temps',
                            path:'/emplois'
                        },
                        {
                            label:'Programmes academiques',
                            path:'/programmes'
                        },
                        {
                            label:'Sanctions',
                            path:'/sanctions'
                        },
                        {
                            label:'Appreciations',
                            path:'/appreciations'
                        },
                    ]
                },
                {
                    title:'EXAMENS',
                    icon:'pli-pen-2',
                    sequence:4,
                    links:[
                        {
                            label:'Evaluations',
                            path:'/examens'
                        },
                        {
                            label:'Notes',
                            path:'/notes'
                        }
                    ]
                },
                {
                    title:'Bibliotheque',
                    icon:'pli-books',
                    sequence:5,
                    path:'/bibliotheque'
                },
                {
                    title:'FINANCES',
                    icon:'pli-coins',
                    sequence:6,
                    links:[
                        {
                            label:'PAIEMENTS',
                            path:'/ecolages'
                        },
                        {
                            label:'AUTRES ENTREES',
                            path:'/entrees'
                        },
                        {
                            label:'AUTRES DEPENSES',
                            path:'/depenses'
                        }
                    ]
                },
                {
                    title:'RAPPORTS',
                    icon:'pli-files',
                    sequence:7,
                    links:[
                        {
                            label:'ETUDIANT',
                            path:'/reports/students'
                        },
                        {
                            label:'MENSUEL',
                            path:'/reports/month'
                        },
                        {
                            label:'ENSEIGNANT',
                            path:'/reports/teacher'
                        }
                    ]
                },

                    {
                        title:'ECOLE',
                        icon:'pli-university',
                        sequence:8,
                        links:[
                            {
                                label:'Salles de cours',
                                path:'/salles'
                            },
                            {
                                label:'Laboratoires',
                                path:'/laboratoires'
                            },
                            {
                                label:'Matieres',
                                path:'/matieres'
                            },
                            {
                                label:'Filieres',
                                path:'/filieres'
                            }
                        ]
                    },
                    {
                        title:'PARAMETRES',
                        icon:'pli-gears',
                        sequence:9,
                        links:[
                            {
                                label:'Tarifs',
                                path:'/tarifs'
                            },
                            {
                                label:'Types d\'evaluation',
                                path:'/evaluations'
                            },
                            {
                                label:'Annees academiques',
                                path:'/annees'
                            },
                        ]
                    },

                ],
            }
        },
        computed:{
            username(){
                if(this.$store.state.user==!undefined){
                    console.log(this.$store.state.user);
                    return this.$store.state.user.name;
                }
                return ''

            }
        },

        mounted(){
            console.log(this.$store.state.user.name);

        },

        methods:{
            ...mapActions({
                signOut:"auth/logOut"
            }),

            async logout(){
                this.$store.dispatch('logOut')
                .then((res)=>{
                    console.log(res);
                    this.$emit('logout');
                    this.$router.push({path:'/login'});
                })
                .catch((err)=>{
                    console.log(err);
                })
            },
        }
    }

</script>
<style scoped>
  .collapsed.mininav-toggle.nav-link> .nav-label{
        font-weight: 900 !important;
    }
</style>
