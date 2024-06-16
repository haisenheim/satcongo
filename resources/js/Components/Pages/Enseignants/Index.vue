<template>
    <Display>
        <template v-slot:page-header>
            <PageHeader :p="description" :h1="'BASE DE DONNEES DES ENSEIGNANTS'" ></PageHeader>
        </template>
        <template v-slot:content>
            <div class="">
                <div class="">
                    <div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="">
                            <input @input="search" type="text" style="max-width: 400px;" class="form-control bg-light p-2 border-white" placeholder="Rechercher ...">
                        </div>
                            <router-link class="btn btn-primary" to="/enseignants/create"><i class="demo-pli-add me-1 fs-5"></i> NOUVEL ENSEIGNANT</router-link>
                        </div>

                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <div class="card enseignant" v-for="item in filtered" :key="item.id">
                                <div class="card-header bg-primary">
                                    <h6><router-link class="text-white" :to="{name:'enseignants_show',params:{tkn:item.token}}" >{{ item.name }}</router-link></h6>
                                </div>
                                <div class="card-body text-center">
                                    <div><img :src="item.photo" class="img-circle img-thumbnail" alt="" style="width: 100%; height: 100px"></div>
                                    <div>NOM : <strong>{{ item.last_name }}</strong></div>
                                    <div>PRENOM : <strong>{{ item.first_name }}</strong></div>
                                    <div>NATIONALITE : <strong>{{ item.pays }}</strong></div>
                                    <div>AGE : <strong class="text-danger text-bold">{{ item.age }} ANS</strong></div>
                                    <div> <i class="pli-home"></i> <strong>{{ item.address }}</strong></div>
                                    <div> <i class="pli-email"></i> <strong>{{ item.email }}</strong></div>
                                    <div> <i class="pli-phone"></i> <strong>{{ item.phone }}</strong></div>
                                </div>
                                <div class="card-footer bg-primary">
                                    <div> <strong class="text-white">{{ item.diplome }}</strong></div>
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
    name:"SuperEnseignantIndex",
    components:{
        Display,
        PageHeader,
        BreadCrumb,

    },
    data(){
        return {
            user:this.$store.state.user,
            description:'CATALOGUE DE TOUS LES ENSEIGNANTS',
            enseignants:[],
            filtered:[],
        }
    },
    methods:{
        search(event){
            {
                setTimeout(() => {
                    if (!event.target.value.trim().length) {
                        this.filtered = [...this.enseignants];
                    } else {
                        this.filtered = this.enseignants.filter((item) => {
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
            await this.api.get('/api/enseignants')
            .then((res)=>{
                console.log(res.data);
                this.enseignants = res.data;
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
    .enseignant{
        min-width: 200px;
    }
</style>
