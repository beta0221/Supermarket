<template>
    <CSidebar>
        <CSidebarBrand>
            <h3>Admin Panel</h3>
            <!-- <img src="logo" class="c-sidebar-brand-full"/>
            <img src="logo-minimized" class="c-sidebar-brand-minimized"/> -->
        </CSidebarBrand>
        
        <CSidebarNav>
            <CSidebarNavDropdown :name="'資料管理'">
                <CSidebarNavItem :name="'標籤(Attribute)'" to="/admin/attribute"></CSidebarNavItem>
                <CSidebarNavItem :name="'標籤群組(Attribute Set)'" to="/admin/attributeSet"></CSidebarNavItem>
                <CSidebarNavItem :name="'產品分類(Category)'" to="/admin/category"></CSidebarNavItem>
                <CSidebarNavItem :name="'產品群組(Product Group)'" to="/admin/productGroup"></CSidebarNavItem>
            </CSidebarNavDropdown>

                <CSidebarNavItem :name="'hello'"></CSidebarNavItem>

            <CSidebarNavDropdown :name="'fuck'">
                <CSidebarNavItem :name="'hello'"></CSidebarNavItem>
                <CSidebarNavItem :name="'psycho'"></CSidebarNavItem>
                <CSidebarNavItem :name="'hello'"></CSidebarNavItem>
            </CSidebarNavDropdown>
            
        </CSidebarNav>
    </CSidebar>

</template>

<script>

export default {
    
}
</script>

<style>

</style>