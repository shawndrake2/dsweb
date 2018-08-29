<template>
    <header>
        <h1 class="logo">
            {{ siteName }}
        </h1>
        <div>
            <a href="#">Login</a>
        </div>
    </header>
</template>

<script>
export default {
  name: 'Header',
  props: {
    siteName: String
  }
}
</script>

<style>

</style>