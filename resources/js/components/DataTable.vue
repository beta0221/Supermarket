<template>
    <div>
        <CDataTable
        :items="items"
        :fields="fields"
        items-per-page-select
        :items-per-page="10"
        v-on:pagination-change="setRows">
        
            <template #index={item,index}>
                <td>{{index + 1}}</td>
            </template>

            <template #edit={item}>
                <td>
                    <CButton size="sm" color="info" class="ml-1" @click="showDetail(item)">
                        詳細
                    </CButton>
                </td>
            </template>
        
        </CDataTable>

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
        EventBus.$on("reloadData",_ => {
            this.reloadData();
        });
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
        },
        showDetail(item){
            EventBus.$emit("showDetailModal",item);
        }
    }
}
</script>

<style>

</style>