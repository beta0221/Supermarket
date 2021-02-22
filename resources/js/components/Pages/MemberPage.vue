<template>
  <div>
    <NavBar :title="'會員管理'" />
     <CRow class="mt-3 mx-2">
        <CCol md="2">
          <CSelect
            :value.sync="searchColumn"
            :options="columns"
          ></CSelect>
        </CCol>
        <CCol md="2">
          <CSelect
            v-if="searchColumn == 'active'"
            :value.sync="searchValue"
            :options="activeValue"
            placeholder="選擇狀態"
            @change="searchByColumn"
          ></CSelect>
          <CInput
            v-if="searchColumn == 'name'"
            type="text"
            :value.sync="searchValue"
            @keyup.native.enter="searchByColumn"
          ></CInput>
          <CInput
            v-if="searchColumn == 'email'"
            type="text"
            :value.sync="searchValue"
            @keyup.native.enter="searchByColumn"
          ></CInput>
          <CInput
            v-if="searchColumn == 'created_at'"
            type="date"
            :value.sync="searchValue"
            @keyup.native.enter="searchByColumn"
          ></CInput>
        </CCol>
      </CRow>
    <CCardBody>
      <CDataTable
        :items="items"
        :fields="fields"
        items-per-page-select
        :items-per-page="10"
        v-on:pagination-change="setRows"
        hover
        pagination
      >
        <template #active="{ item }">
          <td>
            <CBadge :color="colorDict[item.active]">
              {{ activeDict[item.active] }}
            </CBadge>
          </td>
        </template>
        <template #show_details="{ item, index }">
          <td class="py-2">
            <CButton
              color="primary"
              variant="outline"
              square
              size="sm"
              @click="toggleDetails(item, index)"
            >
              {{ Boolean(item._toggled) ? "Hide" : "Show" }}
            </CButton>
          </td>
        </template>
        <template #details="{ item }">
          <CCollapse
            :show="Boolean(item._toggled)"
            :duration="collapseDuration"
          >
            <CCardBody>
              <CMedia :aside-image-props="{ height: 102 }">
                <h4>
                  {{ item.name }}
                </h4>
                 <p class="text-muted">生日: {{ item.birthday }}</p>
                <p class="text-muted">紅利點數: {{ item.bonus }}</p>
                <p class="text-muted">註冊日期: {{ item.created_at }}</p>
                <CButton size="sm" color="info" class="">
                  User Settings
                </CButton>
                <CButton size="sm" color="info" class="ml-1" @click="orderRecord(item.id)">
                  訂購紀錄
                </CButton>
              </CMedia>
            </CCardBody>
          </CCollapse>
        </template>
      </CDataTable>
      <CPagination
        :activePage.sync="pagination.page"
        :pages.sync="pagination.totalPage"
        align="start"
        v-on:update:activePage="reloadData"
      />
      <CModal
      title="訂單列表"
      color="info"
      :show.sync="show"
      size="lg"
      >
          <CDataTable
          :items="userOrder"
          :fields="userOrderFields"
          items-per-page-select
          v-on:pagination-change="setUserOrderRows"
          >
          <template #index={item,index}>
                <td>{{index + 1}}</td>
            </template>
            <template #status="{ item }">
              <td>
                <CButton :color="statusColorDict[item.status_id]">
                  {{ statusDict[item.status_id] }}
                </CButton>
             </td>
            </template>
          <template #detail="{item}">
            <td>
              <CButton
              size="sm"
              color="info"
              class="ml-1"
              @click="showDetail(item.order_numero)"
              >詳細</CButton
            >
            </td>
              
            </template>
            <CPagination
            :activePage.sync="orderPagination.page"
            :pages.sync="orderPagination.totalPage"
            align="start"
            v-on:update:activePage="orderRecord(userId)"
      />
          </CDataTable>
      </CModal>
      <OrderDetailModal/>
    </CCardBody>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      items: [],
      userOrder:[],
      userId:null,
      show:false,
      searchColumn: null,
      searchValue: null,
      pagination: {
        page: 1,
        rows: 10,
        totalPage: 10,
        //orderBy:'id',
        //order:'desc',
      },
      orderPagination: {
        page: 1,
        rows: 10,
        totalPage: 10,
        //orderBy:'id',
        //order:'desc',
      },
      collapseDuration: 0,
      fields: [
        { key: "name", label: "會員名稱" },
        { key: "email", label: "Email" },
        { key: "role", label: "會員等級" },
        { key: "active", label: "狀態" },
        {
          key: "show_details",
          label: "_",
          _style: "width:1%",
          sorter: false,
          filter: false,
        },
      ],
      columns: [
        { label: "請選擇欄位", value: null },
        { label: "會員名稱", value: "name" },
        { label: "狀態", value: "active" },
        { label: "Email", value: "email" },
        { label: "日期", value: "created_at" },
      ],
      activeValue:[
        {label:'啟用中',value:"1"},
        {label:'未啟用',value:"0"}
      ],
      activeDict:{
          0:'未啟用',
          1:'啟用中'
      },
      colorDict:{
          0:'danger',
          1:'success'
      },
      statusColorDict: {
        0: "error",
        1: "warning",
        2: "info",
        3: "primary",
        4: "success",
        5: "secondary",
        6: "danger",
      },
      statusDict: {
        0: "代付款",
        1: "待出貨",
        2: "準備中",
        3: "已出貨",
        4: "已到貨",
        5: "結案",
        6: "作廢",
      },
      userOrderFields : [
        { key: "index", label: "#" },
        { key: "order_numero", label: "訂單編號" },
        { key: "status", label: "狀態" },
        { key: "total", label: "總價" },
        { key: "created_at", label: "日期" },
        { key: "detail", label: "詳細資訊" },
      ]
    };
  },
  watch: {
    searchColumn(val) {
      this.searchValue = null;
      if (val == null) {
        this.pagination.page = 1;
        this.reloadData();
      }
    },
    // pagination: {
    //     handler(){
    //         this.reloadData();
    //     }
    // }
  },
  created() {
    this.reloadData();
  },
  methods: {
    setRows(value) {
      this.pagination.rows = value;
      this.reloadData();
    },
    setUserOrderRows(value) {
      this.orderPagination.rows = value;
      this.orderRecord(this.userId);
    },
    reloadData() {
      axios
        .get("/api/member", {
          params: {
            pagination: this.pagination,
            column: this.searchColumn,
            value: this.searchValue,
          },
        })
        .then((res) => {
          this.items = res.data.data;
          this.pagination = res.data.pagination;
        })
        .catch((error) => {
          errorHelper.handle(error);
        });
    },
    toggleDetails(item,index) {
      this.$set(this.items[index], "_toggled", !item._toggled);
      this.collapseDuration = 300;
      this.$nextTick(() => {
        this.collapseDuration = 0;
      });
    },
    orderRecord(id){
        axios.get("/api/userOrder/"+id,{
          params: this.orderPagination,
        })
        .then(res => {
            this.userId=id;
            this.show=true;
            this.userOrder = res.data.data;
            this.orderPagination = res.data.pagination;
        })
        .catch(err => {
            errorHelper.handle(error); 
        })
    },
    showDetail(order_numero){
            EventBus.$emit("showDetailModal",order_numero);
        },
        searchByColumn() {
      this.pagination.page = 1;
      this.reloadData();
    },
  },
};
</script>

<style>
</style>