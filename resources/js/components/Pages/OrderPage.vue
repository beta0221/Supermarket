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
            <CButton :color="colorDict[item.shipping_address_id]">
              {{ statusDict[item.shipping_address_id] }}
            </CButton>
          </td>
        </template>

        <template #detail="{ item }">
          <td>
            <CButton
              size="sm"
              color="info"
              class="ml-1"
              @click="orderDetail(item)"
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
    </CCardBody>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      checked: false,
      isSelectAll: false,
      items: [],
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
      },
      statusDict: {
        0: "待出貨",
        1: "準備中",
        2: "已出貨",
        3: "已到貨",
        4: "結案",
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
    orderDetail(item) {
      console.log(item.order_numero);
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