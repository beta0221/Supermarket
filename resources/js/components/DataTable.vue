<template>
  <div>
    <CDataTable
      :items="items"
      :fields="fields"
      items-per-page-select
      :items-per-page="10"
      v-on:pagination-change="setRows"
    >
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

      <template #status="{ item }">
        <td>
          <CBadge :color="colorDict[item.status]">
            <span v-if="item.statusText != undefinded">{{item.statusText}}</span>
            <span v-else>{{item.status}}</span>
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

      <!-- 刪除按鈕 -->
      <template #delete="{ item }">
        <td>
          <CButton
            size="sm"
            color="danger"
            class="ml-1"
            @click="deleteItem(item)">
            刪除
          </CButton>
        </td>
      </template>
      
      <!-- 刪除 & 編輯按鈕 -->
      <template #edit_delete="{ item }">
        <td>
          <CButton
            size="sm"
            color="info"
            class="ml-1"
            @click="showDetail(item)">
            詳細
          </CButton>
          <CButton
            size="sm"
            color="danger"
            class="ml-1"
            @click="deleteItem(item)">
            刪除
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
</template>

<script>
export default {
  props: ["fields", "requestUrl"],
  data() {
    return {
      filter:{},
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
    EventBus.$on("reloadDataWithFilter",filter =>{
      this.filter = filter;
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
      axios
        .get(this.requestUrl, {
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
    }
  },
};
</script>

<style>
</style>