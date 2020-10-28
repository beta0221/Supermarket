<template>
    <CSidebar>
        <CSidebarBrand>
            <h3>Admin Panel</h3>
            <!-- <img src="logo" class="c-sidebar-brand-full"/>
            <img src="logo-minimized" class="c-sidebar-brand-minimized"/> -->
        </CSidebarBrand>
        
        <CSidebarNav>
            <CSidebarNavDropdown :name="'fuck'">
                <CSidebarNavItem :name="'hello'"></CSidebarNavItem>
            </CSidebarNavDropdown>

            <CSidebarNavItem :name="'標籤管理'" to="/admin/attribute"></CSidebarNavItem>
            <CSidebarNavItem :name="'產品類別管理'" to="/admin/category"></CSidebarNavItem>

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