<template>
  <div>
    <NavBar :title="'商品管理'" />
    <CCardBody>
      <CButton size="sm" color="info" class="ml-1" @click="selectAll"
        >全選</CButton
      >
      <CButton
        size="sm"
        color="info"
        class="ml-1"
        @click="getCheckedOrderNumero"
        >show</CButton
      >
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
            <CButton :color="colorDict[item.status_id]">
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
              @click="orderDetail(item.order_numero)"
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

      <CModal
      title="訂單內容"
      color="info"
      :show.sync="show"
      size="lg"
      >
          <CDataTable
          :items="orderProduct"
          :fields="orderProductFields"
          >
          <template #imageUrl="{item}">
            <td>
              <img
                :src="item.imageUrl"
                width="90px"
                height="90px"
                class="mt-1"
                style="align-middle"
              />
            </td>
              
            </template>
          </CDataTable>
      </CModal>

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

      fields: [
        { key: "checkbox", label: "#" },
        { key: "order_numero", label: "訂單編號" },
        { key: "status", label: "狀態" },
        { key: "buyer", label: "訂購人" },
        { key: "date", label: "日期" },
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
      axios
        .get("/api/order/all", {
          params: this.pagination,
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
    getCheckedOrderNumero() {
      let numeroArray = [];
      this.items.forEach((order) => {
        if (order.isCheck) {
          numeroArray.push(order.order_numero);
        }
      });
      console.log(numeroArray);
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
  },
};
</script>

<style>
</style>