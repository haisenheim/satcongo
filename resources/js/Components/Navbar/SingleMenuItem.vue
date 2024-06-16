<template>
    <!-- Link with submenu -->
<li @click="toggle()"  class="nav-item">

<router-link @click="setActive()" :title="title" data-toggle="tooltip" :data-bs-original-title="title" data-bs-placement="right" :to="{path:path}"  :class="collapsed?'collapsed':'',active" class="mininav-toggle nav-link"><i :class="icon" class="fs-2 me-2"></i>
    <span class="nav-label ms-1"><slot></slot></span>
</router-link>


</li>
<!-- END : Link with submenu -->
</template>

<script>
    export default{
        name:'SubmenuItem',
        props:{
            'sequence':Number,
            'name':String,
            'title':String,
            'path':String,
            'icon':String,
            'args':[],
        },
        data(){
            return{
                collapsed:true,
            }
        },
        computed:{
            isActive(){
                return !this.collapsed;
            },
            active(){

                return this.$store.state.active == this.sequence?'active':''
            }

        },
        methods:{
            toggle(){
                if(this.$store.state.navbar_min){
                    this.collapsed=!this.collapsed;
                }
            },

            setActive(){
               this.$store.commit('SET_ACTIVE',this.sequence);
               console.log(this.$store.state.active);
            }
        }
    }

</script>

<style scoped>
    .nav-label{
        font-weight: 900;
    }
</style>
