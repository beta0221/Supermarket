<template>
<div>

    <div>
        <CRow class="mt-3">
            <CCol md="2">
                <SingleSelector
                    :label="'狀態'"
                    :relationUrl="'/api/activeStatus/all'"
                    :column="'active'"
                    :trackBy="'name'"
                    v-on:updateDataColumn="updateFilter"
                    :value="filter.active"/>
            </CCol>

            <CCol md="2">
                <SingleSelector
                    :label="'類別'"
                    :relationUrl="'/api/category/all'"
                    :column="'category_id'"
                    :trackBy="'name'"
                    v-on:updateDataColumn="updateFilter"
                    :value="filter.category_id"/>
            </CCol>

            <CCol md="2">
                <CInput 
                    :label="'名稱'" 
                    :placeholder="'名稱'"
                    @keyup.native.enter="updateFilter"
                    v-model.lazy="filter.name"/>
            </CCol>
        </CRow>
        
    </div>

    <div>
        <CDataTable
        :items="items"
        :fields="fields"
        items-per-page-select
        :items-per-page="10"
        v-on:pagination-change="setRows">

        <template #index="{ item, index }">
            <td>{{ index + 1 }}</td>
        </template>
        <template #active="{ item }">
            <td>
            <CBadge :color="colorDict[item.active]">
                {{ activeDict[item.active] }}
            </CBadge>
            </td>
        </template>

        <!-- 編輯按鈕 -->
        <template #edit="{ item }">
            <td>
            <CButton
                size="sm"
                color="info"
                class="ml-1"
                @click="showDetail(item)"
            >
                詳細
            </CButton>
            </td>
        </template>
        
        </CDataTable>

        <CPagination
        :activePage.sync="pagination.page"
        :pages.sync="pagination.totalPage"
        align="start"
        v-on:update:activePage="reloadData"
        />
    </div>
</div>
</template>

<script>
export default {
    props: ["fields", "requestUrl"],
    data() {
        return {
            filter:{
                category_id:null,
                active:null,
                name:null
            },
            items: [],
            pagination: {
                page: 1,
                rows: 10,
                totalPage: 10,
                //orderBy:'id',
                //order:'desc',
            },
            activeDict: {
                0: "未啟用",
                1: "啟用中",
            },
            colorDict: {
                0: "danger",
                1: "success",
            },
        };
    },
    created() {
        this.reloadData();
    },
    mounted() {
        EventBus.$on("reloadData", (_) => {
            this.reloadData();
        });
    },
    destroyed() {
        EventBus.$off("reloadData");
    },
    methods: {
        setRows(value) {
            this.pagination.rows = value;
            this.reloadData();
        },
        reloadData() {
            let _params = Object.assign({},this.pagination);
            Object.keys(this.filter).forEach(key => {
                let value = this.filter[key];
                if(value != null || value != ''){
                    _params[key] = value;
                }
            });
            axios.get(this.requestUrl, {
                params: _params,
            })
            .then((res) => {
                this.items = res.data.data;
                this.pagination = res.data.pagination;
            })
            .catch((error) => {
                errorHelper.handle(error);
            });
        },
        showDetail(item) {
            EventBus.$emit("showDetailModal", item);
        },
        deleteItem(item){
            axios.post(this.requestUrl + "/" + item.id, {
                '_method':'DELETE'
            })
            .then(res => {
                this.reloadData();
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        updateFilter(obj){
            this.$set(this.filter,obj.column,obj.value);
            this.reloadData();
        }
    },
};
</script>

<style>
</style>