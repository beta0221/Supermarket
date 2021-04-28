<template>
    <CSidebar>
        <CSidebarBrand>
            <h3>Admin Panel</h3>
            <!-- <img src="logo" class="c-sidebar-brand-full"/>
            <img src="logo-minimized" class="c-sidebar-brand-minimized"/> -->
        </CSidebarBrand>
        
        <CSidebarNav>
            <CSidebarNavDropdown :name="'設定'">
                <CSidebarNavItem :name="'標籤(Attribute)'" to="/admin/attribute"></CSidebarNavItem>
                <CSidebarNavItem :name="'標籤群組(Attribute Set)'" to="/admin/attributeSet"></CSidebarNavItem>
                <CSidebarNavItem :name="'國家(Country))'" to="/admin/country"></CSidebarNavItem>
                <CSidebarNavItem :name="'物流(Carrier))'" to="/admin/carrier"></CSidebarNavItem>
                <CSidebarNavItem :name="'金流(Payment))'" to="/admin/payment"></CSidebarNavItem>
            </CSidebarNavDropdown>

            <CSidebarNavDropdown name="產品">
                <CSidebarNavItem name="產品(Product)" to="/admin/product"></CSidebarNavItem>
                <CSidebarNavItem name="產品特價(SpecificPrice))" to="/admin/specificPrice"></CSidebarNavItem>
                <CSidebarNavItem name="產品分類(Category)" to="/admin/category"></CSidebarNavItem>
                <!-- <CSidebarNavItem name="產品群組(Product Group)" to="/admin/productGroup"></CSidebarNavItem> -->
            </CSidebarNavDropdown>

            <CSidebarNavDropdown name="行銷">
                <CSidebarNavItem name="購物車規則" to="/admin/cartRule"></CSidebarNavItem>
            </CSidebarNavDropdown>

            <CSidebarNavDropdown name="前台">
                <CSidebarNavItem name="輪播牆" to="/admin/banner"></CSidebarNavItem>
            </CSidebarNavDropdown>
                

            <CSidebarNavDropdown name="會員">
                <CSidebarNavItem name="會員管理" to="/admin/member"></CSidebarNavItem>
            </CSidebarNavDropdown>

            <CSidebarNavDropdown name="訂單">
                <CSidebarNavItem name="訂單管理" to="/admin/order"></CSidebarNavItem>
            </CSidebarNavDropdown>

            <CSidebarNavItem name="訊息" to="/admin/message"></CSidebarNavItem>
            
        </CSidebarNav>
    </CSidebar>

</template>

<script>

export default {
    
}
</script>

<style>

</style>