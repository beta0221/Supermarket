<template>
  <div>
    <CDataTable
      :items="items"
      :fields="fields"
      items-per-page-select
      :items-per-page="10"
      v-on:pagination-change="setRows"
      table-filter
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
</template>

<script>
export default {
  props: ["fields", "requestUrl"],
  data() {
    return {
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
      axios
        .get(this.requestUrl, {
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
  },
};
</script>

<style>
</style>