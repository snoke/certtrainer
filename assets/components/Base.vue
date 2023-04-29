<!-- Author: Stefan Sander <mail@stefan-sander.online> -->
<template>
  <div id="app"> 
    <div>
        <router-view></router-view>
    </div>
  </div>
</template>

<style>
</style>


<script>
import App from './App';
export default {
  name: 'Base',
    components: {App},
  data: function() {
    return {
    }
  },
  methods: {
      go(page) {
        this.$router.push({ name: page})
      },
  },
  mounted: function() {
    this.go('app');
  },
}
</script>