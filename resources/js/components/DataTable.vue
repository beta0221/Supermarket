<template>
    <div>
        <CDataTable
        :items="items"
        :fields="fields"
        items-per-page-select
        :items-per-page="10"
        v-on:pagination-change="setRows"
        ></CDataTable>

        <CPagination
            :activePage.sync="pagination.page"
            :pages.sync="pagination.totalPage"
            align="start"
            v-on:update:activePage="reloadData"/>
    </div>
    
    
    
</template>

<script>
export default {
    props:[
        'fields','requestUrl',
    ],
    data(){
        return{
            items:[],
            pagination:{
                page:1,
                rows:10,
                totalPage:10,
                //orderBy:'id',
                //order:'desc',
            },
        }
    },
    created(){
        this.reloadData();
    },
    methods:{
        setRows(value){
            this.pagination.rows = value;
            this.reloadData();
        },
        reloadData(){
            
            axios.get(this.requestUrl, {
                params: this.pagination
            })
            .then(res => {
                this.items = res.data.data;
                this.pagination = res.data.pagination;
            })
            .catch(error =>{
                console.log(error);
            })
        }
    }
}
</script>

<style>

</style>