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

            <CSidebarNavItem :name="'psycho'" ></CSidebarNavItem>
            <CSidebarNavItem :name="'hello'" to="/admin/category"></CSidebarNavItem>

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