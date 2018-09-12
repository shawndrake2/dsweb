<template>
    <header>
        <h1 class="title is-1">
            {{ siteName }}
        </h1>
        <div class="">
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

<style lang="scss">

</style>