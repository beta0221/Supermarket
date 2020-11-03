<template>
    <div>
    <label>{{label}}</label>
    <Multiselect 
        :options="options"
        v-model="selectedOptions"
        :multiple="true"
        :searchable="true"       
        :track-by="this.trackBy"
        placeholder="Type to search"
        label="name"/>
    </div>

</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    props:['label','url','relation','relationUrl','trackBy'],
    components:{
        Multiselect
    },
    data(){
        return{
            id:null,
            loading:true,
            options:[],
            selectedOptions:[],
        }
    },
    watch:{
        selectedOptions(){
            if(this.loading){ return; }
            this.syncSelectedOptions();
        }
    },
    created(){
        this.getAllOptions();
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            this.id = item['id'];
            this.getSelectedOptions();
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        getAllOptions(){
            axios.get(this.relationUrl)
            .then(res => {
                this.options = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        async getSelectedOptions(){
            this.loading = true;
            await axios.get(`${this.url}/${this.id}/${this.relation}`)
            .then(res => {
                this.selectedOptions = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
            this.loading = false;
        },
        async syncSelectedOptions(){
            
            let syncArray = [];
            this.selectedOptions.forEach(item =>{
                syncArray.push(item.id);
            });
            this.loading = true;
            await axios.post(`${this.url}/${this.id}/${this.relation}`,{
                '_method':'PUT',
                'syncArray':syncArray
            })
            .then(res => {
                this.selectedOptions = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
            this.loading = false;
        }
    }
}
</script>

<style>

</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>