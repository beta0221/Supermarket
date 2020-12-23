<template>
    <div>
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
    </div>
</template>
<script>
export default {
    props:['items',],
    data(){
        return{
            show:false,
            orderProduct:[],
            orderProductFields : [
        { key: "name", label: "商品" },
        { key: "imageUrl", label: "圖片" },
        { key: "price", label: "價錢" },
        { key: "quantity", label: "數量" },
      ]
        }
    },
    mounted(){
        EventBus.$on("showDetailModal", order_numero => {
            this.orderDetail(order_numero);
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        orderDetail(order_numero) {
      axios
        .get("/api/order/getOrderDetail/"+order_numero )
        .then((res) => {
          this.show = true;
          this.orderProduct = res.data.orderProduct;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    }
}
</script>