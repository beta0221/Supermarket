<template>
  <div>
    <NavBar :title="'訂單管理'" />
    <CCardBody>
      <CButton size="sm" color="info" class="ml-1" @click="selectAll"
        >全選</CButton
      >
      <CButton
        size="sm"
        color="info"
        class="ml-1"
        @click="groupLastStatus"
        >上階段</CButton
      >
      <CButton
        size="sm"
        color="info"
        class="ml-1"
        @click="groupNextStatus"
        >下階段</CButton
      >
      <CButton
        size="sm"
        color="info"
        class="ml-1"
        @click="groupExportExcel"
        >匯出</CButton
      >
      <CSelect :value.sync="searchColumn" :options="columns" label="搜尋欄位"></CSelect>
      <CSelect v-if="(searchColumn=='status_id')" :value.sync="searchValue" :options="statusValue" placeholder="選擇狀態" @change="searchByColumn"></CSelect>
      <CInput v-if="(searchColumn=='buyer')" type="text" :value.sync="searchValue" @keyup.native.enter="searchByColumn"></CInput>
      <CInput v-if="(searchColumn=='order_numero')" type="text" :value.sync="searchValue" @keyup.native.enter="searchByColumn"></CInput>
      <CInput v-if="(searchColumn=='created_at')" type="date" :value.sync="searchValue"  @keyup.native.enter="searchByColumn"></CInput>
      
      <CDataTable
        :items="items"
        :fields="fields"
        items-per-page-select
        :items-per-page="10"
        v-on:pagination-change="setRows"
      >
        <template #checkbox="{ item }">
          <td>
            <CInputCheckbox
              :checked="item.isCheck"
              @change="changeChecked(item)"
            >
            </CInputCheckbox>
          </td>
        </template>

        <template #status="{ item }">
          <td>
            <CButton :color="colorDict[item.status_id]"
            @click="nextStatus(item.order_numero)">
              {{ statusDict[item.status_id] }}
            </CButton>
          </td>
        </template>

        <template #detail="{ item }">
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
      </CDataTable>

      <CPagination
        :activePage.sync="pagination.page"
        :pages.sync="pagination.totalPage"
        align="start"
        v-on:update:activePage="reloadData"
      />
      <OrderDetailModal
      />

    </CCardBody>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      show:false,
      checked: false,
      isSelectAll: false,
      items: [],
      orderProduct:[],
      pagination: {
        page: 1,
        rows: 10,
        totalPage: 10,
        //orderBy:'id',
        //order:'desc',
      },
      searchColumn:null,
      searchValue: null,
      columns:[
        { label:"請選擇欄位" ,value:null},
        { label: "訂單編號" ,value:'order_numero' },
        { label: "狀態" ,value:'status_id'},
        { label: "訂購人" ,value:'buyer'},
        { label: "日期" ,value:'created_at'},
      ],
      statusValue:[
        { label: "代付款" ,value:'0' },
        { label: "待出貨" ,value:'1'},
        { label: "準備中" ,value:'2'},
        { label: "已出貨" ,value:'3'},
        { label: "已到貨" ,value:'4'},
        { label: "結案" ,value:'5'},
        { label: "作廢" ,value:'6'},
      ],
      fields: [
        { key: "checkbox", label: "#" },
        { key: "order_numero", label: "訂單編號" },
        { key: "status", label: "狀態" },
        { key: "buyer", label: "訂購人" },
        { key: "created_at", label: "日期" },
        { key: "detail", label: "詳細資訊" },
      ],
      colorDict: {
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
      orderProductFields : [
        { key: "name", label: "商品" },
        { key: "imageUrl", label: "圖片" },
        { key: "price", label: "價錢" },
        { key: "quantity", label: "數量" },
      ]
    };
  },
  watch:{
        searchColumn(val){
            this.searchValue = null;
            if(val == null){
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
    searchByColumn(){
            this.pagination.page = 1;
            this.reloadData();
        },
    reloadData() {
      axios
        .get("/api/order/getOrderList", {
          params: {
            pagination:this.pagination,
            column:this.searchColumn,
            value:this.searchValue,
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
    showDetail(item) {
      EventBus.$emit("showDetailModal", item);
    },
    orderDetail($order_numero) {
      axios
        .get("/api/order/getOrderDetail/"+$order_numero )
        .then((res) => {
          this.show = true;
          this.orderProduct = res.data.orderProduct;
          console.log(this.orderProduct);
        })
        .catch((err) => {
          console.error(err);
        });
    },
    changeChecked(item) {
      item.isCheck = !item.isCheck;
    },
    selectAll() {
      this.isSelectAll = !this.isSelectAll;
      this.items.forEach((order, index) => {
        this.$set(order, "isCheck", this.isSelectAll);
      });
    },
    getCheckedOrderNumero() {
      let numeroArray = [];
      this.items.forEach((order) => {
        if (order.isCheck) {
          numeroArray.push(order.order_numero);
        }
      });
      return numeroArray;
    },
    groupExportExcel(){
            let order_numero_array = this.getCheckedOrderNumero();
            if(order_numero_array.length == 0){
                alert('請勾選');
                return;
            }
            window.open('/order/downloadOrderExcel?token='+localStorage.getItem('token') + '&order_numero_array='+order_numero_array.join(','))
        },
    groupNextStatus(){
            let order_numero_array = this.getCheckedOrderNumero();
            if(order_numero_array.length == 0){
                alert('請勾選');
                return;
            }
            axios.post('/api/order/groupNextStatus',{
                'order_numero_array':JSON.stringify(order_numero_array)
            })
            .then(res => {
                this.$router.go('/admin/order');
            })
            .catch(err => {
                console.error(err); 
            })
        },
    groupLastStatus(){
            let order_numero_array = this.getCheckedOrderNumero();
            if(order_numero_array.length == 0){
                alert('請勾選');
                return;
            }
            axios.post('/api/order/groupLastStatus',{
                'order_numero_array':JSON.stringify(order_numero_array)
            })
            .then(res => {
                this.$router.go('/admin/order');
            })
            .catch(err => {
                console.error(err); 
            })
        },
    nextStatus($order_numero){
      axios.post('/api/order/nextStatus/',{
                'order_numero':$order_numero
            })
      .then(res => {
        console.log(res);
        this.reloadData();
      })
      .catch(err => {
        console.error(err); 
      })
    },
    showDetail(order_numero){
            EventBus.$emit("showDetailModal",order_numero);
        }
  },
};
</script>

<style>
</style>