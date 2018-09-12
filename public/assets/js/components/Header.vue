<template>
    <header>
        <div class="columns">
            <div class="column">
                <h1 class="title is-1">
                    {{ siteName }}
                </h1>
            </div>
            <div class="column">
                <a class="button is-dark is-pulled-right">Login</a>
            </div>
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
    header {
        padding: 20px;
    }
</style>