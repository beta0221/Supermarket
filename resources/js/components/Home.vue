<template>
<div>

    <h1>Hello App!</h1>
    <div>
        <p>
            <router-link to="/admin/foo">Go to Foo</router-link>
        </p>
        <p>
            <router-link to="/admin/bar">Go to Bar</router-link>
        </p>
    </div>
    
    <div>
        <router-view></router-view>
    </div>
</div>
  

</template>

<script>
export default {

}
</script>

<style>

</style>