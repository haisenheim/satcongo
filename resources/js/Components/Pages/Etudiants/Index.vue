<template>
    <Display>
        <template v-slot:page-header>
            <PageHeader :p="description" :h1="'BASE DE DONNEES DES ETUDIANTS'" ></PageHeader>
        </template>
        <template v-slot:content>
            <div class="">
                <div class="">
                    <div>
                        <div class="mb-2">
                            <input @input="search" type="text" style="max-width: 400px;" class="form-control bg-light p-2 border-white" placeholder="Rechercher ...">
                        </div>
                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <div class="card etudiant" v-for="item in filtered" :key="item.id">
                                <div class="card-header bg-primary">
                                    <h6><router-link class="text-white" :to="{name:'etudiants_show',params:{tkn:item.token}}" >{{ item.name }}</router-link></h6>
                                </div>
                                <div class="card-body text-center">
                                    <div><img :src="item.photo!=null?item.photo:avatar" class="img-circle img-rounded rounded-circle" alt="" style="width: 50px;"></div>
                                    <div><strong>{{ item.matricule }}</strong></div>
                                    <div>{{ item.classe }}</div>
                                </div>
                                <div class="card-footer bg-primary">
                                    <div><i class="pli-user text-white"></i> <strong><router-link class="text-white" :to="{name:'tuteurs_show',params:{tkn:item.tuteur!=null?item.tuteur.token:'hdjshs'}}" >{{ item.tuteur?item.tuteur.name:'-' }}</router-link></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </template>
    </Display>

</template>

<script>
import Display from '@/Components/Layout/Display.vue';
import PageHeader from '@/Components/Layout/Includes/PageHeader.vue';
import BreadCrumb from '@/Components/Layout/Includes/Breadcrumb.vue';
import avatar from '~/img/avatar.png';
export default {
    name:"SuperEtudiantIndex",
    components:{
        Display,
        PageHeader,
        BreadCrumb,

    },
    data(){
        return {
            user:this.$store.state.user,
            description:'CATALOGUE DE TOUS LES ETUDIANTS',
            etudiants:[],
            filtered:[],
            avatar: avatar,
        }
    },
    methods:{
        search(event){
            {
                setTimeout(() => {
                    if (!event.target.value.trim().length) {
                        this.filtered = [...this.etudiants];
                    } else {
                        this.filtered = this.etudiants.filter((item) => {
                            return item.last_name.toLowerCase().startsWith(event.target.value.toLowerCase())
                            || item.first_name.toLowerCase().startsWith(event.target.value.toLowerCase())
                            || item.matricule.toLowerCase().startsWith(event.target.value.toLowerCase())

                        });
                    }
                }, 250);
            }
        },
      async load(){
            //await this.$store.dispatch('ecoleCreate')
            await this.api.get('/api/etudiants')
            .then((res)=>{
                console.log(res.data);
                this.etudiants = res.data;
                this.filtered = res.data;
            })
            .catch((err)=>{
                console.log(err);
            })
            .finally(()=>{
                //this.$router.push({path:'/login'});
            })

        }
    },
    mounted(){
        this.load();
    }

}
</script>

<style scoped>
    td{
        vertical-align:middle
    }
    .etudiant{
        min-width: 200px;
    }
</style>
